import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';
import process from 'node:process';
import { spawnSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';

const INTERNAL_DOCKER_ENV = 'OPTIMIZE_LIGHTHOUSE_INTERNAL_DOCKER_RUN';

function fileExists(filePath) {
  try {
    return fs.existsSync(filePath);
  } catch {
    return false;
  }
}

function findUpwards(startDir, targetName) {
  let currentDir = path.resolve(startDir);

  while (true) {
    const candidate = path.join(currentDir, targetName);
    if (fileExists(candidate)) {
      return candidate;
    }

    const parentDir = path.dirname(currentDir);
    if (parentDir === currentDir) {
      return null;
    }

    currentDir = parentDir;
  }
}

function getThemeRootFromModule() {
  const moduleDir = path.dirname(fileURLToPath(import.meta.url));
  return path.resolve(moduleDir, '..', '..', '..');
}

function getRepoRoot(themeRoot) {
  return path.resolve(themeRoot, '..', '..', '..');
}

function getWorkspaceRoot(repoRoot) {
  return path.resolve(repoRoot, '..');
}

function readJson(filePath) {
  return JSON.parse(fs.readFileSync(filePath, 'utf8'));
}

function readPlaywrightVersion(themeRoot) {
  const packageJsonPath = path.join(themeRoot, 'node_modules', 'playwright', 'package.json');
  if (!fileExists(packageJsonPath)) {
    return null;
  }

  const packageJson = readJson(packageJsonPath);
  return typeof packageJson.version === 'string' ? packageJson.version : null;
}

function extractComposeInfo(composePath) {
  if (!composePath || !fileExists(composePath)) {
    return null;
  }

  const raw = fs.readFileSync(composePath, 'utf8');

  const internalNetworkMatch = raw.match(/name:\s*(d11_internal)\b/m);
  const wordpressServiceMatch = raw.match(/^\s{2}(wordpress):\s*$/m);
  const wpcliServiceMatch = raw.match(/^\s{2}(wpcli):\s*$/m);

  if (!internalNetworkMatch || !wordpressServiceMatch || !wpcliServiceMatch) {
    return null;
  }

  return {
    composePath,
    internalNetworkName: internalNetworkMatch[1],
    wordpressService: wordpressServiceMatch[1],
    wpcliService: wpcliServiceMatch[1],
  };
}

function runCommand(command, args, options = {}) {
  return spawnSync(command, args, {
    encoding: 'utf8',
    stdio: ['ignore', 'pipe', 'pipe'],
    ...options,
  });
}

function isReachable(url) {
  const script = `
const target = ${JSON.stringify(url)};
const controller = new AbortController();
const timer = setTimeout(() => controller.abort(), 2500);
fetch(target, {
  method: 'HEAD',
  redirect: 'manual',
  signal: controller.signal,
}).then((response) => {
  clearTimeout(timer);
  process.stdout.write(String(response.status));
}).catch((error) => {
  clearTimeout(timer);
  process.stderr.write(error && error.message ? error.message : String(error));
  process.exit(1);
});
`;

  const result = runCommand(process.execPath, ['-e', script]);
  return result.status === 0;
}

function getDockerImage(themeRoot) {
  const version = readPlaywrightVersion(themeRoot);
  if (!version) {
    return null;
  }

  return `mcr.microsoft.com/playwright:v${version}-noble`;
}

function getWordPressHomeUrl(composeInfo, workspaceRoot) {
  if (!composeInfo) {
    return null;
  }

  const result = runCommand(
    'docker',
    [
      'compose',
      '-f',
      composeInfo.composePath,
      'exec',
      '-T',
      composeInfo.wpcliService,
      'bash',
      '-lc',
      'cd /var/www/html && wp option get home --allow-root',
    ],
    { cwd: workspaceRoot }
  );

  if (result.status !== 0) {
    return null;
  }

  const value = result.stdout.trim();
  try {
    return new URL(value).toString();
  } catch {
    return null;
  }
}

function getDockerAuditTarget(composeInfo) {
  return `http://${composeInfo.wordpressService}/`;
}

function getCanonicalHostMap(canonicalUrl, ipAddress) {
  if (!canonicalUrl || !ipAddress) {
    return null;
  }

  try {
    const parsedUrl = new URL(canonicalUrl);
    return parsedUrl.hostname ? { host: parsedUrl.hostname, ip: ipAddress } : null;
  } catch {
    return null;
  }
}

function getDockerServiceIp(composeInfo, workspaceRoot) {
  if (!composeInfo) {
    return null;
  }

  const containerIdResult = runCommand(
    'docker',
    ['compose', '-f', composeInfo.composePath, 'ps', '-q', composeInfo.wordpressService],
    { cwd: workspaceRoot }
  );

  if (containerIdResult.status !== 0) {
    return null;
  }

  const containerId = containerIdResult.stdout.trim();
  if (!containerId) {
    return null;
  }

  const inspectResult = runCommand(
    'docker',
    [
      'inspect',
      '-f',
      `{{with index .NetworkSettings.Networks "${composeInfo.internalNetworkName}"}}{{.IPAddress}}{{end}}`,
      containerId,
    ],
    { cwd: workspaceRoot }
  );

  if (inspectResult.status !== 0) {
    return null;
  }

  const ipAddress = inspectResult.stdout.trim();
  return ipAddress || null;
}

function buildDockerInvocation({
  image,
  networkName,
  repoRoot,
  themeRoot,
  originalArgv,
  auditUrl,
  canonicalUrl,
  hostMap,
}) {
  const repoMount = `${repoRoot}:/workspace`;
  const workdir = `/workspace/wp-content/themes/${path.basename(themeRoot)}`;

  const sanitizedArgs = originalArgv.filter(
    (arg) =>
      arg !== '--help' &&
      !arg.startsWith('--runner=') &&
      !arg.startsWith('--audit-url=') &&
      !arg.startsWith('--canonical-url=') &&
      arg.startsWith('--')
  );

  return [
    'run',
    '--rm',
    '--user',
    `${process.getuid?.() ?? 1000}:${process.getgid?.() ?? 1000}`,
    '--network',
    networkName,
    '-e',
    `${INTERNAL_DOCKER_ENV}=1`,
    '-v',
    repoMount,
    '-w',
    workdir,
    image,
    'node',
    'tools/optimize-lighthouse/cli/index.js',
    auditUrl,
    ...sanitizedArgs,
    '--runner=local',
    `--audit-url=${auditUrl}`,
    `--canonical-url=${canonicalUrl}`,
    ...(hostMap ? [`--host-map=${hostMap.host}:${hostMap.ip}`] : []),
  ];
}

export function parseRunner(value) {
  if (!['auto', 'local', 'docker'].includes(value)) {
    throw new Error(`Invalid runner: ${value}`);
  }

  return value;
}

function parseHostMap(value) {
  if (!value) {
    return null;
  }

  const [host, ip] = value.split(':');
  if (!host || !ip) {
    return null;
  }

  return { host, ip };
}

export function resolvePreflightContext({ argv, logger }) {
  const themeRoot = getThemeRootFromModule();
  const repoRoot = getRepoRoot(themeRoot);
  const workspaceRoot = getWorkspaceRoot(repoRoot);
  const composePath = findUpwards(repoRoot, 'docker-compose.yml');
  const composeInfo = extractComposeInfo(composePath);
  const canonicalUrl = getWordPressHomeUrl(composeInfo, workspaceRoot);
  const localReachable = canonicalUrl ? isReachable(canonicalUrl) : false;
  const dockerImage = getDockerImage(themeRoot);
  const dockerWordpressIp = composeInfo ? getDockerServiceIp(composeInfo, workspaceRoot) : null;
  const insideDockerRunner = process.env[INTERNAL_DOCKER_ENV] === '1';

  logger.debug('Resolved optimize-lighthouse preflight context', {
    themeRoot,
    repoRoot,
    workspaceRoot,
    canonicalUrl,
    localReachable,
    hasCompose: Boolean(composeInfo),
    dockerImage,
    dockerWordpressIp,
    insideDockerRunner,
  });

  return {
    themeRoot,
    repoRoot,
    workspaceRoot,
    composeInfo,
    canonicalUrl,
    localReachable,
    dockerImage,
    dockerWordpressIp,
    insideDockerRunner,
    originalArgv: argv,
  };
}

export function resolveExecutionPlan({ options, context, logger }) {
  const canonicalUrl = options.canonicalUrl || context.canonicalUrl || options.url;
  const explicitHostMap = parseHostMap(options.hostMap);
  const canonicalHostMap = getCanonicalHostMap(canonicalUrl, context.dockerWordpressIp);

  if (!canonicalUrl) {
    throw new Error(
      'Unable to resolve a canonical site URL for optimize-lighthouse. Set the URL explicitly or ensure wpcli can read the home option.'
    );
  }

  if (options.runner === 'docker') {
    if (context.insideDockerRunner) {
      return {
        runnerType: 'docker-local',
        canonicalUrl,
        auditUrl: options.auditUrl || options.url || canonicalUrl,
        hostMap: explicitHostMap ?? canonicalHostMap,
        note: 'Already running inside the Docker audit runner.',
      };
    }

    if (!context.composeInfo || !context.dockerImage) {
      throw new Error('Docker runner requested, but the D11 Docker audit environment could not be resolved.');
    }

    return {
      runnerType: 'docker-delegate',
      canonicalUrl,
      auditUrl: options.auditUrl || canonicalUrl || getDockerAuditTarget(context.composeInfo),
      note: 'Delegating the audit to the D11 Docker runner because docker was requested.',
      dockerCommand: buildDockerInvocation({
        image: context.dockerImage,
        networkName: context.composeInfo.internalNetworkName,
        repoRoot: context.repoRoot,
        themeRoot: context.themeRoot,
        originalArgv: context.originalArgv,
        auditUrl: options.auditUrl || canonicalUrl || getDockerAuditTarget(context.composeInfo),
        canonicalUrl,
        hostMap:
          explicitHostMap ??
          canonicalHostMap,
      }),
    };
  }

  if (options.runner === 'local') {
      return {
        runnerType: context.insideDockerRunner ? 'docker-local' : 'local',
        canonicalUrl,
        auditUrl: options.auditUrl || options.url || canonicalUrl,
        hostMap: explicitHostMap,
        note: context.insideDockerRunner
          ? 'Using the Docker runner local execution path.'
          : 'Using direct local execution.',
    };
  }

  if (context.insideDockerRunner) {
    return {
      runnerType: 'docker-local',
      canonicalUrl,
      auditUrl: options.auditUrl || options.url || canonicalUrl || getDockerAuditTarget(context.composeInfo ?? { wordpressService: 'wordpress' }),
      hostMap: explicitHostMap ?? canonicalHostMap,
      note: 'Continuing inside the Docker audit runner.',
    };
  }

  if (context.localReachable) {
    return {
      runnerType: 'local',
      canonicalUrl,
      auditUrl: options.auditUrl || options.url || canonicalUrl,
      note: 'Canonical URL is reachable from the current host. Using local execution.',
      hostMap: explicitHostMap,
    };
  }

  if (context.composeInfo && context.dockerImage) {
    const auditUrl = options.auditUrl || canonicalUrl || getDockerAuditTarget(context.composeInfo);

    return {
      runnerType: 'docker-delegate',
      canonicalUrl,
      auditUrl,
      note: 'Canonical URL is not reachable from the current host. Delegating to the D11 Docker audit runner.',
      dockerCommand: buildDockerInvocation({
        image: context.dockerImage,
        networkName: context.composeInfo.internalNetworkName,
        repoRoot: context.repoRoot,
        themeRoot: context.themeRoot,
        originalArgv: context.originalArgv,
        auditUrl,
        canonicalUrl,
        hostMap:
          explicitHostMap ??
          canonicalHostMap,
      }),
    };
  }

  throw new Error(
    [
      `Unable to reach ${canonicalUrl} from the current host and no D11 Docker fallback could be prepared.`,
      'Ensure d11.localhost resolves locally or provide a reachable audit URL and runner explicitly.',
    ].join(' ')
  );
}

export function delegateToDocker(plan, { cwd, logger }) {
  if (!plan.dockerCommand) {
    throw new Error('Missing docker delegation command.');
  }

  logger.info('Delegating optimize-lighthouse to Docker', {
    runnerType: plan.runnerType,
    auditUrl: plan.auditUrl,
    canonicalUrl: plan.canonicalUrl,
  });

  const [command, ...args] = plan.dockerCommand;
  const result = spawnSync(command, args, {
    cwd,
    stdio: 'inherit',
    env: {
      ...process.env,
      [INTERNAL_DOCKER_ENV]: '1',
    },
  });

  process.exitCode = result.status ?? 1;
}

export function getExecutionMeta(plan) {
  return {
    runnerType: plan.runnerType,
    canonicalUrl: plan.canonicalUrl,
    auditUrl: plan.auditUrl,
    note: plan.note,
    hostMap: plan.hostMap ?? null,
    host: os.hostname(),
  };
}

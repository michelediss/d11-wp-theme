import lighthouse from 'lighthouse';
import desktopConfig from 'lighthouse/core/config/desktop-config.js';

function getLighthouseConfig(device) {
  return device === 'desktop' ? desktopConfig : undefined;
}

function getThrottlingSettings(options) {
  if (options.throttling === 'off') {
    return {
      throttlingMethod: 'provided',
      throttling: {
        requestLatencyMs: 0,
        downloadThroughputKbps: 0,
        uploadThroughputKbps: 0,
        cpuSlowdownMultiplier: 1,
      },
    };
  }

  if (options.throttling === 'custom') {
    return {
      throttlingMethod: 'simulate',
      throttling: {
        requestLatencyMs: options.networkProfile.requestLatencyMs,
        downloadThroughputKbps: options.networkProfile.downloadThroughputKbps,
        uploadThroughputKbps: options.networkProfile.uploadThroughputKbps,
        cpuSlowdownMultiplier: options.cpuSlowdown,
      },
    };
  }

  return {};
}

export async function runLighthouseAudit({
  auditUrl,
  remoteDebuggingPort,
  device,
  timeout,
  throttling,
  cpuSlowdown,
  networkProfile,
  logger,
}) {
  const flags = {
    port: remoteDebuggingPort,
    output: 'json',
    logLevel: 'error',
    maxWaitForLoad: timeout,
    disableStorageReset: false,
    formFactor: device,
    screenEmulation:
      device === 'desktop'
        ? {
            mobile: false,
            width: 1440,
            height: 900,
            deviceScaleFactor: 1,
            disabled: false,
          }
        : undefined,
    ...getThrottlingSettings({
      throttling,
      cpuSlowdown,
      networkProfile,
    }),
  };

  logger.debug('Running Lighthouse', {
    auditUrl,
    port: remoteDebuggingPort,
    device,
    throttling,
  });

  const runnerResult = await lighthouse(auditUrl, flags, getLighthouseConfig(device));
  if (!runnerResult?.lhr) {
    throw new Error('Lighthouse did not return an LHR payload.');
  }

  return runnerResult;
}

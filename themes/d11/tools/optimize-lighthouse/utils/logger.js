const LEVELS = {
  debug: 10,
  info: 20,
  warn: 30,
  error: 40,
};

function normalizeLevel(level) {
  return LEVELS[level] ? level : 'info';
}

export function createLogger({ level = 'info', quiet = false } = {}) {
  const normalizedLevel = quiet ? 'error' : normalizeLevel(level);
  const threshold = LEVELS[normalizedLevel];

  function shouldLog(messageLevel) {
    return LEVELS[messageLevel] >= threshold;
  }

  function write(method, messageLevel, message, meta) {
    if (!shouldLog(messageLevel)) {
      return;
    }

    const formattedMeta = meta ? ` ${JSON.stringify(meta)}` : '';
    console[method](`[optimize-lighthouse] ${message}${formattedMeta}`);
  }

  return {
    debug(message, meta) {
      write('log', 'debug', message, meta);
    },
    info(message, meta) {
      write('log', 'info', message, meta);
    },
    warn(message, meta) {
      write('warn', 'warn', message, meta);
    },
    error(message, meta) {
      write('error', 'error', message, meta);
    },
  };
}

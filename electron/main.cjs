const { app, BrowserWindow, Menu, ipcMain } = require('electron');
const path = require('path');
const fs = require('fs');
const http = require('http');
const { spawn } = require('child_process');

const DEFAULT_PORT = process.env.LARAVEL_PORT || '8741';
const FALLBACK_URL = process.env.LARAVEL_URL || `http://127.0.0.1:${DEFAULT_PORT}`;

let phpProcess = null;

/** Bundled php.exe: in the packaged app (resources/php) or dev tree (runtime/php). */
function bundledPhpExecutable() {
  if (process.platform === 'win32') {
    const packaged = path.join(process.resourcesPath, 'php', 'php.exe');
    const dev = path.join(__dirname, '..', 'runtime', 'php', 'php.exe');
    if (app.isPackaged && fs.existsSync(packaged)) {
      return packaged;
    }
    if (!app.isPackaged && fs.existsSync(dev)) {
      return dev;
    }
    return null;
  }
  const devUnix = path.join(__dirname, '..', 'runtime', 'php', 'bin', 'php');
  if (!app.isPackaged && fs.existsSync(devUnix)) {
    return devUnix;
  }
  return null;
}

function resolvePhpCommand() {
  const bundled = bundledPhpExecutable();
  if (bundled) {
    return bundled;
  }
  return 'php';
}

function laravelRootPath() {
  if (app.isPackaged) {
    return path.join(process.resourcesPath, 'laravel');
  }
  return path.join(__dirname, '..');
}

function waitForHttp(url, timeoutMs = 20000) {
  const started = Date.now();
  return new Promise((resolve, reject) => {
    const tryOnce = () => {
      http
        .get(url, (res) => {
          res.resume();
          resolve();
        })
        .on('error', () => {
          if (Date.now() - started > timeoutMs) {
            reject(new Error('timeout'));
            return;
          }
          setTimeout(tryOnce, 250);
        });
    };
    tryOnce();
  });
}

/**
 * @returns {Promise<string|null>}
 */
function startPhpBuiltInServer(port) {
  const root = laravelRootPath();
  const publicDir = path.join(root, 'public');
  if (!fs.existsSync(path.join(publicDir, 'index.php'))) {
    return Promise.resolve(null);
  }

  const php = resolvePhpCommand();
  if (process.platform === 'win32' && php !== 'php' && !fs.existsSync(php)) {
    return Promise.resolve(null);
  }

  const args = ['-S', `127.0.0.1:${port}`, '-t', 'public'];
  const url = `http://127.0.0.1:${port}`;

  return new Promise((resolve, reject) => {
    phpProcess = spawn(php, args, {
      cwd: root,
      windowsHide: true,
      shell: process.platform === 'win32' && php === 'php',
    });

    phpProcess.on('error', (err) => {
      phpProcess = null;
      reject(err);
    });

    phpProcess.once('spawn', () => {
      waitForHttp(url)
        .then(() => resolve(url))
        .catch(reject);
    });
  });
}

function errorHtml(bodyHtml) {
  return `<!DOCTYPE html><html><head><meta charset="utf-8"><title>Restro</title></head><body style="font-family:sans-serif;padding:2rem;">${bodyHtml}</body></html>`;
}

function windowsPackagedPhpExePath() {
  if (process.platform !== 'win32' || !app.isPackaged) {
    return null;
  }
  return path.join(process.resourcesPath, 'php', 'php.exe');
}

async function resolveAppUrl() {
  const port = DEFAULT_PORT;
  const root = laravelRootPath();
  const hasLaravel = fs.existsSync(path.join(root, 'public', 'index.php'));
  const packagedPhpExe = windowsPackagedPhpExePath();
  const hasPhpInPackage = packagedPhpExe && fs.existsSync(packagedPhpExe);

  const shouldTryBuiltIn =
    hasLaravel &&
    (bundledPhpExecutable() !== null ||
      resolvePhpCommand() === 'php' ||
      process.platform !== 'win32');

  let lastError = null;
  if (shouldTryBuiltIn) {
    try {
      const url = await startPhpBuiltInServer(port);
      if (url) {
        return url;
      }
    } catch (err) {
      lastError = err;
    }
  }

  if (process.platform === 'win32' && hasLaravel && app.isPackaged && !hasPhpInPackage) {
    const enoent = lastError && lastError.code === 'ENOENT';
    if (enoent) {
      return {
        error: errorHtml(
          `<h1>No PHP bundled in this application</h1>
          <p>This <code>.exe</code> was built <strong>without</strong> <code>php.exe</code> in the package (the <code>resources/php</code> folder was empty at build time).</p>
          <p>On your <strong>development machine</strong>, unzip the Windows PHP bundle (x64 Thread Safe) so you have:</p>
          <pre style="background:#f4f4f4;padding:1rem;">runtime/php/php.exe</pre>
          <p>Then rebuild:</p>
          <pre style="background:#f4f4f4;padding:1rem;">npm run electron:build:win</pre>
          <p>Alternatively: install PHP on the target Windows PC and ensure <code>php</code> is on the PATH.</p>`
        ),
      };
    }
    return {
      error: errorHtml(
        `<h1>Laravel server not ready</h1>
        <p>PHP may be installed, but the built-in server is not responding at <code>http://127.0.0.1:${port}</code>.</p>
        <p>Check: the port is not in use by another app, antivirus/firewall rules, or PHP errors (missing DLLs/extensions).</p>`
      ),
    };
  }

  return { fallback: FALLBACK_URL };
}

const MENU = {
  application: 'Menu Bar',
  // webDev: 'WebDev',
  exit: 'Exit',
};

function buildAppActionsSubmenu(isMac) {
  return [
    ...(isMac ? [{ role: 'about' }, { type: 'separator' }] : []),
    {
      label: MENU.webDev,
      accelerator: isMac ? 'Alt+Command+I' : 'F12',
      click: (_, focusedWindow) => {
        const w = focusedWindow || BrowserWindow.getFocusedWindow();
        if (w && !w.isDestroyed()) {
          w.webContents.toggleDevTools();
        }
      },
    },
    { type: 'separator' },
    isMac
      ? { label: MENU.exit, role: 'quit' }
      : {
          label: MENU.exit,
          accelerator: 'Ctrl+Q',
          click: () => app.quit(),
        },
  ];
}

function setMainMenu() {
  const isMac = process.platform === 'darwin';
  const template = [
    {
      label: isMac ? app.name : MENU.application,
      submenu: buildAppActionsSubmenu(isMac),
    },
  ];
  Menu.setApplicationMenu(Menu.buildFromTemplate(template));
}

function attachContextMenu(win) {
  win.webContents.on('context-menu', (event) => {
    event.preventDefault();
    const menu = Menu.buildFromTemplate([
      {
        label: MENU.webDev,
        click: () => {
          if (!win.isDestroyed()) {
            win.webContents.toggleDevTools();
          }
        },
      },
      { type: 'separator' },
      {
        label: MENU.exit,
        click: () => app.quit(),
      },
    ]);
    menu.popup({ window: win });
  });
}

function createWindow() {
  const win = new BrowserWindow({
    width: 1920,
    height: 1080,
    frame: true,
    // kiosk: true,
    fullscreen: true,
    fullscreenable: true,
    autoHideMenuBar: true,
    // titleBarStyle: 'hidden',
    titleBarOverlay: {
      color: '#2c3e50',
      symbolColor: '#ffffff',
    },
    webPreferences: {
      contextIsolation: true,
      preload: path.join(__dirname, 'preload.cjs'),
    },
  });

  attachContextMenu(win);

  resolveAppUrl().then((result) => {
    if (result && result.error) {
      win.loadURL('data:text/html;charset=utf-8,' + encodeURIComponent(result.error));
      return;
    }
    const url = result && result.fallback ? result.fallback : result;
    win.loadURL(url).catch(() => {
      win.loadURL(
        'data:text/html;charset=utf-8,' +
          encodeURIComponent(
            errorHtml(
              `<h1>Could not connect to Laravel</h1>
              <p>Start the Laravel server, for example:</p>
              <pre style="background:#f4f4f4;padding:1rem;">php artisan serve</pre>
              <p>Or set a URL (Windows):</p>
              <pre style="background:#f4f4f4;padding:1rem;">set LARAVEL_URL=http://127.0.0.1:8000</pre>`
            )
          )
      );
    });
  });
}

ipcMain.on('app-quit', () => {
  app.quit();
});

app.whenReady().then(() => {
  setMainMenu();
  createWindow();
});

app.on('before-quit', () => {
  if (phpProcess && !phpProcess.killed) {
    phpProcess.kill();
    phpProcess = null;
  }
});

app.on('window-all-closed', () => {
  app.quit();
});

app.on('activate', () => {
  if (BrowserWindow.getAllWindows().length === 0) {
    createWindow();
  }
});

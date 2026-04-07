const { contextBridge, ipcRenderer } = require('electron');

contextBridge.exposeInMainWorld('electronApp', {
  quit: () => ipcRenderer.send('app-quit'),
});

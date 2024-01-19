// customBuildPlugin.js
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

function customBuildTimberstrap() {
  let sassFilesLastModified = {};

  function getSassFilesLastModified() {
    return fs.readdirSync('./sass').reduce((acc, file) => {
      const fullPath = path.join('./sass', file);
      acc[fullPath] = fs.statSync(fullPath).mtimeMs;
      return acc;
    }, {});
  }

  function hasSassFilesChanged() {
    const currentModified = getSassFilesLastModified();
    const filesChanged = Object.keys(currentModified).some(
      file => sassFilesLastModified[file] !== currentModified[file]
    );
    sassFilesLastModified = currentModified;
    return filesChanged;
  }

  function recompileSass() {
    console.log('Recompiling SASS...');
    execSync('npx sass ./sass/main.scss ./css-output/bundle.css');
  }

  return {
    name: 'custom-build',
    buildStart() {
      console.log('Starting build...');
      recompileSass();
      execSync('node ./extensions/inc/assets/createBundle.mjs');
      execSync('npx tailwindcss -i ./css-output/bundle.css -o ./css-output/tailwind.css --minify');
      console.log('Build completed.');
    },
    handleHotUpdate({ server }) {
      console.log('Detected change, checking for SASS updates...');
      if (hasSassFilesChanged()) {
        recompileSass();
      }
      execSync('node ./extensions/inc/assets/createBundle.mjs');
      execSync('npx tailwindcss -i ./css-output/bundle.css -o ./css-output/tailwind.css --minify');
      console.log('Scripts re-executed.');
      server.ws.send({ type: 'full-reload' });
      return [];
    },
    configureServer(server) {
       server.middlewares.use((req, res, next) => {
        if (req.url === '/rebuild') {
          console.log('Rebuild requested, executing build commands...');
          try {
            // execSync('npx sass ./sass/main.scss ./css-output/bundle.css'); not needed in editor
            execSync('node ./extensions/inc/assets/createBundle.mjs');
            execSync('npx tailwindcss -i ./css-output/bundle.css -o ./css-output/tailwind.css --minify');
            console.log('Build commands executed.');
            res.end('Rebuild successful');
          } catch (error) {
            console.error('Error executing build commands:', error);
            res.statusCode = 500;
            res.end('Error executing build commands');
          }
        } else {
          next();
        }
      });
    },
  }
}

module.exports = customBuildTimberstrap;

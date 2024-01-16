import { defineConfig } from 'vite';
import path from 'path';
import { execSync } from 'child_process';

function customBuildPlugin() {
  return {
    name: 'custom-build',
    buildStart() {
      console.log('Starting build...');
      execSync('npx sass ./sass/main.scss ./css-output/bundle.css');
      execSync('node ./scripts/createBundle.mjs');
      execSync('npx tailwindcss -i ./css-output/bundle.css -o ./css-output/tailwind.css --minify');
      console.log('Build completed.');
    },
    handleHotUpdate({ server }) {
      console.log('Detected change, re-running scripts...');
      execSync('npx sass ./sass/main.scss ./css-output/bundle.css');
      execSync('node ./scripts/createBundle.mjs');
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
            execSync('node ./scripts/createBundle.mjs');
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


export default defineConfig({
  root: path.join(__dirname, './scripts'), // Set the root to the directory containing index.html
  build: {
    outDir: path.join(__dirname, './dist'), // Set the output directory to ./dist at the project root
    rollupOptions: {
      input: path.join(__dirname, './scripts/index.html') // Explicitly specify the entry point
    }
  },
  server: {
    host: '0.0.0.0', // Use '0.0.0.0' to accept connections from all IPs or set a specific host
    port: 3000, // Set your desired port
    // Uncomment the next line to always open in the browser
    // open: true,
  },
  plugins: [customBuildPlugin()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
});
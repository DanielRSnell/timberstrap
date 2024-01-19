import { defineConfig } from 'vite';
import path from 'path';
import customBuildTimberstrap from './extensions/inc/assets/customBuildTimberstrap';
import checkEnv from './extensions/inc/assets/checkEnv.mjs';

if (!checkEnv()) {
  console.log('Enviroment check failed. Exiting Vite...');
  process.exit(1);
}

export default defineConfig({
  root: path.join(__dirname, './extensions/inc/assets'), // Set the root to the directory containing index.html
  build: {
    outDir: path.join(__dirname, './dist'), // Set the output directory to ./dist at the project root
    rollupOptions: {
      input: path.join(__dirname, './extensions/inc/assets/index.html') // Explicitly specify the entry point
    }
  },
  server: {
    host: '0.0.0.0', // Use '0.0.0.0' to accept connections from all IPs or set a specific host
    port: 3000, // Set your desired port
    // Uncomment the next line to always open in the browser
    // open: true,
  },
  plugins: [customBuildTimberstrap()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
});
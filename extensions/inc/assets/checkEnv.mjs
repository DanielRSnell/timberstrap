// checkEnv.mjs
import fs from 'fs';
import dotenv from 'dotenv';

// ANSI escape codes for colors
const colors = {
    reset: '\x1b[0m',
    red: '\x1b[31m',
    yellow: '\x1b[33m',
    green: '\x1b[32m',
};

const checkEnv = () => {
    // Check if .env file exists
    if (!fs.existsSync('.env')) {
        console.error(`${colors.red}.env file is missing.${colors.reset}`);
        return false;
    }

    // Load environment variables from .env file
    dotenv.config();

    // Check for VITE_WP_LOCAL_URL variable
    const viteWpLocalUrl = process.env.VITE_WP_LOCAL_URL;
    if (viteWpLocalUrl === 'http://timberstrap-example.local') {
        console.log(`${colors.red}VITE_WP_LOCAL_URL is set to the default value of http://timberstrap-example.local.${colors.reset}`);
        console.log(`${colors.red}Please update VITE_WP_LOCAL_URL in your .env file to the appropriate local URL.${colors.reset}`);
        return false;
    } else if (!viteWpLocalUrl) {
        console.log(`${colors.red}VITE_WP_LOCAL_URL is not set. Please ensure it is defined in your .env file.${colors.reset}`);
        return false;
    } else {
        console.log(`${colors.green}VITE_WP_LOCAL_URL is set correctly.${colors.reset}`);
        console.log(`${colors.green}VITE_ENDPOINT=/wp-json/timberstrap/v1${colors.reset}`);
        return true;
    }
};

export default checkEnv;

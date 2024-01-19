// Import modules
import fetch from 'node-fetch';
import { writeFile, appendFile } from 'fs/promises';
import dotenv from 'dotenv';



dotenv.config();
const wp_local = process.env.VITE_WP_LOCAL_URL;
const endpoint = process.env.VITE_ENDPOINT;

// ANSI escape codes for colors
const colors = {
    reset: '\x1b[0m',
    red: '\x1b[31m',
    yellow: '\x1b[33m',
    green: '\x1b[32m',
};



function unescapeJavaScriptString(str) {
    return str
        .replace(/\\n/g, "\n")   // Replace escaped newlines with actual newlines
        .replace(/\\t/g, "")     // Remove escaped tabs
        .replace(/\\"/g, '"')    // Replace escaped double quotes with actual double quotes
        .replace(/\\\\/g, '\\')  // Replace double backslashes with a single backslash
        .replace(/\\\//g, '/');  // Replace escaped forward slashes with actual forward slashes
}

async function updateIndexHtml() {

    
    try {
        // Construct the URLs
        const html_url = wp_local + endpoint + '/fetch_content';
        const css_url = wp_local + endpoint + '/fetch_css';

        // Fetch HTML content
        const htmlResponse = await fetch(html_url);
        let htmlContent = await htmlResponse.text();
        htmlContent = unescapeJavaScriptString(htmlContent);

        // Fetch CSS content
        const cssResponse = await fetch(css_url);

        // Path to the index.html file and bundle.css
        const indexPath = './extensions/inc/assets/index.html';
        const cssPath = './css-output/bundle.css';

        // Template for index.html
        const htmlTemplate = `
        <html>
        <head>
        </head>
        <body>
            ${htmlContent}
        </body>
        </html>
        `;

        // Write the unescaped HTML content to index.html
        await writeFile(indexPath, htmlTemplate, 'utf8');
        console.log('index.html has been updated successfully');

       if (cssResponse.ok) {
            // The request was successful, proceed with reading and appending the content
            const cssContent = await cssResponse.text();
            await appendFile(cssPath, unescapeJavaScriptString(cssContent).split('"').join(''), 'utf8');
            console.error(`${colors.green}Customizer CSS was founded and added to bundle.${colors.reset}`);

        } else {
            // There was an error (e.g., 404 Not Found), handle or log it accordingly
            console.error(`${colors.yellow}Failed to fetching Customizer CSS: ${colors.reset}`, cssResponse.statusText);
            console.error(`${colors.yellow}This is not required, processes will resume as normal. ${colors.reset}`);

        }

        console.log('CSS content has been appended to bundle.css successfully');
    } catch (error) {
        console.error('Error occurred:', error);
    }
    
}

updateIndexHtml();


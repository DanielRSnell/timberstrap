// Import modules
import fetch from 'node-fetch';
import { writeFile, appendFile } from 'fs/promises';
import dotenv from 'dotenv';


dotenv.config();
const wp_local = process.env.VITE_WP_LOCAL_URL;
const endpoint = process.env.VITE_ENDPOINT;

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
        const cssContent = await cssResponse.text();

        // Path to the index.html file and bundle.css
        const indexPath = './scripts/index.html';
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

        if (!cssContent.data) {
            // Append the fetched CSS content to bundle.css
            await appendFile(cssPath, unescapeJavaScriptString(cssContent).split('"').join(''), 'utf8');
        }

        console.log('CSS content has been appended to bundle.css successfully');
    } catch (error) {
        console.error('Error occurred:', error);
    }
}

updateIndexHtml();


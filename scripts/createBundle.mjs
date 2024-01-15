// Import modules
import getConfig from './config.mjs';
import fetch from 'node-fetch';
import { writeFile } from 'fs/promises';

const config = getConfig();

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
        // Construct the URL
        const url = config.url + config.endpoint;
        console.log(url, config, 'endpoint url');

        // Fetch the data
        const response = await fetch(url);
        let htmlContent = await response.text();

        // Unescape the HTML content
        htmlContent = unescapeJavaScriptString(htmlContent);

        // Path to the index.html file
        const indexPath = './scripts/index.html';

        // Write the unescaped HTML content to index.html
        await writeFile(indexPath, htmlContent, 'utf8');

        console.log('index.html has been updated successfully');
    } catch (error) {
        console.error('Error occurred:', error);
    }
}

updateIndexHtml();

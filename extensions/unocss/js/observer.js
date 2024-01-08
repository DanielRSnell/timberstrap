document.addEventListener("DOMContentLoaded", function() {
    // Retrieve nonce, post ID, and post type from cookies
    var nonce = getCookie('timberstrap-wpNonce');
    var postId = getCookie('timberstrap-postId');
    var postType = getCookie('timberstrap-postType');

    // Check if required data is available
    if (!nonce || !postId || !postType) {
        console.log('Required data is missing, mutation observer will not run.');
        return;
    }

    // Function to initialize the Mutation Observer
    function initializeObserver() {
        var preflightsElement = document.querySelector('style[data-unocss-runtime-layer="preflights"]');
        var shortcutsElement = document.querySelector('style[data-unocss-runtime-layer="shortcuts"]');
        var defaultElement = document.querySelector('style[data-unocss-runtime-layer="default"]');

        // Check if all elements are available
        if (preflightsElement && shortcutsElement && defaultElement) {
            console.log('All elements found. Initializing Mutation Observer.');
            setupMutationObserver([preflightsElement, shortcutsElement, defaultElement]);
            sendDataToWordPress(); // Initial call to send data
        } else {
            console.log('Waiting for elements...');
            setTimeout(initializeObserver, 100); // Retry after 100 milliseconds
        }
    }

    // Function to set up the Mutation Observer
    function setupMutationObserver(elementsToObserve) {
        console.log(`Setting up Mutation Observer.`);
        var observer = new MutationObserver(function(mutations) {
            console.log('Mutation Observer triggered.');
            sendDataToWordPress(); // Send data on mutation
        });

        var config = { childList: true, subtree: true, characterData: true };

        elementsToObserve.forEach(function(element) {
            observer.observe(element, config);
            console.log('Observation started on:', element);
        });
    }

    // Function to send collected data to WordPress
    function sendDataToWordPress() {
        try {
            var preflights = document.querySelector('style[data-unocss-runtime-layer="preflights"]')?.innerHTML || '';
            var shortcuts = document.querySelector('style[data-unocss-runtime-layer="shortcuts"]')?.innerHTML || '';
            var defaultLayer = document.querySelector('style[data-unocss-runtime-layer="default"]')?.innerHTML || '';

            var styles = {
                preflights: preflights,
                shortcuts: shortcuts,
                default: defaultLayer
            };

            // AJAX request to the WordPress REST API
            fetch('/wp-json/timberstrap/v1/save_styles/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': nonce
                },
                body: JSON.stringify({
                    post_id: postId,
                    post_type: postType,
                    styles: styles
                })
            })
            .then(response => response.json())
            .then(data => console.log('Response from WordPress:', data))
            .catch(error => console.error('Error sending data to WordPress:', error));
        } catch (error) {
            console.error('Error in sendDataToWordPress function:', error);
        }
    }

    // Helper function to get cookie value by name
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    // Start the initialization process
    initializeObserver();
});

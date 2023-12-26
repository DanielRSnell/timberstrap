// Assuming you have already created the Ace Editor instance
var lc_html_editor = ace.edit("lc-html-editor");

// Initialize the suggestions array with Tailwind CSS classes
var smartClasses = suggestions;

// Create a custom Ace Editor completer for the autocomplete suggestions
var smartCompleter = {
  getCompletions: function (editor, session, pos, prefix, callback) {
    // Filter the autocomplete suggestions based on the prefix
    var completions = smartClasses
      .filter((item) => {
        // Modification to search params or payload client side
        return item.caption.startsWith(prefix)
      })
      .map(function (item) {
        return {
          caption: item.caption,
          value: item.value,
          meta: item.meta,
        };
      });

    // Call the callback function with the completions
    callback(null, completions);
  },
};

// Add the Tailwind CSS completer to the Ace Editor instance
lc_html_editor.completers = [smartCompleter];

// Configure other Ace Editor options as needed
lc_html_editor.setOptions({
  enableBasicAutocompletion: true,
  enableLiveAutocompletion: true,
  showPrintMargin: false,
  highlightActiveLine: false,
  mode: "ace/mode/html",
  wrap: true,
  useSoftTabs: false,
  tabSize: 4,
  enableEmmet: true,
});
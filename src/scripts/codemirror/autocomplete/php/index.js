/**
 * php AutoCompletion for CodeMirror 6 
 * 
 * @see https://www.php.net/manual/en/funcref.php
 */
const phpSnippets = require('./php.json');

let phpCompletions = [];

Object.entries(phpSnippets).forEach((snippet) => {
    phpCompletions.push(snippet[1]);
});

export default phpCompletions;
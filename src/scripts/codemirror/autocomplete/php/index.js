/**
 * php AutoCompletion for CodeMirror 6 
 * 
 * @see https://www.php.net/manual/en/funcref.php
 */
const phpSnippets = require('./php.json');

let options = [];

Object.entries(phpSnippets).forEach((snippet) => {
    options.push(snippet[1]);
});

export default function phpCompletions(context) {
    let word = context.matchBefore(/\w*/)
    if (word.from == word.to && !context.explicit){
        return null
    }
    return {
        from: word.from,
        options: options
    }
}
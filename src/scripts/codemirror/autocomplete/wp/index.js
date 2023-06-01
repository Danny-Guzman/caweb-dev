/**
 * WordPress AutoCompletion for CodeMirror 6 
 * 
 * This uses the same JSON that is used in the WordPress Snippets Visual Studio Code Extension.
 * 
 * A request is made to the raw json file found on Github, if file isn't found then use the local file as a fallback.
 * 
 * @see https://codemirror.net/docs/ref/#autocomplete.Completion
 * @see https://marketplace.visualstudio.com/items?itemName=wordpresstoolbox.wordpress-toolbox 
 * @see https://github.com/jason-pomerleau/vscode-wordpress-toolbox/
 */
const snippetJSONURL = 'https://raw.githubusercontent.com/jason-pomerleau/vscode-wordpress-toolbox/master/snippets/snippets.json';

let snippets = await fetch(snippetJSONURL).then((response) => response.json() )

let options = [];

Object.entries(snippets).forEach((snippet) => {
    let type = snippet.toString().substring(0, snippet.toString().indexOf(': '));
    let func = snippet[1].body.toString().replace(/\$\{\d:\\|\}/g, '');
    
    let completion = {
        label: func,
        info: snippet[1].description,
        apply: func
    }

    switch(type){
        case 'Class':
            completion.type = 'class';
            break;
        case 'Constant':
            completion.type = 'constant';
            break;
        case 'ƒ':
            completion.type = 'function';
            break;
    }
    options.push(completion);
});

export default function wpCompletions(context) {
    let word = context.matchBefore(/\w*/)
    if (word.from == word.to && !context.explicit){
        return null
    }
    return {
        from: word.from,
        options: options
    }
}
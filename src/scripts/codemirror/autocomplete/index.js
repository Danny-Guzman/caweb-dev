import {phpLanguage} from "@codemirror/lang-php";

import phpCompletions from "./php";
import wpCompletions from "./wp";

function autoCompleteOptions(context){
    let word = context.matchBefore(/\w*/)
    if (word.from == word.to && !context.explicit){
        return null
    }

    return {
        from: word.from,
        options: [].concat(
            phpCompletions, 
            wpCompletions
        )
    }
}

const autoCompletions = [ phpLanguage.data.of( { autocomplete: autoCompleteOptions } ) ];

export default autoCompletions;
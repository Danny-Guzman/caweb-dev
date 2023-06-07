/**
 * Syntax Highlighting
 * 
 * @see https://codemirror.net/examples/styling/#highlighting
 */

import {tags} from "@lezer/highlight"
import { syntaxHighlighting, HighlightStyle } from "@codemirror/language"

const defaultStyle = syntaxHighlighting(
    HighlightStyle.define(
        [
            {
                tag: tags.comment,
                color: 'green'
            },
            {
                tag: tags.bool,
                color: 'blue'
            },
            {
                tag: tags.null,
                color: 'blue'
            },
            {
                tag: tags.literal,
                color: 'brown'
            },
            {
                tag: tags.keyword,
                color: 'darkmagenta'
            },
            {
                tag: tags.definitionKeyword,
                color: 'blue'
            },
            {
                tag: tags.controlKeyword,
                color: 'darkmagenta'
            },
            {
                tag: tags.processingInstruction,
                color: 'blue'
            },
            {
                tag: tags.function(tags.variableName),
                color: 'darkkhaki'
            },
            {
                tag: tags.name,
                color: 'blue'
            },
            {
                tag: tags.variableName,
                color: 'black'
            }
        ],
        {
            themeType: 'light'
        }
    )
);

export {
    defaultStyle
}
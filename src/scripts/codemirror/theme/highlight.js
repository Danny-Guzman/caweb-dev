/**
 * Syntax Highlighting
 * 
 * @see https://codemirror.net/examples/styling/#highlighting
 */

import {Tag, tags} from "@lezer/highlight"
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
                color: 'darkkhaki'
            },
            {
                tag: tags.definitionKeyword,
                color: 'blue'
            },
            {
                tag: tags.controlKeyword,
                color: 'darkmagenta'
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
import {EditorView, basicSetup } from "codemirror";
import {Compartment} from "@codemirror/state";
import {php} from "@codemirror/lang-php";

import keyMapping from './keymap';
import toolBar from "./toolbar";
import {wordCounter} from './utils';
import linting from './lint';
import autoCompletions from "./autocomplete";
import {light} from "./theme";
import showOutput from "./output";

const phpMsg = `<?php\n/*\n * For information: \n * https://www.php.net/\n * https://www.w3schools.com/php/\n */\n\n// Sample Code\nprint_r( 'Hello World!' );\n\n?>`
const sqlMsg = `-- For information: \n-- https://www.w3schools.com/sql/\n\n-- Sample Query\nSHOW TABLES;`;

const languageConf = new Compartment;
const themeConf = new Compartment;

  /*
    const languageDetection = EditorState.transactionExtender.of(tr => {
      if (!tr.docChanged){ 
        return null;
      }
    })
    */

const preferredSetup = [
        languageConf.of( php() ),
        themeConf.of( light ),
        keyMapping,
        toolBar,
        wordCounter,
        linting,
        //autoCompletions
    ];
    
export {
    preferredSetup,
    phpMsg,
    sqlMsg
};
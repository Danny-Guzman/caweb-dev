import {EditorView, basicSetup } from "codemirror";
import {keymap} from "@codemirror/view";
import {defaultKeymap, history, historyKeymap, indentWithTab} from "@codemirror/commands";
import {syntaxHighlighting, defaultHighlightStyle} from "@codemirror/language"
import {EditorState} from "@codemirror/state";

import {phpMsg, toolBar} from './_toolbar';
import {showOutput} from './_output';
import {wordCounter} from './_wordcount';
import {regexLinter, lintGutter} from './lint';


jQuery(document).ready(function($) {

  let editor_parent = document.getElementById('odwpi-editor');
  
  if( editor_parent ){
    
    let editor_container = document.createElement('DIV');
    editor_container.id = 'odwpi-editor-container';
    editor_parent.append(editor_container)

    const languageDetection = EditorState.transactionExtender.of(tr => {
      if (!tr.docChanged){ 
        return null;
      }
    })

    let editor = new EditorView({
      parent: editor_container,
      doc: phpMsg,
      extensions: [
        basicSetup,
        history(),
        keymap.of([...defaultKeymap, ...historyKeymap, indentWithTab]),
        EditorView.lineWrapping,
        EditorView.editorAttributes.of({class: 'border border-3'}),
        syntaxHighlighting(defaultHighlightStyle),
        toolBar(),
        wordCounter(),
        regexLinter, 
        lintGutter()
      ]
    })

    
    showOutput(editor)

  }

});

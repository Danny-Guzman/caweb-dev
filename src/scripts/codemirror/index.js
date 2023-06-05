import {EditorView, basicSetup } from "codemirror";

import {preferredSetup, phpMsg} from './config';
import showOutput from './output';

let editor_parent = document.getElementById('odwpi-editor');
  
if( editor_parent ){
  
  let editor_container = document.createElement('DIV');
  editor_container.id = 'odwpi-editor-container';
  editor_parent.append(editor_container)

  new EditorView({
    parent: editor_container,
    doc: phpMsg,
    extensions: [
      basicSetup,
      EditorView.lineWrapping,
      EditorView.editorAttributes.of({class: 'border border-3'}),
      preferredSetup,
    ]
  })
  

  showOutput(editor_parent);

}
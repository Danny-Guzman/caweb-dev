import {showPanel} from "@codemirror/view";
import {language} from "@codemirror/language"
import {Compartment, EditorState} from "@codemirror/state";

import {php, phpLanguage} from "@codemirror/lang-php";
import {javascript} from "@codemirror/lang-javascript";
import {sql} from "@codemirror/lang-sql";

import {phpCompletions, wpCompletions} from "./autocomplete";

const languageConf = new Compartment

const phpMsg = `<?php\n/*\n * For information: \n * https://www.php.net/\n * https://www.w3schools.com/php/\n */\n\n// Sample Code\nprint_r( 'Hello World!' );\n\n?>`
const sqlMsg = `-- For information: \n-- https://www.w3schools.com/sql/\n\n-- Sample Query\nSHOW TABLES;`;



const langSelector = (view) => {
  var modeDiv = document.createElement('DIV');
  var modeLbl = document.createElement('SPAN');

  var phpInput = document.createElement('INPUT');
  var phpLbl = document.createElement('LABEL');
  var sqlInput = document.createElement('INPUT');
  var sqlLbl = document.createElement('LABEL');

  modeDiv.classList.add('align-self-center', 'p-2');

  modeLbl.classList.add('me-3');
  modeLbl.innerHTML = 'Select a mode:';
  
  // php
  phpInput.type = 'radio';
  phpInput.value = 'php';
  phpInput.name = 'modeOption';
  phpInput.checked = true;
  phpInput.id = 'phpMode';
  phpInput.classList.add('btn-check');

  phpInput.addEventListener('change', function(){
    view.dispatch({ 
      effects: languageConf.reconfigure( php() ),
      changes: {
        from: 0,
        to: view.state.doc.length,
        insert: phpMsg
      }  
    })
  })

  phpLbl.innerHTML = 'PHP';
  phpLbl.classList.add('btn', 'btn-outline-secondary', 'btn-sm', 'me-2');
  phpLbl.setAttribute('for', 'phpMode');

  // sql
  sqlInput.type = 'radio';
  sqlInput.value = 'sql';
  sqlInput.name = 'modeOption';
  sqlInput.id = 'sqlMode';
  sqlInput.classList.add('btn-check');

  sqlInput.addEventListener('change', function(){
    view.dispatch({ 
      effects: languageConf.reconfigure( sql({ upperCaseKeywords: true }) ),
      changes: {
        from: 0,
        to: view.state.doc.length,
        insert: sqlMsg
      }  
    })
  })

  sqlLbl.innerHTML = 'SQL';
  sqlLbl.classList.add('btn', 'btn-outline-secondary', 'btn-sm');
  sqlLbl.setAttribute('for', 'sqlMode');


  modeDiv.append(modeLbl);
  modeDiv.append(phpInput);
  modeDiv.append(phpLbl);
  modeDiv.append(sqlInput);
  modeDiv.append(sqlLbl);

  return modeDiv;
}

const addSpinner = ( msg = 'Evaluating your code...this may take a moment') => {
  var spinnerDiv = document.createElement('DIV');
  var spinner = document.createElement('DIV');
  var spinnerMsg = document.createElement('SPAN');
  var spinnerLbl = document.createElement('STRONG');

  spinnerDiv.classList.add('d-flex', 'justify-content-center');

  spinner.classList.add('spinner-border', 'spinner-border-sm');
  spinner.role = 'status';

  spinnerMsg.classList.add('visually-hidden') ;
  spinnerMsg.innerHTML = msg;
  
  spinnerLbl.classList.add('me-2');
  spinnerLbl.innerHTML = msg;

  spinner.append(spinnerMsg);

  spinnerDiv.append(spinnerLbl);
  spinnerDiv.append(spinner);

  return spinnerDiv;
}

const runCommand = (cmd) => {
  var output = document.getElementById('odwpi-editor-output-view');
  var fd = new FormData();
  let  mode = document.querySelector('input[name="modeOption"]:checked').value;

  output.innerHTML = ''
  output.appendChild(addSpinner());

  fd.append("action", "odwpi_dev_code");
  fd.append("odwpi_dev_nonce", document.getElementById('odwpi_dev_nonce').value );
  fd.append("odwpi_dev_coding_string", cmd);
  fd.append("odwpi_dev_coding_mode", mode);

  jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    contentType: false,
    processData: false,
    data: fd,
    success: function(response) {
      output.innerHTML = response;
    },
  });
}

const playButton = (view) => {
  var playButton = document.createElement('A');

  // play button
  playButton.id = 'odwpi-editor-execute';
  playButton.classList.add('bi', 'bi-play-fill', 'text-success', 'cursor-pointer', 'fs-4', 'border-end', 'border-2', 'text-center', 'w-100', 'align-self-center');
  
  // add listeners
  playButton.addEventListener('click', () => {
    runCommand(view.state.doc.toString())
  } )

  return playButton;
}

const toolBarPanel = (view) => {
  var toolbarDiv = document.createElement('DIV');

  // toolbar container
  toolbarDiv.id = 'odwpi-editor-toolbar';
  toolbarDiv.classList.add('border', 'border-3', 'd-flex');

  toolbarDiv.append(playButton(view));
  toolbarDiv.append(langSelector(view));


  return {
    dom: toolbarDiv,
    top: true
  }
}

const toolBar = (view) => {
  return [
    showPanel.of(toolBarPanel), 
    languageConf.of( php() ),
    phpLanguage.data.of( {
      autocomplete: phpCompletions
    } ),
    phpLanguage.data.of( {
      autocomplete: wpCompletions
    } )
  ]
} 


export {phpMsg, sqlMsg, toolBar}
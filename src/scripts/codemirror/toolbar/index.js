import {showPanel} from "@codemirror/view";

import {execute, test, switchLanguages} from '../commands';

function langSelector(view){
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
    switchLanguages(view);
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
    switchLanguages(view, 'sql');
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

function playButton(view){
  var playButton = document.createElement('BUTTON');

  // play button
  playButton.id = 'odwpi-editor-execute';
  playButton.classList.add('bg-transparent', 'bi', 'bi-play-fill', 'text-success', 'fs-4', 'border-0', 'border-end', 'border-2', 'text-center', 'w-100', 'align-self-center');
  playButton.setAttribute('tabindex', 0);
  // add listeners
  playButton.addEventListener('click', () => {
    execute(view)
  } )

  return playButton;
}

function testButton(view){
  var testButton = document.createElement('BUTTON');

  // test button
  testButton.id = 'odwpi-editor-execute';
  testButton.classList.add('bg-transparent', 'bi', 'bi-code-slash', 'text-danger', 'fs-4', 'border-0', 'text-center', 'w-100', 'align-self-center');
  testButton.setAttribute('tabindex', 0);
  // add listeners
  testButton.addEventListener('click', () => {
    test(view)
  } )

  return testButton;
}

function toolBarPanel(view){
  var toolbarDiv = document.createElement('DIV');

  // toolbar container
  toolbarDiv.id = 'odwpi-editor-toolbar';
  toolbarDiv.classList.add('border', 'border-3', 'd-flex');

  toolbarDiv.append(playButton(view));
  toolbarDiv.append(langSelector(view));
  toolbarDiv.append(testButton(view));


  return {
    dom: toolbarDiv,
    top: true
  }
}

const toolBar = [ showPanel.of(toolBarPanel) ];

export default toolBar
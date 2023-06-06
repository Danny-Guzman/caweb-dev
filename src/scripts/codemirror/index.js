import {EditorView, basicSetup } from "codemirror";

import {preferredSetup, phpMsg} from './config';

class ODWPI_IDE extends HTMLElement {
  key = 'odwpi-editor';

  constructor(){
    super();

    let editor_container = document.createElement('DIV');

    editor_container.id = `${this.key}-container`;

    // create a codemirror component
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

    this.append(editor_container);
    
    this.showOutput();

  }

  showOutput(){
    var outputDiv = document.createElement('DIV');
    var outputView = document.createElement('PRE');
  
    // header
    var headerDiv = document.createElement('DIV');
    var headerLbl = document.createElement('STRONG');
  
    // top scroll
    var topScrollDiv = document.createElement('DIV');
    var scrollDiv1 = document.createElement('DIV');
  
    // output container
    outputDiv.id = `${this.key}-output`;

    outputDiv.classList.add('border', 'border-3');

    // header
    headerDiv.id = `${this.key}-output-toolbar`;
    headerDiv.classList.add('d-flex', 'border', 'border-3');

    headerLbl.classList.add('align-self-center', 'p-2', 'me-auto');
    headerLbl.innerText = 'Output:';

    // top scroll
    topScrollDiv.id = `${this.key}-output-topscroll`;
    topScrollDiv.classList.add('border-3', 'border-top', 'hidden');

    scrollDiv1.classList.add('scroll-div1');

    // output view
    outputView.id = `${this.key}-output-view`;
    outputView.classList.add('mb-0', 'border-top', 'border-bottom', 'p-3', 'h-100');

    // append elements appropriately
    headerDiv.append(headerLbl);
    headerDiv.append(this.addThreeDots());

    topScrollDiv.append(scrollDiv1);

    outputDiv.append(headerDiv);
    outputDiv.append(topScrollDiv);
    outputDiv.append(outputView);

    this.append(outputDiv);

    // dock output to the right
    this.dockToRight();


    // add event listeners
    topScrollDiv.addEventListener('scroll', function(e){
      document.getElementById('odwpi-editor-output-view').scrollLeft = e.target.scrollLeft;
    })

    outputView.addEventListener('DOMSubtreeModified', this.OutputViewUpdated )
    outputView.addEventListener('scroll', function(e){
      document.getElementById('odwpi-editor-output-topscroll').scrollLeft = e.target.scrollLeft;
    });

  }

  addThreeDots(){
    var threeDotDropdown = document.createElement('DIV'); 
    var threeDotButton = document.createElement('BUTTON');

    var threeDotContextMenu = document.createElement('UL');

    // docking li
    var dockLI = document.createElement('LI');
    var dockLbl = document.createElement('SPAN');
    var dockBottom = document.createElement('A');
    var dockRight = document.createElement('A');

    threeDotDropdown.classList.add('dropdown');

    // threeDotButton
    threeDotButton.classList.add('btn',  'btn-sm', 'dropdown-toggle', 'bi', 'bi-three-dots-vertical', 'text-secondary', 'fs-4');
    threeDotButton.href = "#";
    threeDotButton.ariaExpanded = false;
    threeDotButton.dataset.bsToggle = "dropdown";
    threeDotButton.setAttribute('tabindex', 0);

    // context menu
    threeDotContextMenu.classList.add('dropdown-menu', 'p-2');

    // Docking
    dockLI.classList.add('d-flex', 'align-items-center');

    dockLbl.classList.add('me-auto');
    dockLbl.innerText = 'Dock';

    // dock bottom
    dockBottom.classList.add('dropdown-item', 'bi', 'bi-box-arrow-down', 'p-0', 'text-center', 'cursor-pointer');
    dockBottom.addEventListener('click', this.dockToBottom )

    // dock right
    dockRight.classList.add('dropdown-item', 'bi', 'bi-box-arrow-right', 'p-0', 'text-center', 'cursor-pointer');
    dockRight.addEventListener('click', this.dockToRight )

    dockLI.append(dockLbl)
    dockLI.append(dockBottom);
    dockLI.append(dockRight);

    threeDotContextMenu.append(dockLI);

    threeDotDropdown.append(threeDotButton);

    threeDotDropdown.append(threeDotContextMenu);

    return threeDotDropdown;
  }
  
  dockToBottom(){
    // parent container
    document.getElementById('odwpi-editor').classList.remove('row');

    // editor
    document.getElementById('odwpi-editor-container').classList.remove('col-sm-12', 'col-md-6', 'pe-0');

    // output 
    document.getElementById('odwpi-editor-output').classList.remove('col-sm-12', 'col-md-6', 'p-0');

    this.OutputViewUpdated();
  }

  dockToRight(){
    // parent container
    this.classList.add('row');

    // editor
    document.getElementById('odwpi-editor-container').classList.add('col-sm-12', 'col-md-6', 'pe-0');

    // output 
    document.getElementById('odwpi-editor-output').classList.add('col-sm-12', 'col-md-6', 'p-0');

    this.OutputViewUpdated();

  }
  
  OutputViewUpdated(){
    let outputView = document.getElementById('odwpi-editor-output-view')

    let topScrollDiv = document.getElementById('odwpi-editor-output-topscroll');
    let topScroll = topScrollDiv.firstChild;

    let hasScrollbars = outputView.scrollWidth > outputView.clientWidth;

    topScrollDiv.classList.add('hidden')
    topScroll.style.width = '0px';

    if(hasScrollbars){
      topScrollDiv.classList.remove('hidden')
      topScroll.style.width = outputView.scrollWidth + 'px';
    }

  }
}

customElements.define('odwpi-ide', ODWPI_IDE);
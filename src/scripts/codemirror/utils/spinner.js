
export default function addSpinner( container, msg = 'Evaluating your code...this may take a moment'){
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
  
    container.appendChild(spinnerDiv);
  }
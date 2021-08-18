/* ODWPI Helper Functions */

function isUrl(s) {
  rx_url=new RegExp('^(?:https?|s?ftp):\/\/|^(?:www)\.', 'i');

  return rx_url.test(s);

}

function goToUrl(){
  window.open(this.innerHTML, '_blank'); 
}
  function retrieveInputData(inputs, data){
    inputs.each(function(i, input){
      switch( input.type ){
        case 'radio':
          if( input.checked ){
            data.append(input.name, input.value);
          }
          break;
  
        case 'checkbox':
            data.append(input.name, input.checked);
          break;
        case 'file':
          $.each(input.files, function(f, file){
            data.append(input.name + "-" + f, file); 
          })
          break;
        default:
            data.append(input.name, input.value);
          break;
      }
      
    });
  
    return data;
  }
  
var $ = jQuery.noConflict();

$(document).ready(function(){		
  

});

function retrieveInputData(inputs, data = new FormData()){
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

function sortSelectOptions( selectBox , pattern = '', flags = ''){
  do {
    var isSorted = true;

    selectBox.each(function(index, option){
      if( undefined !== selectBox[index + 1]  ){
        var curVal = option.value;
        var nextOption = selectBox[index + 1];
        var nextVal = nextOption.value;
  
        if( pattern.trim() ){
          var regEx = new RegExp(pattern, flags); 
          curVal = regEx.exec(option.value);
          nextVal = regEx.exec(nextOption.value);
        }else{
          nextVal = nextVal.value;
        }
        
        if(curVal > nextVal){
          $(nextOption).insertBefore( $(option) );
          selectBox[index] = nextOption;
          selectBox[index + 1] = option;
          isSorted = false;
        }
      }
    });
  }
  while ( ! isSorted );

  
}
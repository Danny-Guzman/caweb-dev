var $ = jQuery.noConflict();

$(document).ready(function(){		
  

});

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
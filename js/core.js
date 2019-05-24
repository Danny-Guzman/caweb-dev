var $ = jQuery.noConflict();

$(document).ready(function(){		

  
  $('.odwpi-nav-tab').click(function() {
    var tabs = $('.odwpi-nav-tab');
    var selected_tab = $(this).attr('href');

    tabs.each(function( index, value ) {
      if( selected_tab !== $(value).attr("href") ){
        $(value).removeClass('nav-tab-active');
        $( $(value).attr("href") ).addClass('hidden');
      }else{
        $(value).addClass('nav-tab-active');
        $( selected_tab ).removeClass('hidden');
      }
    });

    $('#tab_selected').value = selected_tab;
  });

  $('#addDev').click(function(e) {
    e.preventDefault();

    var allUsers = $('#allUsers option:selected');
    var devUsers = $('#devUsers');

    allUsers.each(function(index, value){
      devUsers.append(value);
    });

    sortSelectOptions( devUsers.find('option'), "(\\d+)(?!.*\\d)" );  
  });

  $('#removeDev').click(function(e) {
    e.preventDefault();

    var devUsers = $('#devUsers option:selected');
    var allUsers = $('#allUsers');

    devUsers.each(function(index, value){
      allUsers.append(value);
    });


    sortSelectOptions( allUsers.find('option'), "(\\d+)(?!.*\\d)" );  
    
  });

  
  $('textarea').keydown(function (e) {
    var keyCode = e.keyCode || e.which;

    if (keyCode === $.ui.keyCode.TAB) {
        e.preventDefault();

        const TAB_SIZE = 4;

        // The one-liner that does the magic
        document.execCommand('insertText', false, ' '.repeat(TAB_SIZE));
    }
  });

  
 $('button#odwpi_sql_query').click(function(){

  var output = $('pre#odwpi_output_screen');

  var query = $('textarea#odwpi_query_string').val();		

  output.html('Querying the WordPress Database...this may take a moment');		

  var data = {
    'action': 'odwpi_dev_query',
    'query_string' : query
  };

  jQuery.post(ajaxurl, data, function(response) {
      output.html( response );
  })
    .error(function(jqXHR, textStatus, errorThrown) {
      output.html( errorThrown );
    });

});

$('button#odwpi_php_coding').click(function(){

  var output = $('pre#odwpi_output_screen');

  var code = $('textarea#odwpi_coding_string').val();

  output.html('Evaluating your code...this may take a moment');		

  var data = {
    'action': 'odwpi_dev_code',
    'coding_string' : code
  };

  jQuery.post(ajaxurl, data, function(response) {
      output.html(response);
  })
    .error(function(jqXHR, textStatus, errorThrown) {
      output.html(errorThrown);
    });	

});

  $('#testDev').click(function(e) {
    e.preventDefault();
    var pattern = "(\\d+)(?!.*\\d)" ;
    
    var regEx = new RegExp(pattern, 'g'); 
    curVal = regEx.exec('da-2nny-6-1');

    console.log(curVal);
    
  });
});
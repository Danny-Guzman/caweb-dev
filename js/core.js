var $ = jQuery.noConflict();

$(document).ready(function(){		

  $('[data-toggle="tooltip"]').tooltip();

  $('form#odwpi_form').submit(function(){ 
    $('#devUsers option').prop('selected', true);
    this.submit(); 
  });


  $('.odwpi-nav-tab').bind('classChanged', function(data){ 
    var tab = $(data.target);
    
    if( tab.hasClass('nav-tab-active') ){
      if( 'gitHubTab' == tab.attr('name') ){
        $('#git-info').removeClass('hidden');
        $('#outputTab').removeClass('w-50');
        $('#outputTab').addClass('w-75');
      }else{
        $('#git-info').addClass('hidden');
        $('#outputTab').addClass('w-50');
        $('#outputTab').removeClass('w-75');
      }
    }
  });

  $('.odwpi-nav-tab').click(function() {
    var tabs = $('.odwpi-nav-tab');
    var selected_tab = $(this).attr('name');

    tabs.each(function( index, value ) {
      if( selected_tab !== $(value).attr("name") ){
        $(value).removeClass('nav-tab-active');
        $( "#" +  $(value).attr("name") ).addClass('hidden');
      }else{
        $(value).addClass('nav-tab-active');
        $( "#" + selected_tab ).removeClass('hidden');
      }
      $(value).trigger('classChanged');
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
  var code = $('textarea#odwpi_php_coding_string').val();

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

$('button#odwpi_git_api').click(function(){

  if( ! $('input[name="gitUser"]').val().trim() ){
    alert('User/Organization Name can not be blank.');
    return;
  }
  var output = $('pre#odwpi_output_screen');
  var inputs = $('div#gitHubTab input');
  var modalInfo = $('div#odwpi_git_info');


  output.html('Testing API with your parameters...this may take a moment');		
  
  var data = {
    'action': 'odwpi_github_api_test'
  };

  inputs.each(function(i, gitInput){
    switch( gitInput.type ){
      case 'radio':
        if( gitInput.checked ){
          data[gitInput.name] = gitInput.value;
        }

        break;

      case 'checkbox':
        data[gitInput.name] = gitInput.checked;
        break;
      
      default:
        data[gitInput.name] = gitInput.value;
        break;
    }
    if( 'radio' === gitInput.type ){
      if( gitInput.checked )
      data[gitInput.name] = gitInput.value;
    }else if( 'checkbox' === gitInput.type ){
      data[gitInput.name] =  gitInput.checked;
    }else{

    }
    
  });

  jQuery.post(ajaxurl, data, function(response) {

      modalInfo.html(response.info);
      
      if( response.git_request_body instanceof Object ){
        output.html(JSON.stringify(response.git_request_body, null, '\t'));
      }else{
        output.html( response.git_request_body );
      }
  })
    .error(function(jqXHR, textStatus, errorThrown) {
      output.html(errorThrown);
    });	
});

  $('#gitHubTab input[name="gitPrivateRepo"]').on('change', function(){
    var gitToken = $('#gitHubTab input[name="gitToken"]');

    if( this.checked ){
      gitToken.removeClass('hidden');
      gitToken.prev().removeClass('hidden');
    }else{
      gitToken.addClass('hidden');
      gitToken.prev().addClass('hidden');
    }
    
  });

  $('#gitHubTab input[name="gitRepo"]').on('change keyup paste', function(e){
    if( this.value.trim() ){
      $('.git-private-group').removeClass('hidden');
    }else{
      $('.git-private-group').addClass('hidden');
    }
  });

  $('#testDev').click(function(e) {
    e.preventDefault();
    var pattern = "(\\d+)(?!.*\\d)" ;
    
    var regEx = new RegExp(pattern, 'g'); 
    curVal = regEx.exec('da-2nny-6-1');

    console.log(curVal);
    
  });
});
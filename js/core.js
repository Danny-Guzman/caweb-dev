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
  var fd = new FormData();

  output.html('Querying the WordPress Database...this may take a moment');		

  fd.append("action", "odwpi_dev_query");

  retrieveInputData($('textarea#odwpi_query_string'), fd);

  jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    contentType: false,
    processData: false,
    data: fd,
    success: function(response) {
      output.html(response);
    }
  });

});

$('button#odwpi_php_coding').click(function(){

  var output = $('pre#odwpi_output_screen');
  var fd = new FormData();

  output.html('Evaluating your code...this may take a moment');		

  fd.append("action", "odwpi_dev_code");

  retrieveInputData($('textarea#odwpi_php_coding_string'), fd);

  jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    contentType: false,
    processData: false,
    data: fd,
    success: function(response) {
      output.html(response);
    }
  });

});

$('button#odwpi_git_api').click(function(){

  if( ! $('input[name="gitUser"]').val().trim() ){
    alert('User/Organization Name can not be blank.');
    return;
  }
  var output = $('pre#odwpi_output_screen');
  var modalInfo = $('div#odwpi_git_info');
  var fd = new FormData();

  output.html('Testing API with your parameters...this may take a moment');		
  
  fd.append("action", "odwpi_github_api_test");

  retrieveInputData($('div#gitHubTab input'), fd);
  
  
  jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    contentType: false,
    processData: false,
    data: fd,
    success: function(response) {
        modalInfo.html(response.info);
        
        if( response.git_request_body instanceof Object ){
          output.html(JSON.stringify(response.git_request_body, null, '\t'));
        }else{
          output.html( response.git_request_body );
        }
    }
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

  $('#tfsTab #odwpi_tfs_migrate').click(function(){

    var output = $('pre#odwpi_output_screen');
    var fd = new FormData();

    output.html('Migrating Work Items');

    fd.append("action", "odwpi_tfs_wit_migration");

    retrieveInputData($('div#tfsTab input'), fd);

    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      contentType: false,
      processData: false,
      data: fd,
      success: function(response) {
        console.log(response);
      }
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
jQuery(document).ready(function($) {
  "use strict";
  
  /* PHP Code */
  $('button#odwpi_dev_php_coding').click(function(){

    var output = $('pre#odwpi_dev_output_screen');
    var fd = new FormData();
  
    output.html('Evaluating your code...this may take a moment');		
  
    fd.append("action", "odwpi_dev_code");
    fd.append("odwpi_dev_panel", $('input[name="odwpi_dev_panel_nonce"]').val() );
    fd.append("odwpi_dev_php_coding_string", $('#odwpi_dev_php_coding_string + .CodeMirror').get(0).CodeMirror.getValue());
    

    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      contentType: false,
      processData: false,
      data: fd,
      success: function(response) {
        output.html(response);
      },
    });
  
  });

  $('textarea#odwpi_dev_php_coding_string').keydown(function (e) {
    var keyCode = e.keyCode || e.which;

    if (keyCode === $.ui.keyCode.TAB) {
        e.preventDefault();

        // The one-liner that does the magic
        document.execCommand('insertText', false, ' '.repeat(4));
    }
  });

  /* SQL Query */
  $('button#odwpi_sql_query').click(function(){

    var output = $('pre#odwpi_dev_output_screen');
    var fd = new FormData();
  
    output.html('Querying the WordPress Database...this may take a moment');		
  
    fd.append("action", "odwpi_dev_query");
    fd.append("odwpi_dev_panel", $('input[name="odwpi_dev_panel_nonce"]').val() );
    fd.append("odwpi_dev_query_string", $('#odwpi_dev_query_string + .CodeMirror').get(0).CodeMirror.getValue() );
  
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

  /* GitHub */
  $('button#odwpi_dev_git_api').click(function(){

    if( ! $('input[name="git_user"]').val().trim() ){
      alert('User/Organization Name can not be blank.');
      return;
    }
    var output = $('pre#odwpi_dev_output_screen');
    var modalInfo = $('div#odwpi_dev_git_info');
    var fd = new FormData();
  
    output.html('Testing API with your parameters...this may take a moment');		
    
    fd.append("action", "odwpi_dev_github_api_test");
    fd.append("odwpi_dev_panel", $('input[name="odwpi_dev_panel_nonce"]').val() );
  
    retrieveInputData($('div#github input'), fd);
    
    
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

  $('#github input[name="git_repo"]').on('change keyup paste', function(e){
    if( this.value.trim() ){
      $('.git-private-group').removeClass('hidden');
    }else{
      $('.git-private-group').addClass('hidden');
    }
  });

  $('#github input[name="git_private_repo"]').on('change', function(){
    var gitToken = $(this).parent().next();

    if( this.checked ){
      gitToken.removeClass('hidden');
    }else{
      gitToken.addClass('hidden');
    }
    
  });

  
});
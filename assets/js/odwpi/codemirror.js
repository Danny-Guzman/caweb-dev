jQuery(document).ready(function($) {
    "use strict";
    const rx_word = "\" "; // Define what separates a word
  
    if( $('#odwpi_dev_php_coding_string').length ){
      var php_coding_editor = CodeMirror.fromTextArea(document.getElementById('odwpi_dev_php_coding_string'), {
        lineNumbers: true,
        lineWrapping: true,
        autoCloseBrackets: true,
        autoCloseTags: true,
        mode: 'php',
        indentUnit: 4,
        indentWithTabs: true, 
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
      });
  
      php_coding_editor.addOverlay({
        token: function(stream) {
          let ch = stream.peek();
          let word = "";
    
          if (rx_word.includes(ch) || ch==='\uE000' || ch==='\uE001') {
            stream.next();
            return null;
          }
    
          while ((ch = stream.peek()) && !rx_word.includes(ch)) {
            word += ch;
            stream.next();
          }
    
          if (isUrl(word)) return "url"; // CSS class: cm-url
        }},	
        { opaque : true }  // opaque will remove any spelling overlay etc
      );
  
      php_coding_editor.on('change', function(){
        setTimeout(function(){
          $('.cm-url').on('click', goToUrl)
        }, 100);
        
      })
    }
    
    if( $('#odwpi_dev_query_string').length ){
      var sql_coding_editor = CodeMirror.fromTextArea(document.getElementById('odwpi_dev_query_string'), {
        lineNumbers: true,
        lineWrapping: true,
        mode: 'sql',
        indentUnit: 4,
        indentWithTabs: true
      });
    }
    
    $('.cm-url').on('click', goToUrl);

  });
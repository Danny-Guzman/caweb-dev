var $ = jQuery.noConflict();

$(document).ready(function(){		

 $('#querying').click(function(){

   var output = document.getElementById('output_screen');

   var query = document.getElementById('query_string').value;		

   output.innerHTML = 'Querying the WordPress Database...this may take a moment';		

   var data = {
     'action': 'odwpi_dev_query',
     'query_string' : query
   };

   jQuery.post(ajaxurl, data, function(response) {
       output.innerHTML = response;
   })
     .error(function(jqXHR, textStatus, errorThrown) {
       output.innerHTML = errorThrown;
     });

 });

   

   $('#coding').click(function(){

   var output = document.getElementById('output_screen');

   var code = document.getElementById('coding_string').value;

   output.innerHTML = 'Evaluating your code...this may take a moment';		

   var data = {
     'action': 'odwpi_dev_code',
     'coding_string' : code
   };

   jQuery.post(ajaxurl, data, function(response) {
       output.innerHTML = response;
   })
     .error(function(jqXHR, textStatus, errorThrown) {
       output.innerHTML = errorThrown;

     });	

 });

});
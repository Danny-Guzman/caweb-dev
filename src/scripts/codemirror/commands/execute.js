import { addSpinner } from "../utils";

export default function execute(view){
    var output = document.getElementById('odwpi-editor-output-view');
    var fd = new FormData();
    let  mode = document.querySelector('input[name="modeOption"]:checked').value;
  
    output.innerHTML = ''

    addSpinner(output);
  
    fd.append("action", "odwpi_dev_code");
    fd.append("odwpi_dev_nonce", document.getElementById('odwpi_dev_nonce').value );
    fd.append("odwpi_dev_coding_string", view.state.doc.toString());
    fd.append("odwpi_dev_coding_mode", mode);
  
    jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      contentType: false,
      processData: false,
      data: fd,
      success: function(response) {
        output.innerHTML = response;
      },
    });
}
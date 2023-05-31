import * as bootstrap from "bootstrap";

jQuery(document).ready(function($) {

    if( $('#odwpi-dev-modal').length ){
        const portModal = new bootstrap.Modal(document.getElementById('odwpi-dev-modal'));
    }

    $('#import-file').on('click', (e) => {
        let fd = new FormData($('#odwpi-dev-import')[0]);

        $.each($('#odwpi-dev-import #importFile')[0].files, (i, file) => {
            fd.append('file-' + i, file);
        })

        
        // portModal.show();

        jQuery.post({
			url: $('#odwpi-dev-import').attr('action'),
			type: 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function( response ){
                console.log(response)
                // update modal body
                $('#odwpi-dev-modal .modal-title').html('Done!');

                // update modal body
                $('#odwpi-dev-modal .modal-body').html('<h5>Export completed successfully.</h5>');

                // show the footer
                $('#odwpi-dev-modal .modal-footer').removeClass('d-none');
			}
		});
    })

});
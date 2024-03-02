import * as bootstrap from "bootstrap";

jQuery(document).ready(function($) {

    if( $('#caweb-dev-modal').length ){
        const portModal = new bootstrap.Modal(document.getElementById('caweb-dev-modal'));
    }

    $('#import-file').on('click', (e) => {
        let fd = new FormData($('#caweb-dev-import')[0]);

        $.each($('#caweb-dev-import #importFile')[0].files, (i, file) => {
            fd.append('file-' + i, file);
        })

        
        // portModal.show();

        jQuery.post({
			url: $('#caweb-dev-import').attr('action'),
			type: 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function( response ){
                console.log(response)
                // update modal body
                $('#caweb-dev-modal .modal-title').html('Done!');

                // update modal body
                $('#caweb-dev-modal .modal-body').html('<h5>Export completed successfully.</h5>');

                // show the footer
                $('#caweb-dev-modal .modal-footer').removeClass('d-none');
			}
		});
    })

});
import * as bootstrap from "bootstrap";

jQuery(document).ready(function($) {

    if( $('#odwpi-dev-modal').length ){
        const portModal = new bootstrap.Modal(document.getElementById('odwpi-dev-modal'));
    }

    $('input[type="radio"][value="all"]').on('change', (e) => {
        if( e.target.checked ){
            $('#registered-nav-locations').collapse('hide')
        }
    }) 

    $('input[type="radio"][value="theme-location"]').on('change', (e) => {
        $('#registered-nav-locations').collapse(e.target.checked ? 'show' : 'hide')
    }) 

    
    $('#odwpi-dev-modal').on('hide.bs.modal', (e) => {
        $('#odwpi-dev-modal .modal-footer').addClass('d-none');
    })

    $('#odwpi-dev-modal #download-export').on('click', (e) => {
        portModal.hide();
    })

    $('#odwpi-dev-export-submit').on('click', (e) => {
        e.preventDefault();

        let fd = new FormData($('#odwpi-dev-export')[0]);

        portModal.show();

        jQuery.post({
			url: $('#odwpi-dev-export').attr('action'),
			type: 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function( response ){

                var downloadLink = $('#odwpi-dev-modal #download-export');
                var blob = new Blob([response], { type: "application/json" });
                var link = (window.URL ? URL : webkitURL).createObjectURL(blob);

                $(downloadLink).attr('href', link);
                $(downloadLink).attr('download', 'caweb.json');

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
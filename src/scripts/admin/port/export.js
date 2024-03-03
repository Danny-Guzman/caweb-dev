import * as bootstrap from "bootstrap";

jQuery(document).ready(function($) {

    if( $('#caweb-dev-modal').length ){
        const portModal = new bootstrap.Modal(document.getElementById('caweb-dev-modal'));
    }

    $('input[type="radio"][value="all"]').on('change', (e) => {
        if( e.target.checked ){
            $('#registered-nav-locations').collapse('hide')
        }
    }) 

    $('input[type="radio"][value="theme-location"]').on('change', (e) => {
        $('#registered-nav-locations').collapse(e.target.checked ? 'show' : 'hide')
    }) 

    
    $('#caweb-dev-modal').on('hide.bs.modal', (e) => {
        $('#caweb-dev-modal .modal-footer').addClass('d-none');
    })

    $('#caweb-dev-modal #download-export').on('click', (e) => {
        portModal.hide();
    })

    $('#caweb-dev-export-submit').on('click', (e) => {
        e.preventDefault();

        let fd = new FormData($('#caweb-dev-export')[0]);

        portModal.show();

        jQuery.post({
			url: $('#caweb-dev-export').attr('action'),
			type: 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function( response ){

                var downloadLink = $('#caweb-dev-modal #download-export');
                var blob = new Blob([response], { type: "application/json" });
                var link = (window.URL ? URL : webkitURL).createObjectURL(blob);

                $(downloadLink).attr('href', link);
                $(downloadLink).attr('download', 'caweb.json');

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
(function ($) {

	'use strict';

	$( 'body' ).on('change', '.input-screenshort', function () {
		var fileData = $(this);
		var formData = new FormData();
		formData.append("logo", fileData[0].files[0]);
	});


	$('.g-recaptcha').on( 'click', function(e) {
		e.preventDefault();

		grecaptcha.ready(function() {
		  grecaptcha.execute(admin.site_key, {action: 'submit'}).then(function(token) {
			if ( grecaptcha !== undefined ) {
				var response = grecaptcha.getResponse();

				if ( ! response ) {
					var error = '<span class="error">Please check the the captcha form.</span>';
					$('.generator-form-message').html(error);
				} else {
					$('.form-generator').submit();
				}
			} else {
				$('.form-generator').submit();
			}
		  });
		});

	} );

} )( jQuery );

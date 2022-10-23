(function ($) {

	'use strict';

	$( 'body' ).on('change', '.input-screenshort', function () {
		var fileData = $(this);
		var formData = new FormData();
		formData.append("logo", fileData[0].files[0]);
	});

	// for recaptcha login form
	if ( grecaptcha !== undefined ) {
		grecaptcha.ready(function () {
			var loginRecaptchaNode = document.getElementById('g-recaptcha-generator');
			grecaptcha.render( loginRecaptchaNode, {
				'sitekey': admin.site_key,
			});
		})
	};

	$('.btn-generator').on( 'click', function(e) {
		e.preventDefault();
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
	} );

} )( jQuery );

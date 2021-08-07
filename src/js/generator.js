(function ($) {

	'use strict';

	$( 'body' ).on('change', '.input-screenshort', function () {
		var fileData = $(this);
		var formData = new FormData();
		formData.append("logo", fileData[0].files[0]);
	});

} )( jQuery );

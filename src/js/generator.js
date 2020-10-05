(function ($) {

	'use strict';
	$( '.btn-generator' ).on(
		'click',
		function (e) {
			e.preventDefault();
			var form = $( '.boostify-form-generator' ).find( '.form-generator' );
			var name = $( '.input-name' ).val();
			var ver = $( '.input-version' ).val();
			var author = $( '.input-author' ).val();
			var authorUri = $( '.input-author-uri' ).val();
			var description = $( '.input-description' ).val();
			var folder = $( '.input-folder' ).val();
			var template = $( '.input-template' ).val();
			var data = form.serialize();
			data += '&action=boostify_generator&_ajax_nonce=' + admin.nonce;
			var formData = new FormData();
			var fileData = $( '.boostify-form-generator' ).find( '.input-screenshort' );
			formData.append( 'screen', fileData[0].files[0]);
			formData.append( 'name', name );
			formData.append( 'version', ver );
			formData.append( 'author', author );
			formData.append( 'author_uri', authorUri );
			formData.append( 'description', description );
			formData.append( 'folder', folder );
			formData.append( '_ajax_nonce', admin.nonce );
			formData.append( 'action', 'boostify_generator' );
			if ( template != undefined ) {
				formData.append( 'template', template );
			}

			$.ajax(
				{
					type: 'POST',
					url: admin.url,
					data: formData,
					processData: false,
					contentType: false,
					cache : false,
					success: function (response) {
						// console.log( response );
						// window.location.href = response.data;
						e.preventDefault();
						var link = document.createElement('a');
						link.href = response.data;
						link.click();
					},
				}
			);
		}
	);

	$( 'body' ).on('change', '.input-screenshort', function () {
		var fileData = $(this);
		var formData = new FormData();
		formData.append("logo", fileData[0].files[0]);
	});

} )( jQuery );

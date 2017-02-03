jQuery(function() {

	jQuery('body').on( 'click', '.favorite_button', function(){
		var $url 	= jQuery(this).data('url');
		jQuery.ajax({
			url: $url,
			success: function( data ) {
				location.reload();
			},
			error: function( data ) {
				if ( 200 == data.status ){
					location.reload();
				}
			}
		});
		return false;
	});
});
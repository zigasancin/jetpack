jQuery( document ).ready( function( $ ) {
	var APIqueue = [];
	$( '.comment-like-count' ).each( function() {
		APIqueue.push( '/sites/' + $( this ).attr( 'data-blog-id' ) + '/comments/' + $( this ).attr( 'data-comment-id' ) + '/likes' );
	} );
	$.ajax( {
		type: 'GET',
		url: 'https://public-api.wordpress.com/rest/v1/batch',
		dataType: 'jsonp',
		data: 'urls[]=' + APIqueue.join( '&urls[]=' ),
		success: function( response ) {
			for ( var path in response ) {
				if ( response.hasOwnProperty( path ) && ! response[ path ].error_data ) {
					var commentId = path.split( '/' )[ 4 ],
						count = response[ path ].found;
					if ( count >= 1 ) {
						$( '#comment-like-count-' + commentId ).find( '.like-count' ).hide().text( count ).fadeIn();
					}
				}
			}
		}
	} );
} );

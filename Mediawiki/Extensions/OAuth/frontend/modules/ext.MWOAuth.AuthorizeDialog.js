/**
 * OAuth JavaScript
 * @author Aaron Schulz 2013
 */
( function ( mw, $ ) {
	'use strict';

	var mwoauth = {
		'init': function () {
			var form = $( '#mw-mwoauth-authorize-dialog' ),
				accept = $( '#mw-mwoauth-accept' );
			form.find( '.mw-htmlform-submit-buttons' ).addClass( 'mw-ui-flush-right' );
			form.dialog( {
				dialogClass: 'mw-mwoauth-authorize-jQuery-dialog',
				width: 0.3 * $( window ).width(),
				title: mw.msg( 'mwoauth-desc' ),
				draggable: false,
				resizable: false,
				open: function () {
					$( window ).scrollTop( 0 );
				},
				create: function () {
					$( this ).parents( '.ui-dialog:first' )
						.find( '.ui-dialog-content' ).css( 'padding', '20px' );
					$( this ).css( 'maxHeight', 0.9 * $( window ).height() );
					$( this ).css( 'background-color', '#FFF' );
					$( this ).css( 'border', '1px #CCC' );
					$( this ).dialog( 'option', 'modal', true );
				}
			} );
			form.submit( function () {
				accept.prop( 'disabled', true );
			} );
		}
	};

	// Perform some onload events:
	$( document ).ready( function () {
		mwoauth.init();
	} );

})( mediaWiki, jQuery );

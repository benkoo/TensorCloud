( function ( $, mw ) {
var conf = mw.config.get([
	'wgCookiePrefix',
	'wgScript'
]);

var openid = window.openid = {

	current: 'OpenID',

	show: function( provider ) {

		$( '#openid_provider_selection_error_box' )
			.css( 'display', 'none' );
		$( '#provider_form_' + openid.current )
			.css( 'display', 'none' );
		$( '#provider_form_' + provider )
			.css( 'display', 'block' );
		$( '#openid_provider_' + openid.current + '_icon, #openid_provider_' + openid.current + '_link' )
			.removeClass( 'openid_selected' );
		$( '#openid_provider_' + provider + '_icon, #openid_provider_' + provider + '_link' )
			.addClass( 'openid_selected' );

		openid.current = provider;

	},

	update: function () {

		$.cookie( conf.wgCookiePrefix + '_openid_provider', openid.current, { 'path': conf.wgScript, 'expires': 365 } );
		var url = $( '#openid_provider_url_' + openid.current ).val(),
			param_id = 'openid_provider_param_' + openid.current,
			param = $('#' + param_id).val();

		//found a value for param (could even be '')?
		if( !param && url.match( /{.*}/ ) ) {
			$( '#openid_provider_selection_error_box' ).css( 'display', 'inline-block' );
			return false;
		}

		if ( param !== null ) {
			$.cookie( conf.wgCookiePrefix + '_' + param_id, param, { 'path': conf.wgScript, 'expires': 365 } );
			url = url.replace( /{.*}/, param );
		}

		$( '#openid_url' ).val( url );

	},

	init: function () {

		$( '#openid_form' ).submit( openid.update );

		var provider = $.cookie( conf.wgCookiePrefix + '_openid_provider' ) ||
			$( '.openid_default_provider' ).data( 'provider-name' );

		if ( provider ) {
			openid.show( provider );
		}

	}

};

$( document ).ready( openid.init );
}( jQuery, mediaWiki ) );

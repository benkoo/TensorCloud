<?php

namespace MediaWiki\Extensions\OAuth;

class MWOAuthException extends OAuthException {
	public $msg, $params;

	/**
	 * Exception that may be shown to an end user
	 * @param string $msg Message key (string) for error text
	 * @param array $params with parameters to wfMessage()
	 */
	function __construct( $msg, $params = null ) {
		$this->msg = $msg;
		$this->params = $params;
		parent::__construct(
			wfMessage( $msg, $params )->inLanguage( 'en' )->useDatabase( false )->plain()
		);
	}

}

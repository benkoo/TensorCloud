<?php

namespace MediaWiki\Extensions\OAuth;

use IContextSource;
use Message;
use OOUI\Tag;

/**
 * Static utility class for the special pages
 */
class MWOAuthUIUtils {
	/**
	 * Generate an information table for a consumer. The result will be suitable for use as a
	 * HTMLForm field with no label.
	 * @param array $info fieldname-message => description; description will be escaped (use
	 *   HtmlSnippet to avoid); fields with null value will be ignored; messages will be interpreted
	 *   as plaintext
	 * @param IContextSource $context
	 * @return string
	 */
	public static function generateInfoTable( $info, $context ) {
		$dl = new Tag( 'dl' );
		$dl->addClasses( [ 'mw-mwoauth-infotable' ] );
		foreach ( $info as $fieldname => $description ) {
			if ( $description === null ) {
				continue;
			} elseif ( $description instanceof Message ) {
				$description = $description->plain();
			}
			$dt = new Tag( 'dt' );
			$dd = new Tag( 'dd' );
			$dt->appendContent( $context->msg( $fieldname )->text() );
			$dd->appendContent( $description );
			$dl->appendContent( $dt, $dd );
		}
		return $dl->toString();
	}
}

<?php
/**
 * SpecialOpenIDIdentifier.body.php -- Special page for identifiers
 * Copyright 2013 by Ryan Lane
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @file
 * @author Ryan Lane <rlane@wikimedia.org>
 * @author Thomas Gries <mail@tgries.de>
 * @ingroup Extensions
 */

class SpecialOpenIDIdentifier extends unlistedSpecialPage {
	function __construct() {
		parent::__construct( 'OpenIDIdentifier' );
	}

	function execute( $par ) {
		global $wgOut;
		$this->setHeaders();

		if ( !OpenID::isAllowedMode( 'provider' ) ) {
			$wgOut->showErrorPage( 'openiderror', 'openidclientonlytext' );
			return;
		}

		self::showOpenIDIdentifier( User::newFromId( $par ), false, true );
	}

	private static function isUser( $user ) {
		return ( $user ) ? $user->loadFromId() : false;
	}

	/**
	 * @param User $user
	 * @param bool $delegate
	 * @param bool $showSpecialPageText
	 */
	public static function showOpenIDIdentifier( $user, $delegate = false, $showSpecialPageText = false ) {
		global $wgOut, $wgUser, $wgOpenIDShowUrlOnUserPage, $wgOpenIDAllowServingOpenIDUserAccounts;

		// show the own OpenID Url as a subtitle on the user page
		// but only for the user when visiting their own page
		// and when the options say so

		if ( !self::isUser( $user ) && $showSpecialPageText ) {
			$wgOut->addWikiMsg( 'openid-identifier-page-text-no-such-local-openid' );
			return;
		}

		$openid = SpecialOpenID::getUserOpenIDInformation( $user );

		# Add OpenID data if its allowed
		if ( OpenID::isAllowedMode( 'provider' ) ) {
			if ( !( count( $openid )
				&& ( strlen( $openid[0]->uoi_openid ) != 0 )
				&& !$wgOpenIDAllowServingOpenIDUserAccounts )
			) {
				$serverTitle = SpecialPage::getTitleFor( 'OpenIDServer' );
				$serverUrl = $serverTitle->getFullURL( '', false, PROTO_CANONICAL );
				$wgOut->addLink( array( 'rel' => 'openid.server', 'href' => $serverUrl ) );
				$wgOut->addLink( array( 'rel' => 'openid2.provider', 'href' => $serverUrl ) );
				if ( $delegate ) {
					$local_identity = SpecialOpenIDServer::getLocalIdentity( $user );
					$wgOut->addLink( array( 'rel' => 'openid.delegate', 'href' => $local_identity ) );
					$wgOut->addLink( array( 'rel' => 'openid2.local_id', 'href' => $local_identity ) );
				}
				$rt = SpecialPage::getTitleFor( 'OpenIDXRDS', $user->getName() );
				$xrdsUrl = $rt->getFullURL( '', false, PROTO_CANONICAL );
				$wgOut->addMeta( 'http:X-XRDS-Location', $xrdsUrl );
				header( 'X-XRDS-Location: ' . $xrdsUrl );

			}

			if ( ( $user->getID() === $wgUser->getID() )
				&& ( $user->getID() != 0 )
				&& ( $wgOpenIDShowUrlOnUserPage === 'always'
					|| ( ( $wgOpenIDShowUrlOnUserPage === 'user' ) && $wgUser->getOption( 'openid-show-openid' ) ) )
			) {
				$wgOut->setSubtitle( "<span class='subpages'>" .
					OpenID::getOpenIDSmallLogoUrlImageTag() .
					SpecialOpenIDServer::getLocalIdentityLink( $wgUser ) .
					"</span>" );

				if ( $showSpecialPageText ) {
					$wgOut->addWikiMsg( 'openid-identifier-page-text-user', $wgUser->getName() );
				}
			} elseif ( $showSpecialPageText ) {
				$wgOut->addWikiMsg( 'openid-identifier-page-text-different-user', $user->getID() );
			}
		}
	}

	protected function getGroupName() {
		return 'openid';
	}
}

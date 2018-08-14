<?php
/**
 * SpecialOpenIDConvert.body.php -- Convert existing account to OpenID account
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2007,2008 Evan Prodromou <evan@prodromou.name>
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
 * @author Evan Prodromou <evan@prodromou.name>
 * @author Thomas Gries
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

class SpecialOpenIDConvert extends SpecialOpenID {

	function __construct() {
		global $wgOpenIDForcedProvider;
		$listed = !OpenID::isForcedProvider();
		parent::__construct( 'OpenIDConvert', 'openid-converter-access', $listed );
	}

	function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut, $wgOpenIDProviders, $wgOpenIDForcedProvider;

		if ( !OpenID::isAllowedMode( 'consumer' ) ) {
			$wgOut->showErrorPage(
				'openiderror',
				'openid-error-openid-consumer-mode-disabled'
			);
			return;
		}

/*		use this
		if you want to always suppress the convert screen if forced provider

		if ( OpenID::isForcedProvider() ) {
			$wgOut->showErrorPage(
				'openiderror',
				'openid-error-openid-convert-not-allowed-forced-provider',
				array( $wgOpenIDForcedProvider )
			);
			return;
		}
*/

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		$this->outputHeader();

		switch ( $par ) {

		case 'Finish':
			$this->finish();
			break;

		case 'Delete':
			$this->delete();
			break;

		default:

			// if a forced OpenID provider is specified, bypass
			// the form and any openid_url in the request.

			$skipTokenTestBecauseForcedProvider = false;

			if ( OpenID::isForcedProvider() ) {

				if ( array_key_exists( $wgOpenIDForcedProvider, $wgOpenIDProviders ) ) {

					$url = $wgOpenIDProviders[$wgOpenIDForcedProvider]['openid-url'];
					wfDebug( "OpenID: wgOpenIDForcedProvider $wgOpenIDForcedProvider defined => $url\n" );

					// make sure that the associated provider Url does not contain {username} placeholder
					// and try to use an optional openid-selection-url from the $wgOpenIDProviders array
					if ( strpos( $url, '{username}' ) === false ) {
						$skipTokenTestBecauseForcedProvider = true;
						$openid_url = $url;
					} else {
						if ( isset ( $wgOpenIDProviders[$wgOpenIDForcedProvider]['openid-selection-url'] ) ) {
							$skipTokenTestBecauseForcedProvider = true;
							$openid_url = $wgOpenIDProviders[$wgOpenIDForcedProvider]['openid-selection-url'];
						} else {
							wfDebug( "OpenID: Error: wgOpenIDForcedProvider $wgOpenIDForcedProvider defined, but wgOpenIDProviders array has an invalid provider Url. Must not contain a username placeholder!\n");
							$this->showErrorPage( 'openid-error-wrong-force-provider-setting', array( $wgOpenIDForcedProvider ) );
							return;
						}
					}

				} else {

					// a fully qualified URL is given
					$skipTokenTestBecauseForcedProvider = true;
					$openid_url = $wgOpenIDForcedProvider;

				}

			} else {

				$openid_url = $wgRequest->getText( 'openid_url' );

			}

			if ( isset( $openid_url ) && strlen( $openid_url ) > 0 ) {
				$this->convert( $openid_url, $skipTokenTestBecauseForcedProvider  );
			} else {
				$this->form();
			}

		}
	}

	function convert( $openid_url, $skipTokenTestBecauseForcedProvider = false ) {
		global $wgUser, $wgOut, $wgRequest;

		if ( !$skipTokenTestBecauseForcedProvider
			&& ( LoginForm::getLoginToken() !== $wgRequest->getVal( 'openidProviderSelectionLoginToken' ) )
			&& !( $wgUser->matchEditToken( $wgRequest->getVal( 'openidConvertToken' ), 'openidConvertToken' ) ) ) {

			$wgOut->showErrorPage( 'openiderror', 'openid-error-request-forgery' );
			return;
		}


		# Expand Interwiki
		$openid_url = $this->interwikiExpand( $openid_url );
		wfDebug( "OpenID: Attempting conversion with url: $openid_url\n" );

		# Is this ID allowed to log in?
		if ( !$this->canLogin( $openid_url ) ) {
			$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
			return;
		}

		# Is this ID already taken?

		$other = self::getUserFromUrl( $openid_url );

		if ( isset( $other ) ) {
			if ( $other->getId() == $wgUser->getID() ) {
				$wgOut->showErrorPage(
					'openiderror',
					'openid-convert-already-your-openid-text',
					array( $openid_url )
				);
			} else {
				$wgOut->showErrorPage(
					'openiderror',
					'openid-convert-other-users-openid-text',
					array( $openid_url )
				);
			}
			return;
		}

		// If we're OK to here, let the user go log in
		$this->login( $openid_url, SpecialPage::getTitleFor( 'OpenIDConvert', 'Finish' ), $skipTokenTestBecauseForcedProvider );

	}

	public static function renderProviderIcons( &$inputFormHTML, &$largeButtonsHTML, &$smallButtonsHTML ) {
			global $wgOpenIDShowProviderIcons;
			//The loginFormHTML that each provider generates and the
			//accompanying openid.js code relies on there being a
			//hidden input 'openid_url'
			$inputFormHTML .= Html::element( 'input',
				array(
					'type' => 'hidden',
					'id' => 'openid_url',
					'name' => 'openid_url'
				)
			);

			$largeButtons = '';
			foreach ( OpenIDProvider::getProviders( 'large' ) as $provider ) {
				$largeButtons .= $provider->getButtonHTML();
				$inputFormHTML .= $provider->getLoginFormHTML();
			}

			$largeButtonsHTML = Html::rawElement( 'div',
				array( 'id' => 'openid_large_providers' ),
				$largeButtons
			);

			$smallButtonsHTML = '';

			if ( $wgOpenIDShowProviderIcons ) {

				$smallButtons = '';
				foreach ( OpenIDProvider::getProviders( 'small' ) as $provider ) {
					$smallButtons .= $provider->getButtonHTML();
					$inputFormHTML .= $provider->getLoginFormHTML();
				}

				$smallButtonsHTML = Html::rawElement( 'div',
					array( 'id' => 'openid_small_providers_icons' ),
					$smallButtons
				);

			} else {

				$smallButtons = '<ul class="openid_small_providers_block">';
				$smallProviders = OpenIDProvider::getProviders( 'small' );

				$i = 0;
				$break = true;

				foreach ( $smallProviders as $provider ) {
					if ( $break && $i > count( $smallProviders ) / 2 ) {
						$smallButtons .= '</ul><ul class="openid_small_providers_block">';
						$break = false;
					}
					$smallButtons .= Html::rawElement( 'li',
						array(),
						$provider->getButtonHTML()
					);

					$inputFormHTML .= $provider->getLoginFormHTML();
					$i++;
				}

				$smallButtons .= '</ul>';

				$smallButtonsHTML .= Html::rawElement( 'div',
					array( 'id' => 'openid_small_providers_links' ),
					$smallButtons
				);

			}

			return;

		}


	function form() {
		global $wgOut, $wgUser, $wgOpenIDShowProviderIcons;

		$inputFormHTML = '';

		$largeButtonsHTML = '';
		$smallButtonsHTML = '';
		self::renderProviderIcons( $inputFormHTML, $largeButtonsHTML, $smallButtonsHTML );

		$wgOut->addModules( $wgOpenIDShowProviderIcons ? 'ext.openid.icons' : 'ext.openid.plain' );
		$wgOut->addHTML(
			Html::rawElement( 'form',
				array(
					'id' => 'openid_form',
					'action' => $this->getPageTitle()->getLocalUrl(),
					'method' => 'post',
					'onsubmit' => 'openid.update()'
				),
				Xml::fieldset( wfMessage( 'openidconvertoraddmoreids' )->text() ) .
				Html::element( 'p',
					array(),
					wfMessage( 'openidconvertinstructions' )->text()
				) .
				$largeButtonsHTML .
				Html::rawElement( 'div',
					array(
						'id' => 'openid_provider_selection_error_box',
						'class' => 'errorbox',
						'style' => 'display:none'
					),
					wfMessage( 'openid-empty-param-error' )->escaped()
				) .
				Html::rawElement( 'div',
					array( 'id' => 'openid_input_area' ),
					$inputFormHTML
				) .
				$smallButtonsHTML .
				Xml::closeElement( 'fieldset' ) .
				Html::Hidden( 'openidConvertToken' , $wgUser->getEditToken( 'openidConvertToken' ) )
			)
		);
	}

	function delete() {
		global $wgUser, $wgOut, $wgRequest, $wgOpenIDLoginOnly;

		$openid = $wgRequest->getVal( 'url' );
		$user = self::getUserFromUrl( $openid );

		if ( $user->getId() == 0 || $user->getId() != $wgUser->getId() ) {
			$wgOut->showErrorPage( 'openiderror', 'openidconvertothertext' );
			return;
		}

		$wgOut->setPageTitle( wfMessage( 'openiddelete' )->text() );

		# Check if the user is removing it's last OpenID url
		$urls = self::getUserOpenIDInformation( $wgUser );
		if ( count( $urls ) == 1 ) {
			if ( $wgUser->mPassword == '' ) {
				$wgOut->showErrorPage( 'openiderror', 'openiddeleteerrornopassword' );
				return;
			} elseif ( $wgOpenIDLoginOnly ) {
				$wgOut->showErrorPage( 'openiderror', 'openiddeleteerroropenidonly' );
				return;
			}
		}

		if ( $wgRequest->wasPosted()
			&& $wgUser->matchEditToken( $wgRequest->getVal( 'openidDeleteToken' ), $openid ) ) {

			$ret = self::removeUserUrl( $wgUser, $openid );
			$wgOut->addWikiMsg( $ret ? 'openiddelete-success' : 'openiddelete-error' );
			return;
		}

		$wgOut->addWikiMsg( 'openiddelete-text', $openid );

		$wgOut->addHtml(
			Xml::openElement( 'form',
				array(
					'action' => $this->getPageTitle( 'Delete' )->getLocalUrl(),
					'method' => 'post'
				)
			) .
			Xml::submitButton( wfMessage( 'openiddelete-button' )->text() ) .
			Html::Hidden( 'url', $openid ) .
			Html::Hidden( 'openidDeleteToken', $wgUser->getEditToken( $openid ) ) .
			Xml::closeElement( 'form' )
		);
	}

	function finish() {
		global $wgUser, $wgOut;

		wfSuppressWarnings();
		$consumer = $this->getConsumer();
		$response = $consumer->complete( $this->scriptUrl( 'Finish' ) );
		wfRestoreWarnings();

		if ( is_null( $response ) ) {
			wfDebug( "OpenID: aborting in openid converter because the response was missing\n" );
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		switch ( $response->status ) {

		case Auth_OpenID_CANCEL:

			// This means the authentication was cancelled.
			$wgOut->showErrorPage( 'openidcancel', 'openidcanceltext' );
			break;

		case Auth_OpenID_FAILURE:

			wfDebug( "OpenID: error in convert: '" . $response->message . "'\n" );
			$wgOut->showErrorPage( 'openidfailure', 'openidfailuretext', array( $response->message ) );
			break;

		case Auth_OpenID_SUCCESS:

			// This means the authentication succeeded.
			$openid_url = $response->identity_url;

			if ( !$this->canLogin( $openid_url ) ) {
				$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
				return;
			}

			if ( !isset( $openid_url ) ) {
				wfDebug( "OpenID: aborting in openid converter because the openid_url was missing\n" );
				$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
				return;
			}

			# We check again for dupes; this may be normalized or
			# reformatted by the server.

			$other = self::getUserFromUrl( $openid_url );

			if ( isset( $other ) ) {
				if ( $other->getId() == $wgUser->getID() ) {
					$wgOut->showErrorPage(
						'openiderror', 
						'openid-convert-already-your-openid-text',
						array( $openid_url )
					);
				} else {
					$wgOut->showErrorPage(
						'openiderror',
						'openid-convert-other-users-openid-text',
						array( $openid_url )
					);
				}
				return;
			}

			self::addUserUrl( $wgUser, $openid_url );

			$this->loginSetCookie( $openid_url );

			$wgOut->setPageTitle( wfMessage( 'openidconvertsuccess' )->text() );
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$wgOut->setArticleRelated( false );
			$wgOut->addWikiMsg( 'openidconvertsuccesstext', $openid_url );
			$wgOut->returnToMain();
		}
	}

	protected function getGroupName() {
		return 'openid';
	}
}

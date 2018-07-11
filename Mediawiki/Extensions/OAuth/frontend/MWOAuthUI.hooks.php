<?php

namespace MediaWiki\Extensions\OAuth;

use HTMLForm;
use SpecialPage;

/**
 * Class containing GUI even handler functions for an OAuth environment
 */
class MWOAuthUIHooks {

	/**
	 * @param \User $user
	 * @param array &$preferences
	 * @return bool
	 * @throws \MWException
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		$dbr = MWOAuthUtils::getCentralDB( DB_REPLICA );
		$conds = [
			'oaac_consumer_id = oarc_id',
			'oaac_user_id' => MWOAuthUtils::getCentralIdFromLocalUser( $user ),
		];
		if ( !$user->isAllowed( 'mwoauthviewsuppressed' ) ) {
			$conds['oarc_deleted'] = 0;
		}
		$count = $dbr->selectField(
			[ 'oauth_accepted_consumer', 'oauth_registered_consumer' ],
			'COUNT(*)',
			$conds,
			__METHOD__
		);

		$prefInsert = [ 'mwoauth-prefs-managegrants' =>
			[
				'section' => 'personal/info',
				'label-message' => 'mwoauth-prefs-managegrants',
				'type' => 'info',
				'raw' => true,
				'default' => \Linker::linkKnown(
					\SpecialPage::getTitleFor( 'OAuthManageMyGrants' ),
					wfMessage( 'mwoauth-prefs-managegrantslink' )->numParams( $count )->escaped()
				)
			],
		];

		if ( array_key_exists( 'usergroups', $preferences ) ) {
			$preferences = wfArrayInsertAfter( $preferences, $prefInsert, 'usergroups' );
		} else {
			$preferences += $prefInsert;
		}

		return true;
	}

	/**
	 * Override MediaWiki namespace for a message
	 * @param string $title Message name (no prefix)
	 * @param string &$message Message wikitext
	 * @return bool false if we replaced $message
	 */
	public static function onMessagesPreLoad( $title, &$message ) {
		// Quick fail check
		if ( substr( $title, 0, 15 ) !== 'Tag-OAuth_CID:_' ) {
			return true;
		}

		// More expensive check
		if ( !preg_match( '!^Tag-OAuth_CID:_(\d+)((?:-description)?)(?:/|$)!', $title, $m ) ) {
			return true;
		}

		$dbr = MWOAuthUtils::getCentralDB( DB_REPLICA );
		$cmr = MWOAuthDAOAccessControl::wrap(
			MWOAuthConsumer::newFromId( $dbr, $m[1] ), \RequestContext::getMain()
		);
		if ( !$cmr ) {
			// Invalid consumer, skip it
			return true;
		}

		if ( $m[2] ) {
			$message = htmlspecialchars( $cmr->get( 'description' ) );
		} else {
			$target = \SpecialPage::getTitleFor( 'OAuthListConsumers',
				'view/' . $cmr->get( 'consumerKey' )
			);
			$encName = wfEscapeWikiText( $cmr->get( 'name', function ( $s ) use ( $cmr ) {
				return $s . ' [' . $cmr->get( 'version' ) . ']';
			} ) );
			$message = "[[$target|$encName]]";
		}
		return false;
	}

	/**
	 * Append OAuth-specific grants to Special:ListGrants
	 * @param SpecialPage $special
	 * @param string $par
	 * @return bool
	 */
	public static function onSpecialPageAfterExecute( SpecialPage $special, $par ) {
		if ( $special->getName() != 'Listgrants' ) {
			return true;
		}

		$out = $special->getOutput();

		$out->addWikiMsg( 'mwoauth-listgrants-extra-summary' );

		$out->addHTML(
			\Html::openElement( 'table',
			[ 'class' => 'wikitable mw-listgrouprights-table' ] ) .
			'<tr>' .
			\Html::element( 'th', null, $special->msg( 'listgrants-grant' )->text() ) .
			\Html::element( 'th', null, $special->msg( 'listgrants-rights' )->text() ) .
			'</tr>'
		);

		$grants = [
			'mwoauth-authonly' => [],
			'mwoauth-authonlyprivate' => [],
		];

		foreach ( $grants as $grant => $rights ) {
			$descs = [];
			$rights = array_filter( $rights ); // remove ones with 'false'
			foreach ( $rights as $permission => $granted ) {
				$descs[] = $special->msg(
					'listgrouprights-right-display',
					\User::getRightDescription( $permission ),
					'<span class="mw-listgrants-right-name">' . $permission . '</span>'
				)->parse();
			}
			if ( !count( $descs ) ) {
				$grantCellHtml = '';
			} else {
				sort( $descs );
				$grantCellHtml = '<ul><li>' . implode( "</li>\n<li>", $descs ) . '</li></ul>';
			}

			$id = \Sanitizer::escapeIdForAttribute( $grant );
			$out->addHTML( \Html::rawElement( 'tr', [ 'id' => $id ],
				"<td>" . $special->msg( "grant-$grant" )->escaped() . "</td>" .
				"<td>" . $grantCellHtml . '</td>'
			) );
		}

		$out->addHTML( \Html::closeElement( 'table' ) );

		return true;
	}

	/**
	 * Add additional text to Special:BotPasswords
	 * @param string $name Special page name
	 * @param HTMLForm $form
	 * @return bool
	 */
	public static function onSpecialPageBeforeFormDisplay( $name, HTMLForm $form ) {
		global $wgMWOAuthCentralWiki;

		if ( $name === 'BotPasswords' ) {
			if ( MWOAuthUtils::isCentralWiki() ) {
				$url = SpecialPage::getTitleFor( 'OAuthConsumerRegistration' )->getFullURL();
			} else {
				$url = \WikiMap::getForeignURL(
					$wgMWOAuthCentralWiki,
					'Special:OAuthConsumerRegistration' // Cross-wiki, so don't localize
				);
			}
			$form->addPreText( $form->msg( 'mwoauth-botpasswords-note', $url )->parseAsBlock() );
		}
		return true;
	}

	/**
	 * @param array &$notifications
	 * @param array &$notificationCategories
	 * @param array &$icons
	 */
	public static function onBeforeCreateEchoEvent(
		&$notifications, &$notificationCategories, &$icons
	) {
		global $wgOAuthGroupsToNotify;

		if ( !MWOAuthUtils::isCentralWiki() ) {
			return;
		}

		$notificationCategories['oauth-owner'] = [
			'tooltip' => 'echo-pref-tooltip-oauth-owner',
		];
		$notificationCategories['oauth-admin'] = [
			'tooltip' => 'echo-pref-tooltip-oauth-admin',
			'usergroups' => $wgOAuthGroupsToNotify,
		];

		foreach ( MWOAuthConsumerSubmitControl::$actions as $eventName ) {
			// oauth-app-propose and oauth-app-update notifies admins of the app.
			// oauth-app-approve, oauth-app-reject, oauth-app-disable and oauth-app-reenable
			// notify owner of the change.
			$notifications["oauth-app-$eventName"] =
				EchoOAuthStageChangePresentationModel::getDefinition( $eventName );
		}

		$icons['oauth'] = [ 'path' => 'OAuth/frontend/assets/echo-icon.png' ];
	}

	/**
	 * @param array &$specialPages
	 */
	public static function onSpecialPage_initList( array &$specialPages ) {
		if ( MWOAuthUtils::isCentralWiki() ) {
			$specialPages['OAuthConsumerRegistration'] = SpecialMWOAuthConsumerRegistration::class;
			$specialPages['OAuthManageConsumers'] = SpecialMWOAuthManageConsumers::class;
		}
	}
}

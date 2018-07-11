<?php

namespace MediaWiki\Extensions\OAuth;

use Wikimedia\Rdbms\DBConnRef;

/**
 * (c) Aaron Schulz 2013, GPL
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * Special page for listing consumers this user granted access to and
 * for manage the specific grants given or revoking access for the consumer
 */
class SpecialMWOAuthManageMyGrants extends \SpecialPage {
	private static $irrevocableGrants = null;

	public function __construct() {
		parent::__construct( 'OAuthManageMyGrants', 'mwoauthmanagemygrants' );
	}

	public function doesWrites() {
		return true;
	}

	public function execute( $par ) {
		global $wgMWOAuthReadOnly;

		$user = $this->getUser();

		$this->setHeaders();
		$this->getOutput()->disallowUserJs();

		if ( !$this->getUser()->isLoggedIn() ) {
			$this->getOutput()->addWikiMsg( 'mwoauthmanagemygrants-notloggedin' );
			return;
		} elseif ( !$user->isAllowed( 'mwoauthmanagemygrants' ) ) {
			throw new \PermissionsError( 'mwoauthmanagemygrants' );
		}

		// Format is Special:OAuthManageMyGrants[/list|/manage/<accesstoken>]
		$navigation = explode( '/', $par );
		$typeKey = isset( $navigation[0] ) ? $navigation[0] : null;
		$acceptanceId = isset( $navigation[1] ) ? $navigation[1] : null;

		if ( $wgMWOAuthReadOnly && in_array( $typeKey, [ 'update', 'revoke' ] ) ) {
			throw new \ErrorPageError( 'mwoauth-error', 'mwoauth-db-readonly' );
		}

		switch ( $typeKey ) {
		case 'update':
			$this->handleConsumerForm( $acceptanceId, $typeKey );
			break;
		case 'revoke':
			$this->handleConsumerForm( $acceptanceId, $typeKey );
			break;
		default:
			$this->showConsumerList();
			break;
		}

		$this->addSubtitleLinks( $acceptanceId );

		$this->getOutput()->addModuleStyles( 'ext.MWOAuth.BasicStyles' );
	}

	/**
	 * Show other parent page link
	 *
	 * @param type $acceptanceId
	 * @return void
	 */
	protected function addSubtitleLinks( $acceptanceId ) {
		$listLinks = [];
		if ( $acceptanceId ) {
			$listLinks[] = \Linker::linkKnown(
				$this->getPageTitle(),
				$this->msg( 'mwoauthmanagemygrants-showlist' )->escaped() );
		} else {
			$listLinks[] = $this->msg( 'mwoauthmanagemygrants-showlist' )->escaped();
		}

		$linkHtml = $this->getLanguage()->pipeList( $listLinks );

		$this->getOutput()->setSubtitle(
			"<strong>" . $this->msg( 'mwoauthmanagemygrants-navigation' )->escaped() .
			"</strong> [{$linkHtml}]" );
	}

	/**
	 * Show the form to approve/reject/disable/re-enable consumers
	 *
	 * @param string $acceptanceId
	 * @param string $type One of (update,revoke)
	 * @throws \PermissionsError
	 */
	protected function handleConsumerForm( $acceptanceId, $type ) {
		$user = $this->getUser();
		$lang = $this->getLanguage();
		$dbr = MWOAuthUtils::getCentralDB( DB_REPLICA );

		$centralUserId = MWOAuthUtils::getCentralIdFromLocalUser( $user );
		if ( !$centralUserId ) {
			$this->getOutput()->addWikiMsg( 'badaccess-group0' );
			return;
		}

		$cmra = MWOAuthDAOAccessControl::wrap(
			MWOAuthConsumerAcceptance::newFromId( $dbr, $acceptanceId ), $this->getContext() );
		if ( !$cmra || $cmra->get( 'userId' ) !== $centralUserId ) {
			$this->getOutput()->addHtml( $this->msg( 'mwoauth-invalid-access-token' )->escaped() );
			return;
		}

		$cmr = MWOAuthDAOAccessControl::wrap(
			MWOAuthConsumer::newFromId( $dbr, $cmra->get( 'consumerId' ) ), $this->getContext() );
		if ( $cmr->get( 'deleted' ) && !$user->isAllowed( 'mwoauthviewsuppressed' ) ) {
			throw new \PermissionsError( 'mwoauthviewsuppressed' );
		}

		$this->getOutput()->addModuleStyles( 'mediawiki.ui.button' );

		$action = '';
		if ( $this->getRequest()->getCheck( 'renounce' ) ) {
			$action = 'renounce';
		} elseif ( $this->getRequest()->getCheck( 'update' ) ) {
			$action = 'update';
		}

		$data = [ 'action' => $action ];
		$control = new MWOAuthConsumerAcceptanceSubmitControl( $this->getContext(), $data, $dbr );
		$form = \HTMLForm::factory( 'ooui',
			$control->registerValidators( [
				'info' => [
					'type' => 'info',
					'raw' => true,
					'default' => MWOAuthUIUtils::generateInfoTable( [
						'mwoauth-consumer-name' => $cmr->get( 'name', function ( $s ) use ( $cmr ) {
							return $s . ' [' . $cmr->get( 'version' ) . ']';
						} ),
						'mwoauth-consumer-user' => $cmr->get( 'userId',
							[ MWOAuthUtils::class, 'getCentralUserNameFromId' ] ),
						'mwoauth-consumer-description' => $cmr->get( 'description' ),
						'mwoauthmanagemygrants-wikiallowed' => $cmra->get( 'wiki',
							[ MWOAuthUtils::class, 'getWikiIdName' ] ),
					], $this->getContext() ),
				],
				'grants'  => [
					'type' => 'checkmatrix',
					'label-message' => 'mwoauthmanagemygrants-applicablegrantsallowed',
					'columns' => [
						$this->msg( 'mwoauthmanagemygrants-grantaccept' )->escaped() => 'grant'
					],
					'rows' => array_combine(
						array_map( 'MWGrants::getGrantsLink', $cmr->get( 'grants' ) ),
						$cmr->get( 'grants' )
					),
					'default' => array_map(
						function ( $g ) {
							return "grant-$g";
						},
						$cmra->get( 'grants' )
					),
					'tooltips' => [
						\MWGrants::getGrantsLink( 'basic' ) =>
							$this->msg( 'mwoauthmanagemygrants-basic-tooltip' )->text(),
						\MWGrants::getGrantsLink( 'mwoauth-authonly' ) =>
							$this->msg( 'mwoauthmanagemygrants-authonly-tooltip' )->text(),
						\MWGrants::getGrantsLink( 'mwoauth-authonlyprivate' ) =>
							$this->msg( 'mwoauthmanagemygrants-authonly-tooltip' )->text(),
					],
					'force-options-on' => array_map(
						function ( $g ) {
							return "grant-$g";
						},
						( $type === 'revoke' )
							? array_merge( \MWGrants::getValidGrants(), self::irrevocableGrants() )
							: self::irrevocableGrants()
					),
					'validation-callback' => null // different format
				],
				'acceptanceId' => [
					'type' => 'hidden',
					'default' => $cmra->get( 'id' )
				]
			] ),
			$this->getContext()
		);
		$form->setSubmitCallback(
			function ( array $data, \IContextSource $context ) use ( $action ) {
				$data['action'] = $action;
				$data['grants'] = \FormatJson::encode( // adapt form to controller
					preg_replace( '/^grant-/', '', $data['grants'] ) );

				$dbw = MWOAuthUtils::getCentralDB( DB_MASTER );
				$control = new MWOAuthConsumerAcceptanceSubmitControl( $context, $data, $dbw );
				return $control->submit();
			}
		);

		$form->setWrapperLegendMsg( 'mwoauthmanagemygrants-confirm-legend' );
		$opts = [
			'class' => 'mw-htmlform-submit',
		];
		$form->suppressDefaultSubmit();
		if ( $type === 'revoke' ) {
			$form->addButton( [
				'name' => 'renounce',
				'value' => $this->msg( 'mwoauthmanagemygrants-renounce' )->text(),
				'flags' => [ 'primary', 'destructive' ],
			] );
		} else {
			$form->addButton( [
				'name' => 'update',
				'value' => $this->msg( 'mwoauthmanagemygrants-update' )->text(),
				'flags' => [ 'primary', 'progressive' ],
			] );
		}
		$form->addPreText(
			$this->msg( "mwoauthmanagemygrants-$type-text" )->parseAsBlock() );

		$status = $form->show();
		if ( $status instanceof \Status && $status->isOk() ) {
			// Messages: mwoauthmanagemygrants-success-update,
			// mwoauthmanagemygrants-success-renounce
			$this->getOutput()->addWikiMsg( "mwoauthmanagemygrants-success-$action" );
		}
	}

	/**
	 * Show a paged list of consumers with links to details
	 *
	 * @return void
	 */
	protected function showConsumerList() {
		$this->getOutput()->addWikiMsg( 'mwoauthmanagemygrants-text' );

		$centralUserId = MWOAuthUtils::getCentralIdFromLocalUser( $this->getUser() );
		$pager = new MWOAuthManageMyGrantsPager( $this, [], $centralUserId );
		if ( $pager->getNumRows() ) {
			$this->getOutput()->addHTML( $pager->getNavigationBar() );
			$this->getOutput()->addHTML( $pager->getBody() );
			$this->getOutput()->addHTML( $pager->getNavigationBar() );
		} else {
			$this->getOutput()->addWikiMsg( "mwoauthmanagemygrants-none" );
		}
	}

	/**
	 * @param DBConnRef $db
	 * @param stdclass $row
	 * @return string
	 */
	public function formatRow( DBConnRef $db, $row ) {
		$cmr = MWOAuthDAOAccessControl::wrap(
			MWOAuthConsumer::newFromRow( $db, $row ), $this->getContext() );
		$cmra = MWOAuthDAOAccessControl::wrap(
			MWOAuthConsumerAcceptance::newFromRow( $db, $row ), $this->getContext() );

		$links = [];
		if ( array_diff( $cmr->get( 'grants' ), self::irrevocableGrants() ) ) {
			$links[] = \Linker::linkKnown(
				$this->getPageTitle( 'update/' . $cmra->get( 'id' ) ),
				$this->msg( 'mwoauthmanagemygrants-review' )->escaped()
			);
		}
		$links[] = \Linker::linkKnown(
			$this->getPageTitle( 'revoke/' . $cmra->get( 'id' ) ),
			$this->msg( 'mwoauthmanagemygrants-revoke' )->escaped()
		);
		$reviewLinks = $this->getLanguage()->pipeList( $links );

		$encName = htmlspecialchars( $cmr->get( 'name', function ( $s ) use ( $cmr ) {
			return $s . ' [' . $cmr->get( 'version' ) . ']';
		} ) );

		$r = '<li class="mw-mwoauthmanagemygrants-list-item">';
		$r .= "<strong dir='ltr'>{$encName}</strong> (<strong>$reviewLinks</strong>)";
		$data = [
			'mwoauthmanagemygrants-user' => $cmr->get( 'userId',
				'MediaWiki\Extensions\OAuth\MWOAuthUtils::getCentralUserNameFromId' ),
			'mwoauthmanagemygrants-wikiallowed' => $cmra->get( 'wiki',
				'MediaWiki\Extensions\OAuth\MWOAuthUtils::getWikiIdName' )
		];

		foreach ( $data as $msg => $val ) {
			$r .= '<p>' . $this->msg( $msg )->escaped() . ' ' . htmlspecialchars( $val ) . '</p>';
		}
		$r .= '</li>';

		return $r;
	}

	private static function irrevocableGrants() {
		if ( self::$irrevocableGrants === null ) {
			self::$irrevocableGrants = array_merge(
				\MWGrants::getHiddenGrants(),
				[ 'mwoauth-authonly', 'mwoauth-authonlyprivate' ]
			);
		}
		return self::$irrevocableGrants;
	}

	protected function getGroupName() {
		return 'users';
	}
}

/**
 * Query to list out consumers that have an access token for this user
 *
 * @TODO: use UserCache
 */
class MWOAuthManageMyGrantsPager extends \ReverseChronologicalPager {
	public $mForm, $mConds;

	function __construct( $form, $conds, $centralUserId ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		$this->mConds[] = 'oaac_consumer_id = oarc_id';
		$this->mConds['oaac_user_id'] = $centralUserId;
		if ( !$this->getUser()->isAllowed( 'mwoauthviewsuppressed' ) ) {
			$this->mConds['oarc_deleted'] = 0;
		}

		$this->mDb = MWOAuthUtils::getCentralDB( DB_REPLICA );
		parent::__construct();

		# Treat 20 as the default limit, since each entry takes up 5 rows.
		$urlLimit = $this->mRequest->getInt( 'limit' );
		$this->mLimit = $urlLimit ? $urlLimit : 20;
	}

	/**
	 * @return \Title
	 */
	function getTitle() {
		return $this->mForm->getFullTitle();
	}

	/**
	 * @param stdclass $row
	 * @return string
	 */
	function formatRow( $row ) {
		return $this->mForm->formatRow( $this->mDb, $row );
	}

	/**
	 * @return string
	 */
	function getStartBody() {
		if ( $this->getNumRows() ) {
			return '<ul>';
		} else {
			return '';
		}
	}

	/**
	 * @return string
	 */
	function getEndBody() {
		if ( $this->getNumRows() ) {
			return '</ul>';
		} else {
			return '';
		}
	}

	/**
	 * @return array
	 */
	function getQueryInfo() {
		return [
			'tables' => [ 'oauth_accepted_consumer', 'oauth_registered_consumer' ],
			'fields' => [ '*' ],
			'conds'  => $this->mConds
		];
	}

	/**
	 * @return string
	 */
	function getIndexField() {
		return 'oaac_consumer_id';
	}
}

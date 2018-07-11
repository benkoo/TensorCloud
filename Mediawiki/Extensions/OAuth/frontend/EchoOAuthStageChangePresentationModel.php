<?php

namespace MediaWiki\Extensions\OAuth;

use EchoAttributeManager;
use EchoEventPresentationModel;
use MWException;
use User;
use SpecialPage;

class EchoOAuthStageChangePresentationModel extends EchoEventPresentationModel {
	/** @var User[] OAuth admins who should be notified about additiions to the review queue */
	protected static $oauthAdmins;

	/** @var MWOAuthConsumer|false */
	protected $consumer;

	/** @var User|false The owner of the OAuth consumer */
	protected $owner;

	/**
	 * Helper function for $wgEchoNotifications
	 * @param string $action One of the actions from MWOAuthConsumerSubmitControl::$actions
	 * @return array
	 */
	public static function getDefinition( $action ) {
		if ( $action === 'propose' ) {
			// notify admins
			$category = 'oauth-admin';
		} else {
			// notify owner
			$category = 'oauth-owner';
		}

		return [
			EchoAttributeManager::ATTR_LOCATORS => [ MWOAuthUtils::class . '::locateUsersToNotify' ],
			'category' => $category,
			'presentation-model' => self::class,
			'icon' => 'oauth',
		];
	}

	public function getHeaderMessage() {
		$action = $this->event->getExtraParam( 'action' );
		return $this->msg( "notification-oauth-app-$action-title",
			$this->event->getAgent(), $this->getConsumerName(), $this->getOwner() );
	}

	public function getSubjectMessage() {
		$action = $this->event->getExtraParam( 'action' );
		return $this->msg( "notification-oauth-app-$action-subject",
			$this->event->getAgent(), $this->getConsumerName(), $this->getOwner() );
	}

	public function getBodyMessage() {
		$comment = $this->event->getExtraParam( 'comment' );
		return $comment ? $this->msg( 'notification-oauth-app-body', $comment ) : false;
	}

	public function getIconType() {
		return 'oauth';
	}

	public function getPrimaryLink() {
		$consumerKey = $this->event->getExtraParam( 'app-key' );
		$action = $this->event->getExtraParam( 'action' );

		if ( $action === 'propose' ) {
			// show management interface
			$page = SpecialPage::getSafeTitleFor( 'OAuthManageConsumers', $consumerKey );
		} else {
			// show public view
			$page = SpecialPage::getSafeTitleFor( 'OAuthListConsumers', "view/$consumerKey" );
		}
		if ( $page === null ) {
			throw new MWException( "Invalid app ID: $consumerKey" );
		}

		return [
			'url' => $page->getLocalURL(),
			'label' => $this->msg( "notification-oauth-app-$action-primary-link" )->text(),
		];
	}

	public function getSecondaryLinks() {
		return [ $this->getAgentLink() ];
	}

	/**
	 * @return MWOAuthConsumer|false
	 */
	protected function getConsumer() {
		if ( $this->consumer === null ) {
			$dbr = MWOAuthUtils::getCentralDB( DB_REPLICA );
			$this->consumer =
				MWOAuthConsumer::newFromKey( $dbr, $this->event->getExtraParam( 'app-key' ) );
		}
		return $this->consumer;
	}

	/**
	 * @return User|false
	 */
	protected function getOwner() {
		if ( $this->owner === null ) {
			$this->owner = MWOAuthUtils::getLocalUserFromCentralId(
				$this->event->getExtraParam( 'owner-id' ) );
		}
		return $this->owner;
	}

	/**
	 * @return string
	 */
	protected function getConsumerName() {
		$consumer = $this->getConsumer();
		return $consumer ? $consumer->get( 'name' ) : false;
	}
}

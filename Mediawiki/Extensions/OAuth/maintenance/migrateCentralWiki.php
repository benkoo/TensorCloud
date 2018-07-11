<?php

namespace MediaWiki\Extensions\OAuth;

/**
 * Migrate oauth_registered_consumer and oauth_accepted_consumer tables to a
 * new database with minimal downtime. This script assumes relatively small tables
 * (The WMF has <100 consumers and aout 1000 authorizations right now).
 *
 * To migrate to a new central wiki within your cluster, you roughly want to:
 * 1. Set $wgMWOAuthReadOnly = true for all wikis in your running config
 * 2. Move the oauth_registered_consumer and oauth_accepted_consumer tables with this script
 * 3. Update the cluster config to point to the new central wiki
 * 4. Set $wgMWOAuthReadOnly back to false, so users can manage their consumers as normal.
 * 5. Migrate the OAuth logs using importCentralWikiLogs.php.
 * 6. Done!
 *
 * @ingroup Maintenance
 */
if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = __DIR__.'/../../..';
}

require_once "$IP/maintenance/Maintenance.php";

class MigrateCentralWiki extends \Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrate central wiki from one wiki to another. " .
			"OAuth should be in Read Only mode while this is running.";
		$this->addOption( 'old', 'Previous central wiki', true, true );
		$this->addOption( 'target', 'New central wiki', true, true );
		$this->addOption( 'table',
			'Table name (oauth_registered_consumer or oauth_accepted_consumer)', true, true );
		$this->setBatchSize( 200 );
		$this->requireExtension( "OAuth" );
	}

	public function execute() {
		$oldWiki = $this->getOption( 'old' );
		$targetWiki = $this->getOption( 'target' );
		$table = $this->getOption( 'table' );

		if ( $table === 'oauth_registered_consumer' ) {
			$idKey = 'oarc_id';
			$cmrClass = 'MediaWiki\Extensions\OAuth\MWOAuthConsumer';
			$type = 'consumer';
		} elseif ( $table === 'oauth_accepted_consumer' ) {
			$idKey = 'oaac_id';
			$cmrClass = 'MediaWiki\Extensions\OAuth\MWOAuthConsumerAcceptance';
			$type = 'grant';
		} else {
			$this->error( "Invalid table name. Must be one of 'oauth_registered_consumer' " .
				"or 'oauth_accepted_consumer'.\n", 1 );
		}

		$oldDb = wfGetLB( $oldWiki )->getConnectionRef( DB_MASTER, [], $oldWiki );
		$targetDb = wfGetLB( $targetWiki )->getConnectionRef( DB_MASTER, [], $targetWiki );
		$targetDb->daoReadOnly = false;

		$newMax = $targetDb->selectField(
			$table,
			"MAX($idKey)",
			[],
			__METHOD__
		);

		$oldMax = $oldDb->selectField(
			$table,
			"MAX($idKey)",
			[],
			__METHOD__
		);

		if ( $newMax >= $oldMax ) {
			$this->output( "No new rows.\n" );
		}

		for ( $currentId = $newMax + 1, $i = 1; $currentId <= $oldMax; ++$currentId, ++$i ) {
			$this->output( "Migrating $type $currentId..." );
			$cmr = $cmrClass::newFromId( $oldDb, $currentId );
			if ( $cmr ) {
				$cmr->updateOrigin( 'new' );
				$cmr->setPending( true );
				$cmr->save( $targetDb );
				$this->output( "done.\n" );
			} else {
				$this->output( "missing.\n" );
			}

			if ( $this->mBatchSize && $i % $this->mBatchSize === 0 ) {
				wfWaitForSlaves( null, $targetWiki );
			}
		}
	}

}

$maintClass = "MediaWiki\Extensions\OAuth\MigrateCentralWiki";
require_once RUN_MAINTENANCE_IF_MAIN;

<?php
/*
 * Copyright (C) 2014 Ike Hecht
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * Puts wiki into debug mode
 *
 * @author Ike Hecht
 */
class DebugMode {
	/* Debug levels */
	const DEBUG_MODE_NONE = 0;
	const DEBUG_MODE_INI = 1;
	const DEBUG_MODE_PHP = 2;
	const DEBUG_MODE_VERBOSE = 4; //Settings which change page output even without any errors
	const DEBUG_MODE_CACHE = 8;
	const DEBUG_MODE_RESOURCE_LOADER = 16;
	const DEBUG_MODE_INSECURE = 32;/** @todo label appropriately and display warning if set */
	const DEBUG_MODE_ALL = 63;
	/**
	 * Which debug modes are set
	 *
	 * @var int
	 */
	private $mode;

	/**
	 * Array of variable settings to be ignored
	 * These can be variable settings of any type - ini, php, global
	 *
	 * @var array
	 */
	private $ignoreVars;

	public function getMode() {
		return $this->mode;
	}

	public function getIgnoreVars() {
		return $this->ignoreVars;
	}

	public function setMode( $mode ) {
		$this->mode = $mode;
	}

	public function setIgnoreVars( $ignoreVars ) {
		$this->ignoreVars = $ignoreVars;
	}

	public function __construct( $mode, $ignoreVars ) {
		$this->mode = $mode;
		$this->ignoreVars = $ignoreVars;
	}

	/**
	 * Set all settings
	 */
	public function setAll() {
		/** @todo Move all variables and mode requirements to an array */
		if ( $this->getMode() == self::DEBUG_MODE_NONE ) {
			return;
		}
		if ( $this->isModeSet( self::DEBUG_MODE_INI ) ) {
			$this->setPhpIniVars();
		}
		if ( $this->isModeSet( self::DEBUG_MODE_PHP ) ) {
			$this->setPhpFunctionVars();
		}
		$this->setGlobalVars();
	}

	/**
	 * Set php.ini variables
	 */
	private function setPhpIniVars() {
		$phpIniVarSetter = new PhpIniVarSetter( $this->getIgnoreVars() );
		$phpIniVarSetter->setVars( $this->getPhpIniVars() );
	}

	/**
	 * Get an array of ini variables with desired settings
	 *
	 * @return array
	 */
	private function getPhpIniVars() {
		return array( 'display_errors' => 1 );
	}

	/**
	 * Set php settings using a php function
	 */
	public function setPhpFunctionVars() {
		$phpFunctionVarSetter = new PhpFunctionVarSetter( $this->getIgnoreVars() );
		$phpFunctionVarSetter->setVars( $this->getPhpFunctionVars() );
	}

	/**
	 * Get an array of php setting functions and parameters
	 *
	 * @return array
	 */
	private function getPhpFunctionVars() {
		return array( 'error_reporting' => -1 );
	}

	/**
	 * Set MediaWiki globals
	 */
	private function setGlobalVars() {
		$trueVars = $this->getTrueGlobalVars();
		$globalVarSetter = new GlobalVarSetter( $this->getIgnoreVars() );
		$globalVarSetter->setVarsTo( $trueVars, true );

		$falseVars = $this->getFalseGlobalVars();
		$globalVarSetter->setVarsTo( $falseVars, false );

		$otherVars = $this->getOtherGlobalVars();
		$globalVarSetter->setVars( $otherVars );
	}

	/**
	 * Get an array of all MediaWiki globals that should be set to true
	 *
	 * @return array
	 */
	private function getTrueGlobalVars() {
		$varArray = array();

		if ( $this->isModeSet( self::DEBUG_MODE_VERBOSE ) ) {
			$varArray = array_merge( $varArray, array( 'wgShowDebug' ) );
		}
		if ( $this->isModeSet( self::DEBUG_MODE_RESOURCE_LOADER ) ) {
			$varArray = array_merge( $varArray, array( 'wgResourceLoaderDebug' ) );
		}
		$varArray = array_merge( $varArray,
			array( 'wgColorErrors', 'wgDebugAPI', 'wgDebugComments', 'wgDebugDBTransactions',
			'wgDebugDumpSql', 'wgDebugFunctionEntry', 'wgDebugPrintHttpHeaders', 'wgDebugTimestamps',
			'wgDebugToolbar', 'wgDevelopmentWarnings', 'wgLogExceptionBacktrace', 'wgShowDBErrorBacktrace',
			'wgShowExceptionDetails', 'wgShowSQLErrors' ) );

		return $varArray;
	}

	/**
	 * Get an array of all MediaWiki globals that should be set to false
	 *
	 * @return array
	 */
	private function getFalseGlobalVars() {
		$varArray = array();
		if ( $this->isModeSet( self::DEBUG_MODE_CACHE ) ) {
			$varArray = array_merge( $varArray,
				array( 'wgCachePages', 'wgDeprecationReleaseLimit', 'wgEnableParserCache' ) );
		}
		return $varArray;
	}

	/**
	 * Get an array of all MediaWiki globals and what they should be set to
	 *
	 * @return array GlobalVar => Value
	 */
	private function getOtherGlobalVars() {
		$varArray = array();

		if ( $this->isModeSet( self::DEBUG_MODE_RESOURCE_LOADER ) ) {
			$varArray['wgResourceLoaderMaxage'] = 1;
		}
		$varArray['wgProfileLimit'] = 0.0;

		return $varArray;
	}

	/**
	 * Check if this mode has been set
	 *
	 * @param int $mode
	 * @return boolean
	 */
	private function isModeSet( $mode ) {
		return (bool) ($this->getMode() & $mode);
	}
}

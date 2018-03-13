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
 * Utilities for DebugMode
 *
 * @author Ike Hecht
 */
class DebugModeUtils {

	/**
	 * Returns the default debug mode
	 *
	 * @return int Debug mode
	 */
	public static function getDefault() {
		return ( DebugMode::DEBUG_MODE_ALL ^ DebugMode::DEBUG_MODE_VERBOSE );
	}

	/**
	 * Set up DebugMode and set all settings
	 *
	 * @global boolean|int $wgDebugMode
	 * @global array $wgDebugModeIgnoreVars
	 */
	public static function setup() {
		global $wgDebugMode, $wgDebugModeIgnoreVars;

		/* allow true or false, for convenience */
		if ( $wgDebugMode === false ) {
			$wgDebugMode = DebugMode::DEBUG_MODE_NONE;
		} elseif ( $wgDebugMode === true ) {
			$wgDebugMode = DebugMode::DEBUG_MODE_ALL;
		}

		if ( $wgDebugMode == DebugMode::DEBUG_MODE_NONE ) {
			return;
		}

		$debugMode = new DebugMode( $wgDebugMode, $wgDebugModeIgnoreVars );
		$debugMode->setAll();
	}
}

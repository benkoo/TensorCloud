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
 * Set variables
 *
 * @author Ike Hecht
 */
abstract class VarSetter {
	private $ignoreVars;

	function getIgnoreVars() {
		return $this->ignoreVars;
	}

	function setIgnoreVars( $ignoreVars ) {
		$this->ignoreVars = $ignoreVars;
	}

	public function __construct( array $ignoreVars ) {
		$this->ignoreVars = $ignoreVars;
	}

	/**
	 * Brains of the class
	 * Inheritors use this function to set the var to equal value
	 */
	abstract protected function reallySetVar( $var, $value );

	/**
	 * Set a var, but only if it is not supposed to be ignored by the class
	 *
	 * @param string $var
	 * @param mixed $value
	 */
	final public function setVar( $var, $value ) {
		if ( !in_array( $var, $this->getIgnoreVars() ) ) {
			$this->reallySetVar( $var, $value );
		}
	}

	/**
	 * Set an array of vars where Var => Value
	 *
	 * @param array $varArray
	 */
	final public function setVars( $varArray ) {
		foreach ( $varArray as $var => $value ) {
			$this->setVar( $var, $value );
		}
	}

	/**
	 * Set each var in the array to the same value
	 *
	 * @param array $varArray
	 * @param mixed $value
	 */
	final public function setVarsTo( $varArray, $value ) {
		foreach ( $varArray as $var ) {
			$this->setVar( $var, $value );
		}
	}
}

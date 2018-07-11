<?php

namespace MediaWiki\Extensions\OAuth;

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
 * Wrapper of an MWOAuthDAO that handles authorization to view fields
 */
class MWOAuthDAOAccessControl extends \ContextSource {
	/** @var MWOAuthDAO */
	protected $dao;
	/** @var \RequestContext */
	protected $context;

	/**
	 * @param MWOAuthDAO $dao
	 * @param \RequestContext $context
	 */
	final protected function __construct( MWOAuthDAO $dao, \RequestContext $context ) {
		$this->dao = $dao;
		$this->context = $context;
	}

	/**
	 * @param MWOAuthDAO $dao
	 * @param \RequestContext $context
	 * @throws \MWException
	 * @return MWOAuthDAOAccessControl
	 */
	final public static function wrap( $dao, \RequestContext $context ) {
		if ( $dao instanceof MWOAuthDAO ) {
			return new static( $dao, $context );
		} elseif ( $dao === null || $dao === false ) {
			return $dao;
		} else {
			throw new \MWException( "Expected MWOAuthDAO object, null, or false." );
		}
	}

	/**
	 * @return MWOAuthDAO
	 */
	final public function getDAO() {
		return $this->dao;
	}

	/**
	 * Get the value of a field, taking into account user permissions.
	 * An appropriate Message will be returned if access is denied.
	 *
	 * @param string $name
	 * @param callback $sCallback Optional callback to apply to result on access success
	 * @return mixed Returns a Message on access failure
	 * @throws \Exception
	 */
	final public function get( $name, $sCallback = null ) {
		$msg = $this->dao->userCanAccess( $name, $this->context );
		if ( $msg !== true ) {
			return $msg; // should be a Message object
		} else {
			$value = $this->dao->get( $name );
			return $sCallback ? call_user_func( $sCallback, $value ) : $value;
		}
	}
}

<?php

namespace MediaWiki\Extensions\OAuth;

use Wikimedia\Rdbms\DBConnRef;
use Wikimedia\Rdbms\DBError;

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

use MediaWiki\Logger\LoggerFactory;

/**
 * Representation of a Data Access Object
 */
abstract class MWOAuthDAO implements \IDBAccessObject {
	private $daoOrigin = 'new'; // string; object construction origin
	private $daoPending = true; // bool; whether fields changed or the field is new

	/** @var \\Psr\\Log\\LoggerInterface */
	protected $logger;

	/**
	 * @throws \MWException
	 */
	final protected function __construct() {
		$fields = array_keys( static::getFieldPermissionChecks() );
		if ( array_diff( $fields, $this->getFieldNames() ) ) {
			throw new \MWException( "Invalid field(s) defined in access check methods." );
		}
		$this->logger = LoggerFactory::getInstance( 'OAuth' );
	}

	/**
	 * @param array $values (field => value) map
	 * @return MWOAuthDAO
	 */
	final public static function newFromArray( array $values ) {
		$consumer = new static();
		$consumer->loadFromValues( $values );
		return $consumer;
	}

	/**
	 * @param DBConnRef $db
	 * @param array|\stdClass $row
	 * @return MWOAuthDAO
	 */
	final public static function newFromRow( DBConnRef $db, $row ) {
		$consumer = new static();
		$consumer->loadFromRow( $db, $row );
		return $consumer;
	}

	/**
	 * @param DBConnRef $db
	 * @param int $id
	 * @param int $flags MWOAuthDAO::READ_* bitfield
	 * @return MWOAuthDAO|bool Returns false if not found
	 * @throws DBError
	 */
	final public static function newFromId( DBConnRef $db, $id, $flags = 0 ) {
		$row = $db->selectRow( static::getTable(),
			array_values( static::getFieldColumnMap() ),
			[ static::getIdColumn() => (int)$id ],
			__METHOD__,
			( $flags & self::READ_LOCKING ) ? [ 'FOR UPDATE' ] : []
		);

		if ( $row ) {
			$consumer = new static();
			$consumer->loadFromRow( $db, $row );
			return $consumer;
		} else {
			return false;
		}
	}

	/**
	 * Get the value of a field
	 *
	 * @param string $name
	 * @return mixed
	 * @throws \MWException
	 */
	final public function get( $name ) {
		if ( !static::hasField( $name ) ) {
			throw new \MWException( "Object has no '$name' field." );
		}
		return $this->$name;
	}

	/**
	 * Set the value of a field
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return mixed The old value
	 * @throws \Exception
	 */
	final public function setField( $name, $value ) {
		$old = $this->setFields( [ $name => $value ] );
		return $old[$name];
	}

	/**
	 * Set the values for a set of fields
	 *
	 * @param array $values (field => value) map
	 * @throws \MWException
	 * @return array Map of old values
	 */
	final public function setFields( array $values ) {
		$old = [];
		foreach ( $values as $name => $value ) {
			if ( !static::hasField( $name ) ) {
				throw new \MWException( "Object has no '$name' field." );
			}
			$old[$name] = $this->$name;
			$this->$name = $value;
			if ( $old[$name] !== $value ) {
				$this->daoPending = true;
			}
		}
		$this->normalizeValues();
		return $old;
	}

	/**
	 * @return array
	 */
	final public function getFieldNames() {
		return array_keys( static::getFieldColumnMap() );
	}

	/**
	 * @param DBConnRef $dbw
	 * @return bool
	 * @throws DBError
	 * @throws \MWException
	 */
	public function save( DBConnRef $dbw ) {
		$uniqueId = $this->getIdValue();
		$idColumn = static::getIdColumn();
		if ( !empty( $dbw->daoReadOnly ) ) {
			throw new \MWException( get_class( $this ) . ": tried to save while db is read-only" );
		}
		if ( $this->daoOrigin === 'db' ) {
			if ( $this->daoPending ) {
				$this->logger->debug( get_class( $this ) . ': performing DB update; object changed.' );
				$dbw->update(
					static::getTable(),
					$this->getRowArray( $dbw ),
					[ $idColumn => $uniqueId ],
					__METHOD__
				);
				$this->daoPending = false;
				return $dbw->affectedRows() > 0;
			} else {
				$this->logger->debug( get_class( $this ) . ': skipping DB update; object unchanged.' );
				return false; // short-circuit
			}
		} else {
			$this->logger->debug( get_class( $this ) . ': performing DB update; new object.' );
			$afield = static::getAutoIncrField();
			$acolumn = $afield !== null ? static::getColumn( $afield ) : null;
			$row = $this->getRowArray( $dbw );
			if ( $acolumn !== null && $row[$acolumn] === null ) {
				// auto-increment field should be omitted, not set null, for
				// auto-incrementing behavior
				unset( $row[$acolumn] );
			}
			$dbw->insert(
				static::getTable(),
				$row,
				__METHOD__
			);
			if ( $afield !== null ) { // update field for auto-increment field
				$this->$afield = $dbw->insertId();
			}
			$this->daoPending = false;
			return true;
		}
	}

	/**
	 * @param DBConnRef $dbw
	 * @return bool
	 * @throws \MWException
	 */
	public function delete( DBConnRef $dbw ) {
		$uniqueId = $this->getIdValue();
		$idColumn = static::getIdColumn();
		if ( !empty( $dbw->daoReadOnly ) ) {
			throw new \MWException( get_class( $this ) . ": tried to delete while db is read-only" );
		}
		if ( $this->daoOrigin === 'db' ) {
			$dbw->delete(
				static::getTable(),
				[ $idColumn => $uniqueId ],
				__METHOD__
			);
			$this->daoPending = true;
			return $dbw->affectedRows() > 0;
		} else {
			return false;
		}
	}

	/**
	 * Get the schema information for this object type
	 *
	 * This should return an associative array with:
	 *   - idField        : a field with an int/hex UNIQUE identifier
	 *   - autoIncrField  : a field that auto-increments in the DB (or NULL if none)
	 *   - table          : a table name
	 *   - fieldColumnMap : a map of field names to column names
	 *
	 * @throws \MWException
	 * @return array
	 */
	protected static function getSchema() {
		// Note: declaring this abstract raises E_STRICT
		throw new \MWException( "getSchema() not defined in " . get_class() );
	}

	/**
	 * Get the access control check methods for this object type
	 *
	 * This returns a map of field names to method names.
	 * The methods check if a context user has access to the field,
	 * returning true if they do and a Message object otherwise.
	 * The methods take (field name, \RequestContext) as arguments.
	 *
	 * @see MWOAuthDAO::userCanAccess()
	 * @see MWOAuthDAOAccessControl
	 *
	 * @throws \MWException
	 * @return array Map of (field name => name of method that checks access)
	 */
	protected static function getFieldPermissionChecks() {
		// Note: declaring this abstract raises E_STRICT
		throw new \MWException( "getFieldPermissionChecks() not defined in " . get_class() );
	}

	/**
	 * @return string
	 */
	final protected static function getTable() {
		$schema = static::getSchema();
		return $schema['table'];
	}

	/**
	 * @return array
	 */
	final protected static function getFieldColumnMap() {
		$schema = static::getSchema();
		return $schema['fieldColumnMap'];
	}

	/**
	 * @param string $field
	 * @return string
	 */
	final protected static function getColumn( $field ) {
		$schema = static::getSchema();
		return $schema['fieldColumnMap'][$field];
	}

	/**
	 * @param string $field
	 * @return bool
	 */
	final protected static function hasField( $field ) {
		$schema = static::getSchema();
		return isset( $schema['fieldColumnMap'][$field] );
	}

	/**
	 * @return string|null
	 */
	final protected static function getAutoIncrField() {
		$schema = static::getSchema();
		return isset( $schema['autoIncrField'] ) ? $schema['autoIncrField'] : null;
	}

	/**
	 * @return string
	 */
	final protected static function getIdColumn() {
		$schema = static::getSchema();
		return $schema['fieldColumnMap'][$schema['idField']];
	}

	/**
	 * @return int|string
	 */
	final protected function getIdValue() {
		$schema = static::getSchema();
		$field = $schema['idField'];
		return $this->$field;
	}

	/**
	 * @param array $values
	 * @throws \MWException
	 */
	final protected function loadFromValues( array $values ) {
		foreach ( static::getFieldColumnMap() as $field => $column ) {
			if ( !array_key_exists( $field, $values ) ) {
				throw new \MWException( get_class( $this ) . " requires '$field' field." );
			}
			$this->$field = $values[$field];
		}
		$this->normalizeValues();
		$this->daoOrigin = 'new';
		$this->daoPending = true;
	}

	/**
	 * Subclasses should make this normalize fields (e.g. timestamps)
	 *
	 * @return void
	 */
	abstract protected function normalizeValues();

	/**
	 * @param DBConnRef $db
	 * @param \stdClass|array $row
	 * @return void
	 */
	final protected function loadFromRow( DBConnRef $db, $row ) {
		$row = $this->decodeRow( $db, (array)$row );
		$values = [];
		foreach ( static::getFieldColumnMap() as $field => $column ) {
			$values[$field] = $row[$column];
		}
		$this->loadFromValues( $values );
		$this->daoOrigin = 'db';
		$this->daoPending = false;
	}

	/**
	 * Subclasses should make this to encode DB fields (e.g. timestamps).
	 * This must also flatten any PHP data structures into flat values.
	 *
	 * @param DBConnRef $db
	 * @param array $row
	 * @return array
	 */
	abstract protected function encodeRow( DBConnRef $db, $row );

	/**
	 * Subclasses should make this to decode DB fields (e.g. timestamps).
	 * This can also expand some flat values (e.g. JSON) into PHP data structures.
	 * Note: this does not need to handle what normalizeValues() already does.
	 *
	 * @param DBConnRef $db
	 * @param array $row
	 * @return array
	 */
	abstract protected function decodeRow( DBConnRef $db, $row );

	/**
	 * @param DBConnRef $db
	 * @return array
	 */
	final protected function getRowArray( DBConnRef $db ) {
		$row = [];
		foreach ( static::getFieldColumnMap() as $field => $column ) {
			$row[$column] = $this->$field;
		}
		return $this->encodeRow( $db, $row );
	}

	/**
	 * Check if a user (from the context) can view a field
	 *
	 * @see MWOAuthDAO::userCanAccess()
	 * @see MWOAuthDAOAccessControl
	 *
	 * @param string $name
	 * @param \RequestContext $context
	 * @return \Message|true Returns on success or a Message if the user lacks access
	 * @throws \Exception
	 */
	final public function userCanAccess( $name, \RequestContext $context ) {
		$map = static::getFieldPermissionChecks();
		if ( isset( $map[$name] ) ) {
			$method = $map[$name];
			return $this->$method( $name, $context );
		} else {
			return true;
		}
	}

	/**
	 * Get the current conflict token value for a user
	 *
	 * @param \RequestContext $context
	 * @return string Hex token
	 */
	final public function getChangeToken( \RequestContext $context ) {
		$map = [];
		foreach ( $this->getFieldNames() as $field ) {
			if ( $this->userCanAccess( $field, $context ) ) {
				$map[$field] = $this->$field;
			} else {
				$map[$field] = null; // don't convey this information
			}
		}
		return hash_hmac(
			'sha1',
			serialize( $map ),
			"{$context->getUser()->getId()}#{$this->getIdValue()}"
		);
	}

	/**
	 * Compare an old change token to the current one
	 *
	 * @param \RequestContext $context
	 * @param string $oldToken
	 * @return bool Whether the current is unchanged
	 */
	final public function checkChangeToken( \RequestContext $context, $oldToken ) {
		return ( $this->getChangeToken( $context ) === $oldToken );
	}

	/**
	 * Update whether this object should be written to the data store
	 * @param bool $pending set to true to mark this object as needing to write its data
	 */
	public function setPending( $pending ) {
		$this->daoPending = $pending;
	}

	/**
	 * Update the origin of this object
	 * @param string $source source of the object
	 * 	'new': Treat this as a new object to the datastore (insert on save)
	 * 	'db': Treat this as already in the datastore (update on save)
	 */
	public function updateOrigin( $source ) {
		$this->daoOrigin = $source;
	}
}

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
 * Handle the logic of submitting a client request
 */
abstract class MWOAuthSubmitControl extends \ContextSource {
	/** @var \RequestContext */
	protected $context;
	/** @var Array (field name => value) */
	protected $vals;

	/**
	 * @param \IContextSource $context
	 * @param array $params
	 */
	public function __construct( \IContextSource $context, array $params ) {
		$this->context = $context;
		$this->vals = $params;
	}

	/**
	 * @param array $params
	 */
	public function setInputParameters( array $params ) {
		$this->vals = $params;
	}

	/**
	 * Attempt to validate and submit this data
	 *
	 * This will check basic permissions, validate the action and paramters
	 * and route the submission handling to the internal subclass function.
	 *
	 * @throws \MWException
	 * @return \Status
	 */
	public function submit() {
		$status = $this->checkBasePermissions();
		if ( !$status->isOK() ) {
			return $status;
		}

		$action = $this->vals['action'];
		$required = $this->getRequiredFields();
		if ( !isset( $required[$action] ) ) {
			// @TODO: check for field-specific message first
			return $this->failure( 'invalid_field_action', 'mwoauth-invalid-field', 'action' );
		}

		$status = $this->validateFields( $required[$action] );
		if ( !$status->isOK() ) {
			return $status;
		}

		$status = $this->processAction( $action );
		if ( $status instanceof \Status ) {
			return $status;
		} else {
			throw new \MWException( "Submission action '$action' not handled." );
		}
	}

	/**
	 * Given an HTMLForm descriptor array, register the field validation callbacks
	 *
	 * @param array $descriptors
	 * @return array
	 */
	public function registerValidators( array $descriptors ) {
		foreach ( $descriptors as $field => &$description ) {
			if ( array_key_exists( 'validation-callback', $description ) ) {
				continue; // already set to something
			}
			$control = $this;
			$description['validation-callback'] =
				function ( $value, $allValues, $form ) use ( $control, $field ) {
					return $control->validateFieldInternal( $field, $value, $allValues, $form );
				};
		}
		return $descriptors;
	}

	/**
	 * This method should not be called outside MWOAuthSubmitControl
	 *
	 * @param string $field
	 * @param string $value
	 * @param array $allValues
	 * @param \HTMLForm $form
	 * @throws \MWException
	 * @return bool|string
	 */
	public function validateFieldInternal( $field, $value, $allValues, $form ) {
		if ( !isset( $allValues['action'] ) && isset( $this->vals['action'] ) ) {
			// The action may be derived, especially for multi-button forms.
			// Such an HTMLForm will not have an action key set in $allValues.
			$allValues['action'] = $this->vals['action']; // injected
		}
		if ( !isset( $allValues['action'] ) ) {
			throw new \MWException( "No form action defined; cannot validate fields." );
		}
		$validators = $this->getRequiredFields();
		if ( !isset( $validators[$allValues['action']][$field] ) ) {
			return true; // nothing to check
		}
		$validator = $validators[$allValues['action']][$field];
		$isValid = is_string( $validator ) // regex
			? preg_match( $validator, $value )
			: $validator( $value, $allValues );
		if ( !$isValid ) {
			$errorMessage = wfMessage( 'mwoauth-invalid-field-' . $field );
			if ( !$errorMessage->isDisabled() ) {
				return $errorMessage->text();
			}

			$generic = '';
			if ( $form->getField( $field )->canDisplayErrors() ) {
				// error can be attached to the field so no need to mention the field name
				$generic = '-generic';
			}

			$problem = 'invalid';
			if ( $value === '' && !$generic ) {
				$problem = 'missing';
			}

			// messages: mwoauth-missing-field, mwoauth-invalid-field, mwoauth-invalid-field-generic
			return wfMessage( "mwoauth-$problem-field$generic", $field )->text();
		}
		return true;
	}

	/**
	 * Get the field names and their validation regexes or functions
	 * (which return a boolean) for each action that this controller handles.
	 * When functions are used, they take (field value, field/value map) as params.
	 *
	 * @return Array (action => (field name => validation regex or function))
	 */
	abstract protected function getRequiredFields();

	/**
	 * Check action-independent permissions against the user for this submission
	 *
	 * @return \Status
	 */
	abstract protected function checkBasePermissions();

	/**
	 * Check that the action is valid and that the required fields are valid
	 *
	 * @param array $required (field => regex or callback)
	 * @return \Status
	 */
	protected function validateFields( array $required ) {
		foreach ( $required as $field => $validator ) {
			if ( !isset( $this->vals[$field] ) ) {
				// @TODO: check for field-specific message first
				return $this->failure( "missing_field_$field", 'mwoauth-missing-field', $field );
			} elseif ( !is_scalar( $this->vals[$field] ) && $field !== 'restrictions' ) {
				// @TODO: check for field-specific message first
				return $this->failure( "invalid_field_$field", 'mwoauth-invalid-field', $field );
			}
			if ( is_string( $this->vals[$field] ) ) {
				$this->vals[$field] = trim( $this->vals[$field] ); // trim all input
			}
			$valid = is_string( $validator ) // regex
				? preg_match( $validator, $this->vals[$field] )
				: $validator( $this->vals[$field], $this->vals );
			if ( !$valid ) {
				// @TODO: check for field-specific message first
				return $this->failure( "invalid_field_$field", 'mwoauth-invalid-field', $field );
			}
		}
		return $this->success();
	}

	/**
	 * Attempt to validate and submit this data for the given action
	 *
	 * @param string $action
	 * @return array Status
	 */
	abstract protected function processAction( $action );

	/**
	 * @param string $error API error key
	 * @param string $msg Message key
	 * @param mixed $params,... Additional arguments used as message parameters
	 * @return \Status
	 */
	protected function failure( $error, $msg /*, params */ ) {
		$params = array_slice( func_get_args(), 2 );
		// Use the same logic as wfMessage
		if ( isset( $params[0] ) && is_array( $params[0] ) ) {
			$params = $params[0];
		}
		$status = \Status::newFatal( $this->context->msg( $msg, $params ) );
		$status->value = [ 'error' => $error, 'result' => null ];
		return $status;
	}

	/**
	 * @param mixed $value
	 * @return \Status
	 */
	protected function success( $value = null ) {
		return \Status::newGood( [ 'error' => null, 'result' => $value ] );
	}
}

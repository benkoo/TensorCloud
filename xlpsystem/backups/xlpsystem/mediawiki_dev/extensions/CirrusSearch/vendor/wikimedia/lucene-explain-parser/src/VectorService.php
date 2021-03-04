<?php
namespace LuceneExplain;

/**
 * Basic vector operations used by explain service
 */
class VectorService
{

	public static function create() {
		return new SparseVector();
	}

	public static function add( SparseVector $lhs, SparseVector $rhs ) {
		$rval = self::create();
		foreach ( $lhs->values() as $k => $v ) {
			$rval->set( $k, $v );
		}
		foreach ( $rhs->values() as $k => $v ) {
			$rval->set( $k, $v );
		}
		return $rval;
	}

	public static function scale( SparseVector $lhs, $scalar ) {
		$rval = self::create();
		foreach ( $lhs->values() as $k => $v ) {
			$rval->set( $k, $v * $scalar );
		}
		return $rval;
	}

}

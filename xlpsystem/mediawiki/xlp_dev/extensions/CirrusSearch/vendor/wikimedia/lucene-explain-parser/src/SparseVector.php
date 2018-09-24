<?php
namespace LuceneExplain;

class SparseVector
{

	private $vec = [];
	/**
	 * @var string
	 */
	private $asStr;

	private function setDirty() {
		$this->asStr = null;
	}

	public function set( $key, $value ) {
		$this->vec[$key] = $value;
		$this->setDirty();
	}

	public function get( $key ) {
		return isset( $this->vec[$key] ) ? $this->vec[$key] : null;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		if ( $this->asStr === null ) {
			$sorted = $this->vec;
			asort( $sorted );
			foreach ( $sorted as $k => $v ) {
				$this->asStr .= "$k $v\n";
			}
		}
		return $this->asStr;
	}

	public function values() {
		return $this->vec;
	}

}

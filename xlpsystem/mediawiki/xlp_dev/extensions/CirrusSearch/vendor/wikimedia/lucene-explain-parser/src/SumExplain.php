<?php
namespace LuceneExplain;

class SumExplain extends Explain
{

	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );
		$this->realExplanation = 'Sum of the following:';
	}

	public function influencers() {
		$infl = [];
		foreach ( $this->children as $child ) {
			// take advantage of commutative property
			if ( $child instanceof SumExplain ) {
				foreach ( $child->influencers() as $grandchild ) {
					$infl[] = $grandchild;
				}
			} else {
				$infl[] = $child;
			}
		}
		return $this->scoreSort( $infl );
	}

	public function vectorize() {
		$rVal = VectorService::create();
		foreach ( $this->influencers() as $infl ) {
			$rVal = VectorService::add( $rVal, $infl->vectorize() );
		}
		return $rVal;
	}

}

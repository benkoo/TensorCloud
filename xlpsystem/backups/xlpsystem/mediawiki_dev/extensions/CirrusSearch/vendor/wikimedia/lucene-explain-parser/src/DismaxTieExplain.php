<?php
namespace LuceneExplain;

class DismaxTieExplain extends Explain
{

	/** @var float */
	private $tie;

	public function __construct( array $explJson, ExplainFactory $explFactory, $tie ) {
		parent::__construct( $explJson, $explFactory );
		$this->realExplanation = "Dismax (max plus: $tie times others)";
		$this->tie = $tie;
	}

	/**
	 * @return Explain[]
	 */
	public function influencers() {
		return $this->scoreSort( $this->children );
	}

	public function vectorize() {
		$infl = $this->influencers();
		$rVal = $infl[0]->vectorize();
		foreach ( array_slice( $infl, 1 ) as $currInfl ) {
			$vInfl = $currInfl->vectorize();
			$vInflScaled = VectorService::scale( $vInfl, $this->tie );
			$rVal = VectorService::add( $rVal, $vInflScaled );
		}
		return $rVal;
	}
}

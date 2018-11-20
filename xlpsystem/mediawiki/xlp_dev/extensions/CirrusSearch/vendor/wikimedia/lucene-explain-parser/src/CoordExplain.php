<?php
namespace LuceneExplain;

class CoordExplain extends Explain
{

	/** @var float */
	private $coordFactor;

	public function __construct( array $explJson, ExplainFactory $explFactory, $coordFactor ) {
		parent::__construct( $explJson, $explFactory );
		$this->coordFactor = $coordFactor;
		if ( $coordFactor < 1.0 ) {
			$this->realExplanation = "Matches Punished by $coordFactor (not all query terms matched)";
		}
	}

	public function influencers() {
		if ( $this->coordFactor >= 1.0 ) {
			return parent::influencers();
		}
		$infl = [];
		foreach ( $this->children as $child ) {
			if ( !ExplainFactory::strHasSubstr( $child->description, 'coord' ) ) {
				$infl[] = $child;
			}
		}
		return $infl;
	}

	public function vectorize() {
		if ( $this->coordFactor >= 1.0 ) {
			return parent::vectorize();
		}
		$rval = VectorService::create();
		foreach ( $this->influencers() as $infl ) {
			$rval = VectorService::add( $rval, $infl->vectorize() );
		}
		$rval = VectorService::scale( $rval, $this->coordFactor );
		return $rval;
	}
}

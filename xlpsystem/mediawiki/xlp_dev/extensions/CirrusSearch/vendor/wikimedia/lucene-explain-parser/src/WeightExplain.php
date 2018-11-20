<?php
namespace LuceneExplain;

class WeightExplain extends Explain {
	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );

		if ( preg_match( '/weight\((.*?)\s+in\s+\d+?\)/', $explJson['description'], $matches ) ) {
			$this->realExplanation = $matches[1];
		} else {
			$productOf = ', product of:';
			if ( ExplainFactory::strEndsWith( $explJson['description'], $productOf ) ) {
				$this->realExplanation = substr( $explJson['description'], 0, -strlen( $productOf ) );
			}
		}
	}

	public function hasMatch() {
		return true;
	}

	public function getMatch() {
		/*
        if ( ExplainFactory::strHasSubstr( $this->description, 'DefaultSimilarity' ) ) {
            return new DefaultSimilarityMatch( $this->children );
        } elseif ( ExplainFactory::strHasSubstr( $this->description, 'PerFieldSimilarity' ) ) {
            // @TODO
            return null;
        }
        */
		return null;
	}

	public function matchDetails() {
		return [ $this->explanation() => $this->toRawString() ];
	}

}

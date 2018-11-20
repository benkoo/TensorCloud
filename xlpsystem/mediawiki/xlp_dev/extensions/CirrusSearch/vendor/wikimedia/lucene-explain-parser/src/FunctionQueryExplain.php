<?php
namespace LuceneExplain;

class FunctionQueryExplain extends Explain {
	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );
		if ( preg_match( '/FunctionQuery\((.*)\)/', $explJson['description'], $matches ) ) {
			$this->realExplanation = $matches[1];
		}
	}
}


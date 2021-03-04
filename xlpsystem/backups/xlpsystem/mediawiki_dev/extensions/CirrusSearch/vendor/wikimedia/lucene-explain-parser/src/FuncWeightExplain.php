<?php
namespace LuceneExplain;

class FuncWeightExplain extends Explain {
	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );
		$this->realExplanation = 'f( -- constant weight -- ) = ' . $explJson['value'];
	}

}


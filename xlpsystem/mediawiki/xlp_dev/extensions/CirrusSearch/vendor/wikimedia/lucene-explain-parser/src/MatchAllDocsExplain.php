<?php
namespace LuceneExplain;

class MatchAllDocsExplain extends Explain {
	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );
		$this->realExplanation = 'Match All Docs (*:*)';
	}

}

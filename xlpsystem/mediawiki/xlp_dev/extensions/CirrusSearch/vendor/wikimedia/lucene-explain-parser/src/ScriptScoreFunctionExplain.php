<?php

namespace LuceneExplain;

class ScriptScoreFunctionExplain extends Explain
{

	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );
		if ( ExplainFactory::strHasSubstr( $explJson['description'],
					"type=inline, lang='expression', " ) ) {
			$this->realExplanation = preg_replace( '/^.*idOrCode=/U', '{code=', $this->realExplanation );
			$this->realExplanation = str_replace( "\n", "", $this->realExplanation );
		}
	}

}

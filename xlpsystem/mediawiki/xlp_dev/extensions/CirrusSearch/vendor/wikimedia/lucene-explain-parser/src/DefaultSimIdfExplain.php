<?php
namespace LuceneExplain;

class DefaultSimIdfExplain extends Explain
{

	private $influencers = [];

	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );
		$desc = $explJson['description'];
		if ( count( $this->children ) > 1 && ExplainFactory::strHasSubstr( $desc, 'sum of:' ) ) {
			$this->realExplanation = 'IDF Score';
			$this->influencers = $this->children;
		} elseif ( preg_match( '/idf\(docFreq=(\d+),.*maxDocs=(\d+)\)/', $desc, $matches ) ) {
			$this->realExplanation = 'IDF Score';
		}
	}

	public function influencers() {
		return $this->influencers;
	}

}

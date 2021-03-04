<?php
namespace LuceneExplain;

class FieldFunctionQueryExplain extends Explain
{

	public function __construct( array $explJson, ExplainFactory $explFactory ) {
		parent::__construct( $explJson, $explFactory );

		$fieldName = 'unknown';
		if ( preg_match( '/Function for field (.*?):/', $explJson['description'], $matches ) ) {
			$fieldName = $matches[1];
		}
		$this->realExplanation = "f($fieldName)";
		foreach ( $this->children as $child ) {
			$this->realExplanation .= $child->description;
		}
	}
}

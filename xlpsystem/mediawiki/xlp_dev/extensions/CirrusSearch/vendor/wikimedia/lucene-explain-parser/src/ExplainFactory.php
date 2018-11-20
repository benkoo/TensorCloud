<?php
namespace LuceneExplain;

class ExplainFactory {

	/**
	 * Counter for how many explains were created.
	 * @var int
	 */
	private $counter = 0;

	private function meOrOnlyChild( Explain $explain ) {
		$infl = $explain->influencers();
		if ( count( $infl ) === 1 ) {
			return reset( $infl );
		} else {
			return $explain;
		}
	}

	private function replaceBadJson( array $explJson ) {
		return $explJson ?: [
			'details' => [],
			'description' => 'no explain for doc',
			'value' => 0.0,
			'match' => true,
		];
	}

	public static function strStartsWith( $string, $startsWith ) {
		return substr( $string, 0, strlen( $startsWith ) ) === $startsWith;
	}

	public static function strHasSubstr( $string, $subStr ) {
		return strpos( $string, $subStr ) !== false;
	}

	public static function strEndsWith( $string, $endsWith ) {
		return substr( $string, -strlen( $endsWith ) ) === $endsWith;
	}

	/**
	 * Create new Explain from JSON data.
	 * @param array $explJson
	 * @return Explain
	 */
	public function createExplain( array $explJson ) {
		$description = $explJson['description'];
		$details = [];
		$ignored = null;
		$tieMatch = preg_match( '/max plus ([0-9.]+) times/', $description, $tieMatches );
		$prefixMatch = preg_match( '/\:.*?\*(\^.+?)?, product of/', $description, $prefixMatches );
		if ( isset( $explJson['details'] ) ) {
			$details = $explJson['details'];
		}

		if ( self::strStartsWith( $description, 'score(' ) ) {
			return new ScoreExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'tf(' ) ) {
			return null; // new DefaultSimTfExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'idf(' ) ) {
			return new DefaultSimIdfExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'fieldWeight' ) ) {
			return null; // new FieldWeightExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'queryWeight' ) ) {
			return null; // new QueryWeightExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'ConstantScore' ) ) {
			return new ConstantScoreExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'MatchAllDocsQuery' ) ) {
			return new MatchAllDocsExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'weight(' ) ) {
			return new WeightExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'FunctionQuery' ) ) {
			return new FunctionQueryExplain( $explJson, $this );
		} elseif ( self::strStartsWith( $description, 'Function for field' ) ) {
			return new FieldFunctionQueryExplain( $explJson, $this );
		} elseif ( $prefixMatch ) {
			return new WeightExplain( $explJson, $this );
		} elseif ( $explJson['value'] === 0.0 && (
				self::strStartsWith( $description, 'match on required clause' ) ||
				self::strStartsWith( $description, 'match filter' )
			) ) {
			// Because ElasticSearch function queries filter when they apply
			// boosts (this doesn't matter in scoring)
			return null;
		} elseif ( self::strStartsWith( $description, 'queryBoost' ) ) {
			if ( $explJson['value'] === 1.0 ) {
				// ElasticSearch function queries always add 'queryBoost' of 1,
				// even when boost not specified
				return null;
			}
		} elseif ( self::strStartsWith( $description, 'script score function, computed with script:' ) ) {
			return new ScriptScoreFunctionExplain( $explJson, $this );
		} elseif ( self::strHasSubstr( $description, 'constant score' ) &&
			self::strHasSubstr( $description, 'no function provided' )
		) {
			return null;
		} elseif ( $description === 'weight' ) {
			return new FuncWeightExplain( $explJson, $this );
		} elseif ( $tieMatch ) {
			return new DismaxTieExplain( $explJson, $this, (float)$tieMatches[1] );
		} elseif ( self::strHasSubstr( $description, 'max of' ) ) {
			return $this->meOrOnlyChild( new DismaxExplain( $explJson, $this ) );
		} elseif ( self::strHasSubstr( $description, 'sum of' )
				|| self::strHasSubstr( $description, 'score mode [sum]' ) ) {
			return $this->meOrOnlyChild( new SumExplain( $explJson, $this ) );
		} elseif ( self::strHasSubstr( $description, 'Math.min of' ) || $description === 'min of:' ) {
			return $this->meOrOnlyChild( new MinExplain( $explJson, $this ) );
		} elseif ( self::strHasSubstr( $description, 'score mode [multiply]' ) ) {
			return $this->meOrOnlyChild( new ProductExplain( $explJson, $this ) );
		} elseif ( self::strHasSubstr( $description, 'product of' ) ) {
			if ( count( $details ) === 2 ) {
				foreach ( $details as $detail ) {
					if ( self::strStartsWith( $detail['description'], 'coord(' ) ) {
						return new CoordExplain( $explJson, $this, (float)$detail['value'] );
					}
				}
			}
			return $this->meOrOnlyChild( new ProductExplain( $explJson, $this ) );
		}

		return new Explain( $explJson, $this );
	}

	public function getCounter() {
		return $this->counter++;
	}
}

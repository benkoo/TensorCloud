PHP Classes for parsing and pretty-printing Lucene explain structures.

Makes the data (more) human-readable.

This is all based off of https://github.com/o19s/splainer-search, which does
much nicer prints of lucene explains for splainer.io.

Usage:

    $factory = new ExplainFactory();
    $explain = $factory->createExplain( $jsonFromLucene );
    $prettyResult = (string)$explain;

[![Build Status](https://travis-ci.org/wikimedia/wikimedia-lucene-explain-parser.svg?branch=master)](https://travis-ci.org/wikimedia/wikimedia-lucene-explain-parser)


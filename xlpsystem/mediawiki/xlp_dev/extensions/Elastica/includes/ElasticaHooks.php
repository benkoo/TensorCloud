<?php

class ElasticaHooks {
	/**
	 * Check if cURL PHP extension is installed
	 */
	public static function checkInstalledCurl() {
		if ( function_exists( 'curl_version' ) ) {
			return;
		}

		$phpVersionCheck = new \PHPVersionCheck();
		$errorMessageLong = 'The Elastica extension requires the <b>cURL</b> PHP extension to operate,'
			. ' but it is not installed on this server.';
		$phpVersionCheck->triggerError(
			'Required dependency for Elastica is missing',
			$phpVersionCheck->getIndexErrorOutput(
				'Required dependency for Elastica is missing',
				$errorMessageLong . ' Please install the <b>cURL</b> PHP extension.',
				'cURL PHP extension is not installed'
			),
			$errorMessageLong,
			$errorMessageLong
		);
	}
}

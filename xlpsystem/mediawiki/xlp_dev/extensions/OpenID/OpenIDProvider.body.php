<?php
/**
 * OpenIDProvider.php -- Class referring to an individual OpenID provider
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @file
 * @ingroup Extensions
 */
class OpenIDProvider {
	/**
	 * Properties about this provider
	 * @var string providerName
	 * @var string small|large largeOrSmallProvider
	 * @var string labeltext
	 * @var string OpenID url;
	 */
	protected $providerName, $largeOrSmallProvider, $label, $url;

	public function __construct( $providerName, $largeOrSmallProvider, $label, $url ) {
		$this->providerName = $providerName;
		$this->largeOrSmallProvider = $largeOrSmallProvider;
		$this->label = $label;
		$this->url = $url;
	}

	/**
	 * @return boolean
	 */
	public function isLargeProvider() {
		return $this->largeOrSmallProvider === 'large';
	}

	/**
	 * @return string
	 */
	public function providerName() {
		return $this->providerName;
	}

	/**
	 * Get the HTML for the OpenID provider buttons
	 * @return string
	 */
	public function getButtonHTML() {
		global $wgOpenIDShowProviderIcons;

		$class = $this->isLargeProvider() ? 'large' : 'small';
		if ( $wgOpenIDShowProviderIcons ) {
			return Html::element( 'a',
				array(
					'id' => 'openid_provider_' . $this->providerName . '_icon',
					'title' => $this->providerName,
					'href' => 'javascript:openid.show(\'' . $this->providerName . '\');',
					'class' => "openid_{$class}_btn"
				)
			);
		} else {
			return Html::element( 'a',
				array(
					'id' => 'openid_provider_' . $this->providerName . '_link',
					'title' => $this->providerName,
					'href' => 'javascript:openid.show(\'' . $this->providerName . '\');',
					'class' => "openid_{$class}_link"
				),
				$this->providerName
			);
		}

	}

	/**
	 * @return string
	 */
	public function getLoginFormHTML() {
		global $wgRequest, $wgOpenIDDefaultProviderName;
		$param_id = 'openid_provider_param_' . $this->providerName;
		$html = Html::element( 'input',
			array(
				'type' => 'hidden',
				'id' => 'openid_provider_url_' . $this->providerName,
				'value' => $this->url,
				'class' => 'openid-provider-selection-input'
			)
		);


		if ( strpos( $this->url, '{' ) === false ) {
			$inputHtml = '';
		} else {
			$inputHtml = Html::element( 'input',
				array(
					'type' => 'text',
					'id' => $param_id,
					'value' => htmlspecialchars( $wgRequest->getCookie( "_{$param_id}", null, '' ) ),
					'class' => 'openid-provider-selection-input'
				)
			);
		}
		// this class hides all the forms by default
		$class = 'openid_provider_form';
		if ( $wgOpenIDDefaultProviderName == $this->providerName ) {
			// mark this as default provider so JS can find it
			$class .= " openid_default_provider";
		}
		$html .= Html::rawElement( 'div',
			array(
				'id' => 'provider_form_' . $this->providerName,
				'class' => $class,
				'style' => 'display:none;',
				'data-provider-name' => $this->providerName
			),
			Html::rawElement( 'label', null, $this->label . '<br />' . $inputHtml ) .
			Xml::submitButton(
				OpenID::loginOrCreateAccountOrConvertButtonLabel(),
				array( 'id' => 'openid-provider-selection-submit-button' )
			)
		);
		return $html;
	}

	/**
	 * Get the list of major OpenID providers
	 *
	 * @param $largeOrSmallProvider OPTIONAL; when specified as 'large' or 'small' return only those providers
	 * @return array of OpenIDProvider
	 */
	public static function getProviders( $largeOrSmallProvider = null ) {
		global $wgOpenIDProviders;

		$ret = array();

		if ( is_array( $wgOpenIDProviders ) ) {

			foreach ( $wgOpenIDProviders as $providerName => $provider ) {
				if ( isset( $provider['label'] ) ) {
					// fixed, non-localized label string
					$label = $provider['label'];
				} elseif ( wfMessage( 'openid-provider-label-' . strtolower( $providerName ) )->exists() ) {
						$label = wfMessage( 'openid-provider-label-' . strtolower( $providerName ) )->text();
				} else {
					$label = wfMessage( 'openid-provider-label-other-username', array( $providerName ) )->text();
				}
				$provider = new self( $providerName,
					$provider['large-provider'] ? 'large' : 'small',
					$label,
					$provider['openid-url']
				);
				if ( $largeOrSmallProvider === null
					|| $largeOrSmallProvider == $provider->largeOrSmallProvider ) {
					$ret[] = $provider;
				}
			}

		}

		return $ret;

	}

}

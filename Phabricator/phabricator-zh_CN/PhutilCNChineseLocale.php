<?php

/**
 * The default Chinese locale.
 */
final class PhutilCNChineseLocale extends PhutilLocale {

  public function getLocaleCode() {
    return 'zh_CN';
  }

  public function getLocaleName() {
    return pht('中文 (简体中文)');
  }

}

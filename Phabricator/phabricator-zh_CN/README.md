# phabricator-zh_CN
Phabricator locales for zh_CN

About
=====

The ``phabricator-zh_CN`` project provides chinese locales for `Phabricator <https://phabricator.com>`.

Setup
-----

1. Drop the code into phabricator/src/extensions/
2. Configure Settings -> Account -> Account Settings -> Translation via http://issue.wanthings.com/settings/panel/account/
3. Select`中文 (简体中文)`.
4. for example: http://remix.network/settings/user/user/


FAQ
-----
Q: 提示`Two subclasses of "PhutilLocale" ("PhutilCNChineseLocale" and "PhutilSimplifiedChineseChinaLocale") define locales with the same locale code ("zh_CN"). Each locale must have a unique locale code.`
A: 请删除翻译项目中的`PhutilCNChineseLocale.php`文件

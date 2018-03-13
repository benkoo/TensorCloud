<?php
/*
 * Copyright (C) 2014 Ike Hecht
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * DebugMode extension - Puts wiki into debug mode
 *
 * For more info see http://mediawiki.org/wiki/Extension:DebugMode
 *
 * @file
 * @ingroup Extensions
 * @author Ike Hecht
 * @license GNU General Public License 2.0 or later
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DebugMode',
	'author' => 'Ike Hecht',
	'version' => '0.1.0 beta',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DebugMode',
	'descriptionmsg' => 'debugmode-desc',
	'license-name' => 'GPL-2.0+'
);

$wgMessagesDirs['DebugMode'] = __DIR__ . '/i18n';
$wgAutoloadClasses['DebugMode'] = __DIR__ . '/DebugMode.class.php';
$wgAutoloadClasses['DebugModeUtils'] = __DIR__ . '/DebugMode.utils.php';

$wgAutoloadClasses['VarSetter'] = __DIR__ . '/VarSetters/VarSetter.php';
$wgAutoloadClasses['GlobalVarSetter'] = __DIR__ . '/VarSetters/GlobalVarSetter.php';
$wgAutoloadClasses['PhpFunctionVarSetter'] = __DIR__ . '/VarSetters/PhpFunctionVarSetter.php';
$wgAutoloadClasses['PhpIniVarSetter'] = __DIR__ . '/VarSetters/PhpIniVarSetter.php';

$wgExtensionFunctions[] = 'DebugModeUtils::setup';

/* Configuration */

/**
 * Should be set using named constants in the DebugMode class using bitwise operators.
 * Can be set to true to enable all debugging or false to do nothing.
 * Note: Setting to false does not turn debugging off! It just leaves the existing settings alone.
 */
$wgDebugMode = DebugModeUtils::getDefault();

/**
 * An array of variables that should be ignored by the extension. Can be used for more fine-tuning
 * of variables than allowed by $wgDebugMode.
 * These vars can be any named variables known to the extension, including MediaWiki globals and
 * php settings.
 */
$wgDebugModeIgnoreVars = array();

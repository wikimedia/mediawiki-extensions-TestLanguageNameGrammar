<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @version 20141111
 * @author Amir E. Aharoni <amir.aharoni@mail.huji.ac.il>
 * @copyright Copyright © 2014 Amir E. Aharoni
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:TestLanguageNameGrammar Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits for Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'TestLanguageNameGrammar',
	'author' => array(
		'Amir E. Aharoni',
	),
	'version' => '20141111',
	'url' => 'https://www.mediawiki.org/wiki/Extension:TestLanguageNameGrammar',
	'descriptionmsg' => 'testlanguagenamegrammar-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgMessagesDirs['TestLanguageNameGrammar'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['TestLanguageNameGrammarAlias'] = $dir . 'TestLanguageNameGrammar.alias.php';
$wgAutoloadClasses['SpecialTestLanguageNameGrammar'] =
	$dir . 'specials/SpecialTestLanguageNameGrammar.php';
$wgSpecialPages['TestLanguageNameGrammar'] = 'SpecialTestLanguageNameGrammar';

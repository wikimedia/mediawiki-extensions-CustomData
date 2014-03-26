<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

// autoloader
$dir = __DIR__  . '/';
$wgAutoloadClasses['CustomData'] = $dir . 'CustomData.hooks.php';
$wgMessagesDirs['CustomData'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['CustomData'] = $dir . 'CustomData.i18n.php';

// hooks
$wgCustomData = new CustomData;
$wgHooks['ParserClearState'][] = array( &$wgCustomData, 'onParserClearState' );
$wgHooks['OutputPageParserOutput'][] = array( &$wgCustomData, 'onOutputPageParserOutput' );

// credits
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'CustomData',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CustomData',
	'descriptionmsg' => 'customdata-desc',
	'author' => array( 'Hans Musil' ),
	'version' => '1.2'
);

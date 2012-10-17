<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

// autoloader
$wgAutoloadClasses['CustomData'] = __DIR__ . '/CustomData.hooks.php';

// hooks
$wgCustomData = new CustomData;
$wgHooks['ParserClearState'][] = array( &$wgCustomData, 'onParserClearState' );
$wgHooks['OutputPageParserOutput'][] = array( &$wgCustomData, 'onOutputPageParserOutput' );

// credits
$wgExtensionCredits['parserhook']['CustomData'] = array(
	'path' => __FILE__,
	'name' => 'CustomData',
	'url' => '//www.mediawiki.org/wiki/Extension:CustomData',
	'description' => 'Provides an easy to use interface for other extensions that need to transfer data retrieved from the parser to the skin.',
	'author' => array( 'Hans Musil' ),
	'version' => '1.1'
);

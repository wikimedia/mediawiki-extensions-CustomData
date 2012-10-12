<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionFunctions[] = 'wfSetupCustomData';
$wgExtensionCredits['parserhook'][] = array( 'name' => 'CustomData', 'url' =>
'http://wikivoyage.org/tech/CustomData-Extension', 'author' => 'Hans Musil' );


class CustomData
{
  function CustomData(){}

	/*
	 * $value must be an array.
	 */

  function setParserData( &$ParserOutput, $key, $value)
  {
    $ParserOutput->mWVcustom[ $key ] = $value;
  }

  function getParserData( &$ParserOutput, $key)
  {
    return 	array_key_exists( 'mWVcustom', $ParserOutput) &&
						array_key_exists( $key, $ParserOutput->mWVcustom) ? 
										$ParserOutput->mWVcustom[ $key] : array();

    # return $ParserOutput->mWVcustom[ $key];
  }

  function getPageData( &$OutputPage, $key)
  {
		return $this->getParserData( $OutputPage, $key);
  }

  function setSkinData( &$QuickTmpl, $key, $value)
  {
    if( !isset( $QuickTmpl->data['WVcustom']))
    {
      $QuickTmpl->data['WVcustom'] = array();
    };
    $QuickTmpl->data['WVcustom'][$key] = $value;
  }

  function getSkinData( &$QuickTmpl, $key)
  {
    return $QuickTmpl->data['WVcustom'][ $key];
  }

  function onParserClearState( &$Parser)
  {
    $Parser->mOutput->mWVcustom = array();

    return true;
  }

  function onOutputPageParserOutput( &$OutputPage, $parserOutput)
  {
    if( !isset( $OutputPage->mWVcustom))
    {
      $OutputPage->mWVcustom = array();
    };

    foreach( $parserOutput->mWVcustom as $k => $v)
    {
			# error_log( '$k = ' . $k, 0);

      if( !array_key_exists( $k, $OutputPage->mWVcustom))
      {
        $OutputPage->mWVcustom[ $k] = array();
      };
      $OutputPage->mWVcustom[ $k] += $v;
    };

    return true;
  }

};

function wfSetupCustomData() {
        global $wgHooks;

        global $wgCustomData;
        $wgCustomData     = new CustomData;

        $wgHooks['ParserClearState'][] = array( &$wgCustomData, 'onParserClearState' );
        $wgHooks['OutputPageParserOutput'][] = array( &$wgCustomData, 'onOutputPageParserOutput' );
}

?>

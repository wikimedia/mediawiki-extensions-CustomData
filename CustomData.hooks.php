<?php

/**
 * Extension provides easy management of custom data.
 * Custom data is stored in the ParserOutput object cache and
 * can also be used for custom skin extension, e.g. for making new
 * boxes in the sidebar.
 */
class CustomData {
	/**
	 * @param ParserOutput $parserOutput
	 * @param string $key
	 * @param array $value
	 */
	public function setParserData( ParserOutput &$parserOutput, $key, array $value ) {
		$parserOutput->mCustomData[$key] = $value;
	}

	/**
	 * @param ParserOutput|OutputPage $parserOutput
	 * @param string $key
	 * @return array
	 */
	public function getParserData( &$parserOutput, $key ) {
		if ( isset( $parserOutput->mCustomData ) && array_key_exists( $key, $parserOutput->mCustomData ) ) {
			return $parserOutput->mCustomData[$key];
		}

		return array();
	}

	/**
	 * @param ParserOutput|OutputPage $outputPage
	 * @param string $key
	 * @return array
	 */
	public function getPageData( &$outputPage, $key ) {
		return $this->getParserData( $outputPage, $key );
	}

	/**
	 * @param QuickTemplate $quickTpl
	 * @param string $key
	 * @param array $value
	 */
	public function setSkinData( &$quickTpl, $key, array $value ) {
		if( !isset( $quickTpl->data['CustomData'] ) ) {
			$quickTpl->data['CustomData'] = array();
		}

		$quickTpl->data['CustomData'][$key] = $value;
	}

	/**
	 * @param QuickTemplate $quickTpl
	 * @param string $key
	 * @return array
	 */
	public function getSkinData( &$quickTpl, $key ) {
		return $quickTpl->data['CustomData'][$key];
	}

	/**
	 * @param Parser $parser
	 * @return bool
	 */
	public function onParserClearState( Parser &$parser ) {
		$parser->mOutput->mCustomData = array();

		return true;
	}

	/**
	 * @param OutputPage $outputPage
	 * @param ParserOutput $parserOutput
	 * @return bool
	 */
	public function onOutputPageParserOutput( OutputPage &$outputPage, ParserOutput $parserOutput ) {
		if ( !isset( $parserOutput->mCustomData ) ) {
			return true;
		}

		if( !isset( $outputPage->mCustomData ) ) {
			$outputPage->mCustomData = array();
		}

		foreach( (array) $parserOutput->mCustomData as $k => $v ) {
			if( !array_key_exists( $k, $outputPage->mCustomData ) ) {
				$outputPage->mCustomData[$k] = array();
			}

			$outputPage->mCustomData[$k] += $v;
		}

		return true;
	}
}

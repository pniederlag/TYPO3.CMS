<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Thomas Maroschik <tmaroschik@dfau.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Enter descriptions here
 *
 * @package $PACKAGE$
 * @subpackage $SUBPACKAGE$
 * @scope prototype
 * @entity
 * @api
 */
class t3lib_webservice_RequestBuilder {

	/**
	 * The build method for a web request
	 *
	 * @param array $resolvedArguments
	 * @return t3lib_webservice_Request
	 */
	protected function buildRequest(array $resolvedArguments) {
		/** @var t3lib_webservice_Request $request */
		$request = t3lib_div::makeInstance('t3lib_webservice_Request');
		$request->setAcceptHeaders($this->getAcceptHeaders());
		$request->setResolvedArguments($resolvedArguments);
		$request->setMethod((isset($SERVER['REQUEST_METHOD'])) ? $SERVER['REQUEST_METHOD'] : NULL);
		$request->setBaseUri(t3lib_div::getIndpEnv('TYPO3_SITE_URL'));
		$request->setRequestUri(t3lib_div::getIndpEnv('TYPO3_REQUEST_URL'));
		$request->setBody(file_get_contents('php://input'));
		return $request;
	}


	/**
	 * Parses the accept headers and returns an array with resolved priorities
	 *
	 * @param string $header
	 * @return array
	 */
	protected function getAcceptHeaders($header = NULL) {
		$toret = array();
		$header = $header ? $header : (array_key_exists('HTTP_ACCEPT', $_SERVER) ? $_SERVER['HTTP_ACCEPT'] : NULL);
		if ($header) {
			$types = explode(',', $header);
			$types = array_map('trim', $types);
			foreach ($types as $one_type) {
				$one_type = explode(';', $one_type);
				$type = array_shift($one_type);
				if ($type) {
					list($precedence, $tokens) = $this->getAcceptHeaderOptions($one_type);
					list($main_type, $sub_type) = array_map('trim', explode('/', $type));
					$toret[] = array(
						'main_type' => $main_type,
						'sub_type' => $sub_type,
						'precedence' => (float) $precedence,
						'tokens' => $tokens
					);
				}
			}
			usort($toret, array('Parser', 'compare_media_ranges'));
		}
		return $toret;
	}


	protected function getAcceptHeaderOptions($typeOptions) {
		$precedence = 1;
		$tokens = array();
		if (is_string($typeOptions)) {
			$typeOptions = explode(';', $typeOptions);
		}
		$typeOptions = array_map('trim', $typeOptions);
		foreach ($typeOptions as $option) {
			$option = explode('=', $option);
			$option = array_map('trim', $option);
			if ($option[0] == 'q') {
				$precedence = $option[1];
			} else {
				$tokens[$option[0]] = $option[1];
			}
		}
		$tokens = count ($tokens) ? $tokens : false;
		return array($precedence, $tokens);
	}

}

?>
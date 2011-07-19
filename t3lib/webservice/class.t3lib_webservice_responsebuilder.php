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
 */
class t3lib_webservice_ResponseBuilder {

	/**
	 * The build method for a new web repsonse
	 * @return t3lib_webservice_Response
	 */
	protected function buildResponse() {
		/** @var t3lib_webservice_Response $response */
		$response = t3lib_dib::makeInstance('t3lib_webservice_Response');
		$response->setAcceptHeaders($this->getAcceptHeaders());
		return $response;
	}

}
?>
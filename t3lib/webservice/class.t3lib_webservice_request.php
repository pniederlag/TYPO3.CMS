<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2001 Thomas Maroschik <tmaroschik@dfau.de>
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
class t3lib_webservice_Request {

	/**
	 * The HTTP accept headers sent by the client
	 *
	 * @var array
	 */
	protected $acceptHeaders = array();

	/**
	 * @var array
	 */
	protected $resolvedArguments = array();

	/**
	 * @var string
	 */
	protected $body;


	/**
	 * Contains the request method
	 * @var string
	 */
	protected $method = 'GET';

	/**
	 * The request URI
	 * @var string
	 */
	protected $requestUri;

	/**
	 * The base URI for this request - ie. the host and path leading to which all FLOW3 URI paths are relative
	 *
	 * @var string
	 */
	protected $baseUri;

	/**
	 * Sets $acceptHeaders
	 *
	 * @param array $acceptHeaders
	 */
	public function setAcceptHeaders($acceptHeaders) {
		$this->acceptHeaders = $acceptHeaders;
	}

	/**
	 * Returns $acceptHeaders
	 *
	 * @return array
	 */
	public function getAcceptHeaders() {
		return $this->acceptHeaders;
	}

	/**
	 * Sets the Request URI
	 *
	 * @param $string
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setRequestUri($requestUri) {
		$this->requestUri = $requestUri;
	}

	/**
	 * Returns the request URI
	 *
	 * @return string URI of this web request
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function getRequestUri() {
		return $this->requestUri;
	}

	/**
	 * Sets the Base URI
	 *
	 * @param string $baseUri
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function setBaseUri(Uri $baseUri) {
		$this->baseUri = $baseUri;
	}

	/**
	 * Returns the base URI
	 *
	 * @return string URI of this web request
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function getBaseUri() {
		return $this->baseUri;
	}

	/**
	 * Sets the request method
	 *
	 * @param string $method Name of the request method
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @throws \F3\FLOW3\MVC\Exception\InvalidRequestMethodException if the request method is not supported
	 * @api
	 */
	public function setMethod($method) {
		if ($method === '' || (strtoupper($method) !== $method)) {
			throw new t3lib_error_http_invalidrequestmethodexception('The request method "' . $method . '" is not supported.', 1310140095);
		}
		$this->method = $method;
	}

	/**
	 * Returns the name of the request method
	 *
	 * @return string Name of the request method
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * @param string $body
	 * @return void
	 */
	public function setBody($body) {
		$this->body = $body;
	}

	/**
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * @param array $resolvedArguments
	 * @return void
	 */
	public function setResolvedArguments(array $resolvedArguments) {
		$this->resolvedArguments = $resolvedArguments;
	}

	/**
	 * @return array
	 */
	public function getResolvedArguments() {
		return $this->resolvedArguments;
	}

}

?>
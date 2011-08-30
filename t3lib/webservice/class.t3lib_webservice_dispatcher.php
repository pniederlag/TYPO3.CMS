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
 * @api
 */
class t3lib_webservice_Dispatcher {

	/**
	 * @var t3lib_webservice_Router
	 */
	protected $router;

	/**
	 *
	 */
	public function __construct() {
		$this->router = t3lib_div::makeInstance('t3lib_webservice_Router');
	}

	/**
	 * @param string $requestString
	 * @throws In validArgumentException
	 * @return void
	 */
	public function dispatch($requestString) {
		$resolvedRoute = $this->router->resolve($requestString);
		if ($resolvedRoute !== NULL && isset($resolvedRoute['webserviceClassName'])) {
			$request = $this->buildRequest($resolvedRoute['resolvedArguments']);
			$response = $this->buildResponse();
			/** @var t3lib_webservice_WebserviceInterface $webservice */
			$webservice = t3lib_div::makeInstance($resolvedRoute['webserviceClassName']);
			if (!$webservice instanceof t3lib_webservice_WebserviceInterface) {
				throw new InvalidArgumentException('The webservice "' . get_class($webservice) . '" does not implement the t3lib_webservice_WebserviceInterface.', 1310305459);
			}
			$webservice->setRequest($request);
			$webservice->setResponse($response);
			$webservice->run();
			$this->output($response);
		}
	}


	/**
	 * @param array $arguments
	 * @return t3lib_webservices_request
	 */
	protected function buildRequest(array $arguments) {
		/** @var t3lib_webservices_request $request */
		$request = t3lib_div::makeInstance('t3lib_webservices_Request');
		return $request;
	}

	/**
	 * @return t3lib_webservices_response
	 */
	protected function buildResponse() {
		/** @var t3lib_webservices_response $response */
		$response = t3lib_div::makeInstance('t3lib_webservices_Response');
		return $response;
	}

	/**
	 * @param t3lib_webservices_Response $response
	 * @return void
	 */
	protected function output(t3lib_webservices_Response $response) {
		$response->sendHeaders();
		$response->send();
	}

	/**
	 * @api
	 * @static
	 * @param string $uriPattern
	 * @param string $webserviceClassName
	 * @return void
	 */
	static public function addRoute($uriPattern, $webserviceClassName) {
		/** @var t3lib_webservice_Router $router */
		$router = t3lib_div::makeInstance('t3lib_webservice_Router');
		$router->addRoute($uriPattern, $webserviceClassName);
	}

	/**
	 * @api
	 * @static
	 * @param  $uriPattern
	 * @return void
	 */
	static public function removeRoute($uriPattern) {
		/** @var t3lib_webservice_Router $router */
		$router = t3lib_div::makeInstance('t3lib_webservice_Router');
		$router->removeRoute($uriPattern);
	}
}
?>
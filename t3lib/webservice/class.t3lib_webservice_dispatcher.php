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

	public function __construct() {
		$this->router = t3lib_div::makeInstance('t3lib_webservice_Router');
	}

	protected function resolveRoute() {
		global $TYPO3_CONF;
		$routes = $TYPO3_CONF['SVCONF']['webservicesDispatcher']['routes'];
		if (isset($routes) && !empty($routes)) {
			return $this->router->resolve($routes);
		}
	}

	public function dispatch() {
		$resolvedRoute = $this->resolveRoute();
		if ($resolvedRoute !== null && isset($resolvedRoute['webserviceClass'])) {
			$request = $this->buildRequest($resolvedRoute['resolvedArguments']);
			$response = $this->buildResponse();
			/** @var t3lib_webservice_WebserviceInterface $webservice */
			$webservice = t3lib_div::makeInstance($resolvedRoute['webserviceClass']);
			if (!$webservice instanceof t3lib_webservice_WebserviceInterface) {
				throw new InvalidArgumentException('The webservice "' . get_class($webservice) . '" does not implement the t3lib_webservice_WebserviceInterface.', 1310305459);
			}
			$webservice->setRequest($request);
			$webservice->setResponse($response);
			$webservice->run();
			$response->send();
		}
	}

	protected function output() {

	}
}
?>
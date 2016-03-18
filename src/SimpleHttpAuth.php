<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\SimpleHttpAuth;

use Nette;

class SimpleHttpAuth extends Nette\DI\CompilerExtension
{

	/**
	 * @var Nette\Http\Request
	 */
	protected $httpRequest;

	/**
	 * @var Nette\Http\Response
	 */
	protected $httpResponse;

	/**
	 * @var bool
	 */
	protected $exit_on_bad_credentials;


	/**
	 * @param string                    $username
	 * @param string                    $password
	 * @param array                     $presenters   If array of presenters is empty, accept all
	 * @param Nette\Application\IRouter $router
	 * @param Nette\Http\IRequest       $httpRequest
	 * @param Nette\Http\IResponse      $httpResponse
	 */
	public function __construct(
		$username,
		$password,
		$presenters,
		Nette\Application\IRouter $router,
		Nette\Http\IRequest $httpRequest,
		Nette\Http\IResponse $httpResponse,
		$exit_on_bad_credentials = TRUE
	) {
		$this->httpRequest  = $httpRequest;
		$this->httpResponse = $httpResponse;
		$this->exit_on_bad_credentials = $exit_on_bad_credentials;

		$request = $router->match($httpRequest);

		if (!$request) {
			return;
		}

		/**
		 * Eccapt either all presenter or just the specified ones
		 */
		if (empty($presenters) || in_array($request->getPresenterName(), $presenters)) {
			$this->authenticate($username, $password);
		}
	}


	/**
	 * Authenticate user
	 * @param  string $username
	 * @param  string $password
	 * @return void
	 */
	public function authenticate($username, $password)
	{
		$url = $this->httpRequest->url;

		if ($url->user !== $username || $url->password !== $password) {
			$this->httpResponse->setHeader('WWW-Authenticate', 'Basic realm="HTTP Authentication"');
			$this->httpResponse->setCode(Nette\Http\IResponse::S401_UNAUTHORIZED);

			echo '<h1>Authentication failed.</h1>';

			if ($this->exit_on_bad_credentials) {
				die;
			}
		}
	}

}

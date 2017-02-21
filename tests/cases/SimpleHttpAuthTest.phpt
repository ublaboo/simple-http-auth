<?php

namespace Ublaboo\SimpleHttpAuth\Tests;

use Tester,
	Tester\Assert,
	Mockery,
	Nette,
	Ublaboo;

require __DIR__ . '/../bootstrap.php';

final class SimpleHttpAuthTest extends Tester\TestCase
{

	/**
	 * @var Nette\Application\IRouter
	 */
	private $router;

	/**
	 * @var Nette\Http\IRequest
	 */
	private $request;

	/**
	 * @var Nette\Http\IResponse
	 */
	private $response;

	/**
	 * @var Nette\Application\Request
	 */
	private $appRequest;


	public function setUp()
	{
		$this->router   = Mockery::mock('Nette\Application\IRouter');
		$this->request  = Mockery::mock('Nette\Http\IRequest');
	}


	private function setupRequest($return_presenter, $user, $password)
	{
		unset($this->appRequest);

		$this->appRequest = Mockery::mock('Nette\Application\Request');

		$this->appRequest->shouldReceive('getPresenterName')
			->andReturn($return_presenter);

		$this->request->url = (object) [
			'user' => $user,
			'password' => $password
		];

		$this->router->shouldReceive('match')
			->withArgs([$this->request])
			->andReturn($this->appRequest);
	}


	public function setupResponse()
	{
		unset($this->response);

		$this->response = Mockery::mock('Nette\Http\IResponse');

		$this->response->header = NULL;
		$this->response->code = NULL;

		$this->response->shouldReceive('setHeader')->set('header', 'www-auth');
		$this->response->shouldReceive('setCode')->set('code', 401);
	}


	public function testSecuredAndCredentials()
	{
		$this->setupResponse();
		$this->setupRequest('Front:Secured', 'admin', '1234567890');

		ob_start();

		$auth = new Ublaboo\SimpleHttpAuth\SimpleHttpAuth(
			'admin',
			'1234567890',
			['Front:Secured', 'Front:AnotherSecured'],
			FALSE,
			$this->router,
			$this->request,
			$this->response,
			FALSE
		);

		$response_content = ob_get_clean();

		Assert::null($this->response->header);
		Assert::null($this->response->code);
		Assert::same('', $response_content);
	}


	public function testSecuredBadCredentials()
	{
		$this->setupResponse();
		$this->setupRequest('Front:AnotherSecured', NULL, NULL);

		ob_start();

		$auth = new Ublaboo\SimpleHttpAuth\SimpleHttpAuth(
			'admin',
			'1234567890',
			['Front:Secured', 'Front:AnotherSecured'],
			FALSE,
			$this->router,
			$this->request,
			$this->response,
			FALSE
		);

		$response_content = ob_get_clean();

		Assert::same('www-auth', $this->response->header);
		Assert::same(401, $this->response->code);
		Assert::same('<h1>Authentication failed.</h1>', $response_content);
	}


	public function testUnSecured()
	{
		$this->setupResponse();
		$this->setupRequest('Front:Unsecured', NULL, NULL);

		ob_start();

		$auth = new Ublaboo\SimpleHttpAuth\SimpleHttpAuth(
			'admin',
			'1234567890',
			['Front:Secured', 'Front:AnotherSecured'],
			FALSE,
			$this->router,
			$this->request,
			$this->response,
			FALSE
		);

		$response_content = ob_get_clean();

		Assert::null($this->response->header);
		Assert::null($this->response->code);
		Assert::same('', $response_content);
	}


	public function testEmptyCredentials()
	{
		$this->setupResponse();
		$this->setupRequest('Front:Homepage', NULL, NULL);

		ob_start();

		$auth = new Ublaboo\SimpleHttpAuth\SimpleHttpAuth(
			'',
			'',
			[],
			FALSE,
			$this->router,
			$this->request,
			$this->response,
			FALSE
		);

		$response_content = ob_get_clean();

		Assert::null($this->response->header);
		Assert::null($this->response->code);
		Assert::same('', $response_content);
	}

}

$test_case = new SimpleHttpAuthTest;
$test_case->run();

<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\SimpleHttpAuth\DI;

use Nette;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class SimpleHttpAuthExtension extends Nette\DI\CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'username' => Expect::string(NULL),
			'password' => Expect::string(NULL),
			'consoleAuth' => Expect::bool(true),
			'presenters' => Expect::array(),
		]);
	}


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		$builder->addDefinition($this->prefix('simpleHttpAuth'))
			->setClass(\Ublaboo\SimpleHttpAuth\SimpleHttpAuth::class)
			->setArguments([
				$config->username,
				$config->password,
				$config->presenters,
				$config->consoleAuth,
				$builder->parameters['consoleMode'],
			]);
	}


	public function afterCompile(Nette\PhpGenerator\ClassType $class)
	{
		$class->getMethod('initialize')->addBody('$this->getService(?);', [$this->prefix('simpleHttpAuth')]);
	}

}

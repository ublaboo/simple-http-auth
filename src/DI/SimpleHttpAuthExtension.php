<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\SimpleHttpAuth\DI;

use Nette;

class SimpleHttpAuthExtension extends Nette\DI\CompilerExtension
{

	private $defaults = [
		'username' => '',
		'password' => '',
		'presenters' => []
	];


	public function loadConfiguration()
	{
		$config = $this->_getConfig();

		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('simpleHttpAuth'))
			->setClass('Ublaboo\SimpleHttpAuth\SimpleHttpAuth')
			->addTag('run')
			->setArguments([
				$config['username'],
				$config['password'],
				$config['presenters'],
				$builder->parameters['consoleMode'],
			]);
	}


	private function _getConfig()
	{
		return $this->validateConfig($this->defaults, $this->config);
	}

}

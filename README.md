[![Build Status](https://travis-ci.org/ublaboo/simple-http-auth.svg?branch=master)](https://travis-ci.org/ublaboo/simple-http-auth)
[![Latest Stable Version](https://poser.pugx.org/ublaboo/simple-http-auth/v/stable)](https://packagist.org/packages/ublaboo/simple-http-auth)
[![License](https://poser.pugx.org/ublaboo/simple-http-auth/license)](https://packagist.org/packages/ublaboo/simple-http-auth)
[![Total Downloads](https://poser.pugx.org/ublaboo/simple-http-auth/downloads)](https://packagist.org/packages/ublaboo/simple-http-auth)
[![Gitter](https://img.shields.io/gitter/room/nwjs/nw.js.svg)](https://gitter.im/ublaboo/help)

SimpleHttpAuth
==============




1, Install via composer
```yaml
composer require ublaboo/simple-http-auth
```


2, Register extension in `config.neon`:

```php
extensions:
	simpleHttpAuth: Ublaboo\SimpleHttpAuth\DI\SimpleHttpAuthExtension
```

3, Tell which presenters shoul be secured (in case no presenter name given, all presenters are secured). Format - `Module:Module:Presenter`:

```php
simpleHttpAuth:
	username: admin
	password: rbxpmYsPB6RSlqMIUV8i
	presenters: [Front:Admin] # Secure presenter class App\FrontModule\Presenters\AdminPresenter
```

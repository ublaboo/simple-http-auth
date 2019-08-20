<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();
Tester\Environment::bypassFinals();

date_default_timezone_set('Europe/Prague');

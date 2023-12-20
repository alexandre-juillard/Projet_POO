<?php

define('ROOT', \dirname(__DIR__));

require_once ROOT . '/Autoloader.php';

use App\Core\Main;
use App\Autoloader;

Autoloader::register();

$app = (new Main())->start();

<?php

require_once 'Autoloader.php';

use App\Db\Db;
use App\Autoloader;

Autoloader::register();

Db::getInstance();

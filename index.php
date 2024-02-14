<?php 

use App\Autoloader;
use App\Models\User;
use App\Models\Article;

require_once '/app/Autoloader.php';

Autoloader::register();

$article = (new Article())
    ->setTitre('Mon super article')
    ->setDescription('Ma super description')
    ->setActif(true)
    ->create();



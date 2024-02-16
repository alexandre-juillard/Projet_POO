<?php

namespace App\Controllers\Frontend;

//ce use importe la classe Route créer dans dossier Core

use App\Core\Route;
use App\Core\Controller;

class HomeController extends Controller
{
    //3parametres : nom de route, url qui renvoie, methode a utiliser
    //ceci est un attribut php 8 qui instancie une classe Route
    #[Route('homepage', '/', ['GET'])]
    public function homepage(): void
    {
        $this->render('Frontend/home.php', [
            'meta' => [
                'title' => 'Homepage',
            ]
        ]);
    }
}
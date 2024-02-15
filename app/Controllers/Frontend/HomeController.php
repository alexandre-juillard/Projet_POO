<?php

namespace App\Controllers\Frontend;

//ce use importe la classe Route créer dans dossier Core

use App\Core\Controller;
use App\Core\Route;

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

    #[Route('test', '/test', ['GET'])]
    public function test(): void
    {
        echo 'Coucou cette page est un test!';
    }

    #[Route('debut', '/debut', ['GET'])]
    public function debut(): void
    {
        echo 'Debut de page pour une nouvelle application web';
    }
}
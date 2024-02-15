<?php

namespace App\Controller;

//ce use importe la classe Route créer dans dossier Core
use App\Core\Route;

class HomeController
{
    //3parametres : nom de route, url qui renvoie, methode a utiliser
    //ceci est un attribut php 8 qui instancie une classe Route
    #[Route('homepage', '', ['GET'])]
    public function homepage(): void
    {
        echo 'Page d\'accueil';
    }
}
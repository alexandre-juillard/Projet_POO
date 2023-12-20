<?php

namespace App\Controllers\Frontend;

use App\Core\Route;

class HomeController
{
    #[Route('/', 'homepage', ['GET'])]
    public function home(): void
    {
        echo "Page d'accueil";
    }
}

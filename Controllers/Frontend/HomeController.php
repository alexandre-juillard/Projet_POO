<?php

namespace App\Controllers\Frontend;

use App\Core\Route;
use App\Models\Postes;
use App\Core\Controller;

class HomeController extends Controller
{
    #[Route('/', 'homepage', ['GET'])]
    public function home(): void
    {
        $postes = (new Postes())->findAll();

        $this->render('Frontend/Home/index.php', [
            'postes' => $postes
        ]);
    }
}

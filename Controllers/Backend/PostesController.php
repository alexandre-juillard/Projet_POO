<?php

namespace App\Controllers\Backend;

use App\Core\Route;
use App\Core\Controller;

class PostesController extends Controller
{
    #[Route('/admin/postes', 'admin.postes.index', ['GET'])]
    public function index(): void
    {
        echo "Page de postes";
    }
}

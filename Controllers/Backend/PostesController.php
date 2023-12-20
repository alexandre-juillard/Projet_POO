<?php

namespace App\Controllers\Backend;

use App\Core\Route;

class PostesController
{
    #[Route('/admin/postes', 'admin.postes.index', ['GET'])]
    public function index(): void
    {
        echo "Page de postes";
    }
}

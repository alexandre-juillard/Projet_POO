<?php

namespace App\Controllers\Backend;

use App\Core\Route;
use App\Models\User;
use App\Core\Controller;

class UserController extends Controller
{
    #[Route('admin.users.index', '/admin/users', ['GET'])]
    public function index(): void
    {
        $this->isAdmin();

        $users = (new User)->findAll();

        $this->render('Backend/Users/index.php', [
            'meta' => [
                'title' => 'Administration des users',
            ],
            'users' => $users,
        ]);
    }
}
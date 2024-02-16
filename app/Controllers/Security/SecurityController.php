<?php

namespace App\Controllers\Security;

use App\Core\Route;
use App\Models\User;
use App\Form\LoginForm;
use App\Core\Controller;

class SecurityController extends Controller
{
    #[Route('app.login', '/login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new LoginForm();

        if ($form->validate(['email', 'password'], $_POST)) {
            $user = (new User())->findOneByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {

                $user = (new User)->hydrate($user);

                $user->connect();

                http_response_code(302);
                header("Location: /");
                exit();
            } else {
                $_SESSION['messages']['danger'] = 'Identifiants invalides';
            }
        }

        $this->render('Security/login.php', [
            'form' => $form->createForm(),
        ]);
    }

    #[Route('app.logout', '/logout', ['GET'])]
    public function logout(): void
    {
        unset($_SESSION['LOGGED_USER']);

        http_response_code(302);
        header("Location: /");
        exit();
    }
}

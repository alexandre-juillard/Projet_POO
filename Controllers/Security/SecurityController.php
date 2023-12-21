<?php

namespace App\Controllers\Security;

use App\Core\Route;
use App\Models\Users;
use App\Form\LoginForm;
use App\Core\Controller;
use App\Form\RegisterForm;

class SecurityController extends Controller
{
    #[Route('/login', 'app.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new LoginForm();

        if ($form::validate($_POST, ['email', 'password'])) {
            $user = (new Users)->findOneByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user->getPassword())) {
                // On peut connecté le user
                $user->loggedUser();

                header("Location: /");
                exit();
            } else {
                $this->addFlash('danger', 'Identifiants invalides');
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addFlash('danger', 'formulaire incomplet');
        }

        $this->render('Security/login.php', [
            'form' => $form->createForm()
        ]);
    }

    #[Route('/logout', 'app.logout', ['GET'])]
    public function logout(): void
    {
        unset($_SESSION['LOGGED_USER']);

        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

        header('Location: ' . $url);
        exit();
    }

    #[Route('/register', 'app.register', ['GET', 'POST'])]
    public function register(): void
    {
        $form = new RegisterForm();

        if ($form::validate($_POST, ['nom', 'prenom', 'email', 'password'])) {
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

            if ($email) {
                $user = new Users();

                if (!$user->findOneByEmail($email)) {
                    $user->setPrenom($prenom)
                        ->setNom($nom)
                        ->setEmail($email)
                        ->setPassword($password)
                        ->create();

                    $this->addFlash('success', 'Vous êtes bien inscrit à l\'application');
                    header("Location: /login");
                    exit();
                } else {
                    $this->addFlash('danger', 'Email déjà utilisé');
                }
            } else {
                $this->addFlash('danger', 'Email invalide');
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addFlash('danger', 'Formulaire incomplet');
        }

        $this->render('Security/register.php', [
            'form' => $form->createForm()
        ]);
    }
}

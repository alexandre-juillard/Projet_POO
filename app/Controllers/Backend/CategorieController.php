<?php

namespace App\Controllers\Backend;

use DateTime;
use App\Core\Route;
use App\Core\Controller;
use App\Models\Categorie;
use App\Form\CategorieForm;

class CategorieController extends Controller
{
    #[Route('app.categories.create', '/admin/categories/create', ['GET', 'POST'])]
    public function create(): void
    {
        $this->isAdmin();

        $form = new CategorieForm($_SERVER['REQUEST_URI']);

        if ($form->validate(['nom'], $_POST)) {
            $nom = strip_tags($_POST['nom']);
            $actif = isset($_POST['actif']) ? true : false;
            $imageName = !empty($_FILES['image']) ? (new Categorie)->uploadImage($_FILES['image']) : null;

            if (!(new Categorie)->findOnebyNom($nom)) {
                (new Categorie)
                    ->setNom($nom)
                    ->setActif($actif)
                    ->setImageName($imageName)
                    ->create();

                $_SESSION['messages']['success'] = "Catégorie créée avec succès";
                http_response_code(302);
                header('Location: /admin/categories');
                exit();
            } else {
                $_SESSION['messages']['danger'] = "Le nom est déjà utilisé";
            }
        }

        $this->render('Backend/Categories/create.php', [
            'meta' => [
                'title' => 'Création d\'une catégorie',
            ],
            'form' => $form->createForm()
        ]);
    }

    #[Route('app.categories.index', '/admin/categories', ['GET'])]
    public function index(): void
    {
        $this->isAdmin();

        $_SESSION['token'] = bin2hex(random_bytes(50));

        $this->render('Backend/Categories/index.php', [
            'categories' => (new Categorie)->findAll(),
            'meta' => [
                'title' => 'Administration des catégories',
                'scripts' => [
                    '/js/switchVisibilityCategorie.js'
                ]
            ]
        ]);
    }

    #[Route('app.categorie.edit', '/admin/categories/([0-9]+)/edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $this->isAdmin();

        $categorie = (new Categorie)->find($id);

        if (!$categorie) {
            $_SESSION['messages']['danger'] = "Catégorie non trouvé";

            http_response_code(302);
            header('Location: /admin/categories');
            exit();
        }

        $form = new CategorieForm($_SERVER['REQUEST_URI'], $categorie);

        if ($form->validate(['nom'], $_POST)) {
            $nom = strip_tags($_POST['nom']);
            $actif = isset($_POST['actif']) ? true : false;
            $imageName = !empty($_FILES['image']) ? (new Categorie)->uploadImage($_FILES['image']) : null;

            $oldNom = $categorie->getNom();

            if ($oldNom !== $nom && (new Categorie)->findOneByNom($nom)) {
                $_SESSION['messages']['danger'] = "Nom déjà utilisé";
            } else {
                $categorie
                    ->setNom($nom)
                    ->setActif($actif)
                    ->setUpdatedAt(new DateTime)
                    ->setImageName($imageName)
                    ->update();

                $_SESSION['messages']['success'] = "Catégorie créée avec succès";
                http_response_code(302);
                header('Location: /admin/categories');
                exit();
            }
        }

        $this->render('Backend/Categories/edit.php', [
            'meta' => [
                'title' => 'Modification d\'une catégorie'
            ],
            'form' => $form->createForm(),
        ]);
    }

    #[Route('app.categories.delete', '/admin/categories/([0-9]+)/delete', ['POST'])]
    public function delete(int $id): void
    {
        $this->isAdmin();

        $categorie = (new Categorie)->find($id);

        if ($categorie) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                $categorie->delete();

                $_SESSION['messages']['success'] = "Catégorie supprimée";
            } else {
                $_SESSION['messages']['danger'] = "Token CSRF invalide";
            }
        } else {
            $_SESSION['messages']['danger'] = "Catégorie introuvable";
        }

        http_response_code(302);
        header('Location: /admin/categories');
        exit();
    }

    #[Route('admin.categories.switch', '/admin/categories/([0-9]+)/switch', ['GET'])]
    public function switch(int $id): void
    {
        $categorie = (new Categorie())->find($id);
        header('Content-type: application/json');

        if ($categorie) {
            $categorie
                ->setActif(!$categorie->getActif())
                ->update();

            http_response_code(201);

            echo json_encode([
                'status' => 'success',
                'visibility' => $categorie->getActif(),
            ]);
            exit();
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Catégorie non trouvé',
            ]);
        }
    }
}

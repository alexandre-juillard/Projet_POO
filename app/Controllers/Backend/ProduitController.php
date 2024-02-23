<?php

namespace App\Controllers\Backend;

use App\Core\Route;
use App\Models\Produit;
use App\Core\Controller;
use App\Form\ProduitForm;
use DateTime;

class ProduitController extends Controller
{
    public function __construct(
        private Produit $produit = new Produit()
    ) {
    }

    #[Route('admin.produits.create', '/admin/produits/create', ['GET', 'POST'])]
    public function create(): void
    {
        $this->isAdmin();

        $form = new ProduitForm($_SERVER['REQUEST_URI']);

        if ($form->validate(['titre', 'tva', 'prixHT'], $_POST)) {
            $titre = strip_tags($_POST['titre']);
            $description = strip_tags($_POST['description']);
            $actif = isset($_POST['actif']) ? true : false;
            $categorieId = (int) $_POST['categorie'] > 0 ? (int) $_POST['categorie'] : null;
            $imageName = !empty($_FILES['image']) ? $this->produit->uploadImage($_FILES['image']) : null;
            $tva = filter_input(INPUT_POST, 'tva', FILTER_VALIDATE_FLOAT);
            $prixHT = filter_input(INPUT_POST, 'prixHT', FILTER_VALIDATE_FLOAT);

            if ($prixHT || $tva) {
                if (!($this->produit)->findOneByTitle($titre)) {
                    $this->produit
                        ->setTitre($titre)
                        ->setDescription($description)
                        ->setActif($actif)
                        ->setCategorieId($categorieId)
                        ->setImageName($imageName)
                        ->setTva($tva)
                        ->setPrixHT($prixHT)
                        ->create();

                    $_SESSION['messages']['success'] = "Le produit a été créé";
                    http_response_code(302);
                    header('Location: /admin/produits');
                    exit();
                } else {
                    $_SESSION['messages']['danger'] = "Le titre du produit est déjà utilisé";
                }
            } else {
                $_SESSION['messages']['danger'] = "Remplir les champs prix et tva";
            }
        }

        $this->render('Backend/Produits/create.php', [
            'meta' => [
                'title' => 'Création d\'un produit',
            ],
            'form' => $form->createForm()
        ]);
    }

    #[Route('admin.produits.index', '/admin/produits', ['GET'])]
    public function index(): void
    {
        $this->isAdmin();

        $_SESSION['token'] = bin2hex(random_bytes(50));

        $this->render('Backend/Produits/index.php', [
            'meta' => [
                'title' => 'Administration des Produits',
                'scripts' => [
                    '/js/switchVisibilityProduit.js'
                ]
            ],
            'produits' => $this->produit->findAll(),
        ]);
    }

    #[Route('admin.produits.switch', '/admin/produits/([0-9]+)/switch', ['GET'])]
    public function switch(int $id): void
    {
        $produit = $this->produit->find($id);
        header('Content-type: application/json');

        if ($produit) {
            $produit
                ->setActif(!$produit->getActif())
                ->update();

            http_response_code(201);
            echo json_encode([
                'status' => 'success',
                'visibility' => $produit->getActif(),
            ]);
            exit();
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Produit non trouvé'
            ]);
        }
    }

    #[Route('admin.produits.edit', '/admin/produits/([0-9]+)/edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $this->isAdmin();

        $produit = $this->produit->find($id);

        if (!$produit) {
            $_SESSION['messages']['danger'] = "Produit non trouvé";

            http_response_code(302);
            header('Location: /admin/produits');
            exit();
        }

        $form = new ProduitForm($_SERVER['REQUEST_URI'], $produit);

        if ($form->validate(['titre', 'tva', 'prixHT'], $_POST)) {
            $titre = strip_tags($_POST['titre']);
            $description = strip_tags($_POST['description']);
            $actif = isset($_POST['actif']) ? true : false;
            $categorieId = (int) $_POST['categorie'] > 0 ? (int) $_POST['categorie'] : null;
            $imageName = !empty($_FILES['image']) ? $this->produit->uploadImage($_FILES['image']) : null;
            $tva = filter_input(INPUT_POST, 'tva', FILTER_VALIDATE_FLOAT);
            $prixHT = filter_input(INPUT_POST, 'prixHT', FILTER_VALIDATE_FLOAT);

            $oldTitre = $produit->getTitre();

            if ($oldTitre !== $titre && $this->produit->findOneByTitle($titre)) {
                $_SESSION['messages']['danger'] = "Le titre du produit existe déjà";
            } else {
                $produit
                    ->setTitre($titre)
                    ->setDescription($description)
                    ->setActif($actif)
                    ->setUpdatedAt(new DateTime)
                    ->setCategorieId($categorieId)
                    ->setImageName($imageName)
                    ->setTva($tva)
                    ->setPrixHT($prixHT)
                    ->update();

                $_SESSION['messages']['success'] = "Produit modifié avec succès";

                http_response_code(302);
                header('Location: /admin/produits');
                exit();
            }
        }

        $this->render('Backend/Produits/edit.php', [
            'meta' => [
                'title' => 'Modification d\'un produit',
            ],
            'form' => $form->createForm(),
        ]);
    }

    #[Route('admin.produits.delete', '/admin/produits/([0-9]+)/delete', ['POST'])]
    public function delete(int $id): void
    {
        $this->isAdmin();

        $produit = $this->produit->find($id);

        if ($produit) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                $produit->delete();

                $_SESSION['messages']['success'] = "Article supprimé avec succès";
            } else {
                $_SESSION['messages']['danger'] = "Token CSRF introuvable";
            }
        } else {
            $_SESSION['messages']['danger'] = "Article introuvable";
        }

        http_response_code(302);
        header('Location: /admin/produits');
        exit();
    }
}

<?php 

namespace App\Form;

use App\Core\Form;
use App\Models\Categorie;

class CategorieForm extends Form
{
    public function __construct(string $action, ?Categorie $categorie = null)
    {
        $this
        ->startForm($action, 'POST', [
            'class' => 'form card p-3 w-75 mx-auto bg-light',
            'enctype' => 'multipart/form-data',
        ])
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('nom', 'Nom :', ['class' => 'form-label'])
        ->addInput('text', 'nom', [
            'class' => 'form-control',
            'id' => 'nom',
            'required' => true,
            'placeholder' => 'Titre de catégorie',
            'value' => $categorie ? $categorie->getNom() : null, 
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('image', 'Image :', ['class' => 'form-label'])
        ->addInput('file', 'image', [
            'id' =>'image',
            'class' => 'form-control'
        ])
        ->addImage($categorie && $categorie->getImageName() ? "/images/categories/{$categorie->getImageName()}" : " ", [
            'class' => "img-fluid rounded mt-2",
            'loading' => "lazy",
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3 form-check'])
        ->addInput('checkbox', 'actif', [
            'id' => 'actif',
            'class' => 'form-check-input',
            'checked' => $categorie ? $categorie->getActif() : false,
        ])
        ->addLabel('actif', ' : Actif', ['class' => 'form-check-label'])
        ->endDiv()
        ->startDiv(['class' => 'text-center'])
        ->addButton($categorie ? 'Modifier' : 'Créer', [
            'type' => 'submit',
            'class' => 'btn btn-primary',
        ])
        ->endDiv()
        ->endForm();
    }
}
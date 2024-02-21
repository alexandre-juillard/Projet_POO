<?php 

namespace App\Form;

use App\Core\Form;
use App\Models\Article;

class ArticleForm extends Form 
{
    public function __construct(string $action, ?Article $article = null)
    {
        $this
        ->startForm($action, 'POST', [
            'class' => 'form card p-3 w-75 mx-auto bg-light',
            'enctype' => 'multipart/form-data',
        ])
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('titre', 'Titre :', ['class' => 'form-label'])
        ->addInput('text', 'titre', [
            'class' => 'form-control',
            'required' => true,
            'id' => 'title',
            'placeholder' => 'Mon titre ici',
            'value' => $article ? $article->getTitre() : null,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('description', 'Description :', ['class' => 'form-label'])
        ->addTextArea('description', $article ? $article->getDescription() : null, [
            'id' => 'description',
            'class' => 'form-control',
            'placeholder' => 'Ma description ici...',
            'wrap' => true,
            'value' => $article ? $article->getDescription() : null,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('image', 'Image :', ['class' => 'form-label'])
        ->addInput('file', 'image', [
            'id' =>'image',
            'class' => 'form-control'
        ])
        ->addImage($article && $article->getImageName() ? "/images/articles/{$article->getImageName()}" : " ", [
            'class' => "img-fluid rounded mt-2",
            'loading' => "lazy",
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3 form-check'])
        ->addInput('checkbox', 'actif', [
            'id' => 'actif',
            'class' => 'form-check-input',
            'checked' => $article ? $article->getActif() : false,
        ])
        ->addLabel('actif', ' : Actif', ['class' => 'form-check-label'])
        ->endDiv()
        ->startDiv(['class' => 'text-center'])
        ->addButton($article ? 'Modifier' : 'Créer', [
            'type' => 'submit',
            'class' => 'btn btn-primary',
        ])
        ->endDiv()
        ->endForm();
    }
}
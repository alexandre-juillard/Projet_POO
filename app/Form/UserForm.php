<?php

namespace App\Form;

use App\Core\Form;

class UserForm extends Form
{
    public function __construct(string $action)
        
    {
        $this
            ->startForm($action, 'POST', [
                'class' => 'form card p-3 w-75 mx-auto'
            ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('nom', 'Nom :', ['class' => 'form-label'])
            ->addInput('text', 'nom', [
                'class' => 'form-control',
                'id' => 'nom',
                'required' => true,
                'placeholder' => 'Wayne'
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('prenom', 'Prénom :', ['class' => 'form-label'])
            ->addInput('text', 'prenom', [
                'class' => 'form-control',
                'id' => 'prenom',
                'required' => true,
                'placeholder' => 'Bruce'
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email :', ['class' => 'form-label'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'required' => true,
                'placeholder' => 'batman@justiceleague.com'
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de Passe :', ['class' => 'form-label'])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'required' => true,
                'placeholder' => 'S3CR3T'
            ])
            ->endDiv()
            ->startDiv(['class' => 'text-center'])
            ->addButton('S\'inscrire', [
                'class' => 'btn btn-primary mt-3',
                'type' => 'submit',
            ])
            ->endDiv()
            ->endForm();
    }
}
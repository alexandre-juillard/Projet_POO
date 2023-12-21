<?php

namespace  App\Form;

use App\Core\Form;

class RegisterForm extends Form
{
    public function __construct()
    {
        $this
            ->startForm('POST', '#', [
                'class' => 'form card w-75 mx-auto p-3 mt-4'
            ])
            ->startDiv(['class' => 'row mb-3'])
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('nom', 'Nom:', ['class' => 'form-label'])
            ->addInput('nom', 'text', [
                'class' => 'form-control',
                'id' => 'nom',
                'required' => true,
                'placeholder' => 'John',
            ])
            ->endDiv()
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('prenom', 'Prenom:', ['class' => 'form-label'])
            ->addInput('prenom', 'text', [
                'class' => 'form-control',
                'id' => 'prenom',
                'required' => true,
                'placeholder' => 'Doe',
            ])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email:', ['class' => 'form-label'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'required' => true,
                'placeholder' => 'johnDoe@test.com',
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe:', ['class' => 'form-label'])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'required' => true,
                'placeholder' => 'S3CR3T',
            ])
            ->endDiv()
            ->addButton('S\'inscrire', [
                'class' => 'btn btn-primary',
                'type' => 'submit'
            ])
            ->endForm();
    }
}

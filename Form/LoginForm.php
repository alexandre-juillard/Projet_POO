<?php

namespace App\Form;

use App\Core\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        $this
            ->startForm('POST', '#', [
                'class' => 'form card p-3 w-50 mx-auto mt-4',
                'id' => 'form-login',
            ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email',  'Votre Email:', [
                'class' => 'form-label'
            ])
            ->addInput('email', 'email', [
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'johnDoe@gmail.com',
                'required' => true,
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe:', [
                'class' => 'form-label'
            ])
            ->addInput('password', 'password', [
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => "S3CR3T",
                'required' => true,
            ])
            ->endDiv()
            ->addButton('Se connecter', [
                'class' => 'btn btn-primary',
                'type' => 'submit',
            ])
            ->endForm();
    }
}

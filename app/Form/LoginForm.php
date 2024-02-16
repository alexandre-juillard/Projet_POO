<?php

namespace App\Form;

use App\Core\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        $this
            ->startForm('/login', 'POST', [
            'class' => 'form card w-50 mx-auto p-3',
            'id' => 'form-test',
            ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email :', ['class' => 'form-label'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'batman@justiceleague.com',
                'required' => true
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe :', ['class' => 'form-label'])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'S3cr3T',
                'required' => true
            ])
            ->startDiv(['class' => 'text-center'])
            ->addButton('Se connecter', [
                'class' => 'btn btn-primary mt-3',
                'type' => 'submit',
            ])
            ->endDiv()
            ->endDiv()
            ->endForm();
    }
}
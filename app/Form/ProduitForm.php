<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Produit;
use App\Models\Categorie;

class ProduitForm extends Form
{
    public function __construct(string $action, ?Produit $produit = null)
    {
        $this
        ->startForm($action, 'POST', [
            'class' => 'form card p-3 w-75 mx-auto bg-light',
            'enctype' => 'multipart/form-data',
        ])

        ->startDiv(['class' => 'mb-3'])
        ->addLabel('titre', 'Titre* :', ['class' => 'form-label'])
        ->addInput('text', 'titre', [
            'class' => 'form-control',
            'required' => true,
            'id' => 'title',
            'placeholder' => 'Intitulé produit',
            'value' => $produit ? $produit->getTitre() : null,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('description', 'Description :', ['class' => 'form-label'])
        ->addTextArea('description', $produit ? $produit->getDescription() : null, [
            'id' => 'description',
            'class' => 'form-control',
            'placeholder' => 'Description produit...(optionnel)',
            'wrap' => true,
            'value' => $produit ? $produit->getDescription() : null,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3 form-check'])
        ->addInput('checkbox', 'actif', [
            'id' => 'actif',
            'class' => 'form-check-input',
            'checked' => $produit ? $produit->getActif() : false,
            'required' => true,
        ])
        ->addLabel('actif', ' : Actif*', ['class' => 'form-check-label'])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        
        ->addLabel('categorie', 'Catégorie :', ['class' => 'form-label'])
        ->addSelect('categorie', (new Categorie)->findAllForSelect($produit), [
                    'class' => 'form-control',
                    'id' => 'categorie',        
                ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('image', 'Image* :', ['class' => 'form-label'])
        ->addInput('file', 'image', [
            'id' =>'image',
            'class' => 'form-control',
        ])
        ->addImage(($produit && $produit->getImageName()) ? "/images/produits/{$produit->getImageName()}" : " ", [
            'class' => "img-fluid rounded mt-2",
            'loading' => "lazy",
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('tva', 'TVA* : ', ['class' => 'form-label'])
        ->addSelect('tva', [
            '0.055' => [
                'label' => '5,5%',
                'attributs' => [
                    'selected' => ($produit && $produit->getTva() === 0.055) ? true : false,
                    'required' => true,             
                    ]
                ],
                '0.1' => [
                    'label' => '10%',
                    'attributs' => [
                        'selected' => ($produit && $produit->getTva() === 0.1) ? true : false,
                        'required' => true,             
                        ]
                    ],
                    '0.2' => [
                        'label' => '20%',
                        'attributs' => [
                            'selected' => ($produit && $produit->getTva() === 0.2) ? true : false,
                            'required' => true,             
                            ]
                        ],
                    ],
                    [
                        'class' => 'form-control',
                        'id' => 'tva',
                    ])
        ->endDiv()
        ->addLabel('prixHT', 'PrixHT* :', ['class' => 'form-label'])
            ->addInput('number', 'prixHT', [
                'class' => 'form-control',
                'id' => 'prixHT',
                'required' => true,
                'placeholder' => 'Prix en €',
                'step' => '0.01',
                'value' => $produit ? $produit->getPrixHT() : null,
            ])
        ->startDiv(['class' => 'text-center'])
                ->addButton($produit ? 'Modifier le produit' : 'Créer le produit', [
                'class' => 'btn btn-primary mt-3',
                'type' => 'submit',
            ])
        ->endDiv()
        ->endForm();
    }
}
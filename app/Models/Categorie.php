<?php

namespace App\Models;

use DateTime;
use App\Models\Model;

class Categorie extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $nom = null,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
        protected ?bool $actif = null,
        protected ?string $imageName = null,
    )
    {
        $this->table = "categories";
    }

    public function findOneByNom(string $nom): self|bool
    {
        return $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table
            WHERE nom = :nom", ['nom' => $nom])->fetch()
        );
    }

    public function findAllCategoriesForSelect(): array
    {
        $results = $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table")->fetchAll()
        );

        foreach($results as $result) {
            [$this->getNom() => [
                'label' => $this->getNom(),
                //si categorieId dans l'article = id de l'objet categorie
                'selected' => ((new Article)->getCategorieId() === $this->getId()) ? true : false,
            ]
            ];

            return $result;
        }
    }

        /**
         * Get the value of id
         *
         * @return ?int
         */
        public function getId(): ?int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param ?int $id
         *
         * @return self
         */
        public function setId(?int $id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of nom
         *
         * @return ?string
         */
        public function getNom(): ?string
        {
                return $this->nom;
        }

        /**
         * Set the value of nom
         *
         * @param ?string $nom
         *
         * @return self
         */
        public function setNom(?string $nom): self
        {
                $this->nom = $nom;

                return $this;
        }

        /**
         * Get the value of createdAt
         *
         * @return ?DateTime
         */
        public function getCreatedAt(): ?DateTime
        {
                return $this->createdAt;
        }

        /**
         * Set the value of createdAt
         *
         * @param ?DateTime $createdAt
         *
         * @return self
         */
        public function setCreatedAt(?DateTime $createdAt): self
        {
                $this->createdAt = $createdAt;

                return $this;
        }

        /**
         * Get the value of updatedAt
         *
         * @return ?DateTime
         */
        public function getUpdatedAt(): ?DateTime
        {
                return $this->updatedAt;
        }

        /**
         * Set the value of updatedAt
         *
         * @param ?DateTime $updatedAt
         *
         * @return self
         */
        public function setUpdatedAt(?DateTime $updatedAt): self
        {
                $this->updatedAt = $updatedAt;

                return $this;
        }

        /**
         * Get the value of actif
         *
         * @return ?bool
         */
        public function getActif(): ?bool
        {
                return $this->actif;
        }

        /**
         * Set the value of actif
         *
         * @param ?bool $actif
         *
         * @return self
         */
        public function setActif(?bool $actif): self
        {
                $this->actif = $actif;

                return $this;
        }

        /**
         * Get the value of imageName
         *
         * @return ?string
         */
        public function getImageName(): ?string
        {
                return $this->imageName;
        }

        /**
         * Set the value of imageName
         *
         * @param ?string $imageName
         *
         * @return self
         */
        public function setImageName(?string $imageName): self
        {
                $this->imageName = $imageName;

                return $this;
        }
}
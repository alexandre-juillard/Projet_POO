<?php

namespace App\Models;

use App\Models\Model;

class Postes extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $titre = null,
        protected ?string $description = null,
        protected ?\DateTime $createdAt = null,
        protected ?bool $actif = null,
        protected ?int $user_id = null,
    ) {
        $this->table = 'postes';
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
     * Get the value of titre
     *
     * @return ?string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @param ?string $titre
     *
     * @return self
     */
    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param ?string $description
     *
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return ?\DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param \DateTime|string|null $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime|string|null $createdAt): self
    {
        if (is_string($createdAt)) {
            $this->createdAt = new \DateTime($createdAt);
        } else {
            $this->createdAt = $createdAt;
        }

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
     * Get the value of user_id
     *
     * @return ?int
     */
    public function getUser_id(): ?int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @param ?int $user_id
     *
     * @return self
     */
    public function setUser_id(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}

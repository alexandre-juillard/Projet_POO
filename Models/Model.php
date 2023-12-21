<?php

namespace App\Models;

use DateTime;
use App\Core\Db;
use PDOStatement;

abstract class Model extends Db
{
    public function __construct(
        protected ?string $table = null,
        protected ?Db $db = null,
    ) {
    }

    /**
     * Méthode pour récupérer toutes les entrées d'un table
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->hydrateObject(
            $this->runQuery('SELECT * FROM ' . $this->table)->fetchAll()
        );
    }

    /**
     * Méthode de recherche par id
     *
     * @param integer $id
     * @return array|bool
     */
    public function find(int $id): object|bool
    {
        return $this->hydrateObject(
            $this->runQuery("SELECT * FROM $this->table WHERE id = :id", ['id' => $id])->fetch()
        );
    }

    /**
     * Méthode pour chercher des entrées avec un tableau de filtre
     *
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters): array
    {
        $champs = [];
        $valeurs = [];

        // On boucle sur le tableau de filtre pour peupler les tableaux
        foreach ($filters as $key => $filter) {
            $champs[] = "$key = :$key";
            $valeurs[$key] = $filter;
        }

        // On transforme le tableau champs en chaîne  de caractère
        $champs = implode(' AND ', $champs);

        // On exécute la requete sql en lui passant les attributs
        return $this->hydrateObject(
            $this->runQuery("SELECT * FROM $this->table WHERE $champs", $valeurs)->fetchAll()
        );
    }

    public function create(): PDOStatement|bool
    {
        // La requete que nous devons créer :
        // INSERT INTO poste (titre, description, actif) VALUES (:titre, :description, :actif)
        // [:titre, :description, :actif]
        // ['titre' => 'Le titre']

        $champs = [];
        $markers = [];
        $valeurs = [];

        // On boucle sur l'objet
        foreach ($this as $key => $value) {
            if ($key !== 'table' && $value !== null) {
                $champs[] = $key;
                $markers[] = ":$key";

                if ($value instanceof DateTime) {
                    $valeurs[$key] = date_format($value, 'Y-m-d H:i:s');
                } else {
                    $valeurs[$key] = $value;
                }
            }
        }

        $champs = implode(', ', $champs);
        $markers = implode(', ', $markers);

        return $this->runQuery("INSERT INTO $this->table ($champs) VALUES ($markers)", $valeurs);
    }

    public function update(): PDOStatement|bool
    {
        // UPDATE postes SET titre=:titre WHERE id = :id
        $champs = [];
        $valeurs = [];

        foreach ($this as $key => $value) {
            if ($key !== 'table' && $value !== null && $key !== 'id') {
                $champs[] = "$key = :$key";

                if ($value instanceof DateTime) {
                    $valeurs[$key] = date_format($value, 'Y-m-d H:i:s');
                } else {
                    $valeurs[$key] = $value;
                }
            }
        }

        $champs = implode(', ', $champs);

        /** @var Postes $this */
        $valeurs['id'] = $this->id;

        return $this->runQuery("UPDATE $this->table SET $champs WHERE id = :id", $valeurs);
    }

    public function delete(): PDOStatement|bool
    {
        /** @var Postes $this */
        return $this->runQuery("DELETE FROM $this->table WHERE id = :id", ['id' => $this->id]);
    }

    public function hydrate(array|object $data): static
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);

            // On vérfie si le setter existe
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    public function hydrateObject(mixed $query): array|static|bool
    {
        if (is_array($query) && count($query) > 0) {
            $data = array_map(function (mixed $value): static {
                return (new static)->hydrate($value);
            }, $query);

            return $data;
        } elseif (!empty($query)) {
            return (new  static)->hydrate($query);
        } else {
            return $query;
        }
    }

    /**
     * Methode pour éxecuter les requêtes sql
     *
     * @param string $sql
     * @param array $attributs
     * @return PDOStatement|boolean
     */
    protected function runQuery(string $sql, array $attributs = []): PDOStatement|bool
    {
        // Récupérer notre instance de Db
        $this->db = Db::getInstance();

        // On vérifie s'il y a des attributs
        if ($attributs !== null) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);

            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }
}

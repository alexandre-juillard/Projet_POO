<?php

namespace App\Models;

use App\Core\Db;
use DateTime;
use PDOStatement;

abstract class Model extends Db
{
    /**
     * Va stocker le nom de la table sur laquelle on travaille
     *
     * @var string|null
     */
    protected ?string $table = null;

    /**
     * Va stocker l'instance de connexion en bdd
     *
     * @var Db|null
     */
    protected ?Db $database = null;

    /**
     * fct pour recuperer les entrées d'une table
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table")->fetchAll()
        );
    }

    /**
     * fct pour chercher une entrée par son id
     *
     * @param integer $id
     * @return static|boolean
     */
    public function find(int $id): static|bool
    {
        return $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table WHERE id = :id", ['id' => $id])->fetch()
        );
    }

    /**
     * fct pour rechercher une entrée avec filtre
     *
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters): array
    {
        // champs va stocker les clés et son marqueur, valeurs va stocker la valeur de la clé
        $champs = [];
        $valeurs = [];

        //Faire une boucle sur tableau de filtre
        foreach ($filters as $key => $value) {
            $champs[] = "$key = :$key";
            $valeurs[$key] = $value;
        }

        //transforme les champs en une seule chaine qui sera integrer dans la requete
        $strChamp = implode(' AND ', $champs);

        return $this->fetchHydrate(
            $this->runQuery("SELECT * FROM $this->table WHERE $strChamp", $valeurs)->fetchAll()
        );
    }

    /**
     * fct pour créer 
     *
     * @return PDOStatement|boolean
     */
    public function create(): PDOStatement|bool
    {
        //INSERT INTO $this->table(nom, prenom, email, password, roles) VALUES (:nom, :prenom, :email, :password, :roles)
        $champs = [];
        $markers = [];
        $valeurs = [];

        foreach ($this as $key => $value) {
            //filtre les infos qu'on récupère, enleve la table et database et valeurs non remplies
            if ($key != 'table' && $key != 'database' && $value !== null) {

                //stocke les infos dans variables sous forme de tableau
                $champs[] = "$key";
                $markers[] = ":$key";

                //si $value est un tableau, on transforme en json pour etre lu par bdd
                if (is_array($value)) {
                    $valeurs[$key] = json_encode($value);
                } else if ($value instanceof DateTime) {
                    $valeurs[$key] = $value->format('Y-m-d H:i:s');
                } else if (is_bool($value)) {
                    $valeurs[$key] = (int) $value;
                } else {
                    $valeurs[$key] = $value;
                }
            }
        }
        // transforme infos de tableau en une seule chaine
        $strChamp = implode(', ', $champs);
        $strMarker = implode(', ', $markers);

        return $this->runQuery("INSERT INTO $this->table($strChamp) VALUES ($strMarker)", $valeurs);
    }

    /**
     * fct pour mettre a jour une table
     *
     * @return PDOStatement|boolean
     */
    public function update(): PDOStatement|bool
    {
        //UPDATE $this->table SET nom = :nom, prenom = :prenom WHERE id = :id

        $champs = [];
        $valeurs = [];

        foreach ($this as $key => $value) {
            if ($key != 'table' && $key != 'database' && $key != 'id' && $value !== null) {
                $champs[] = "$key = :$key";

                if (is_array($value)) {
                    $valeurs[$key] = json_encode($value);
                } else if ($value instanceof DateTime) {
                    $valeurs[$key] = $value->format('Y-m-d H:i:s');
                } else if (is_bool($value)) {
                    $valeurs[$key] = (int) $value;
                } else {
                    $valeurs[$key] = $value;
                }
            }
        }
        //commentaire qui indique a vscode d'ou vient id car il existe pas dans classe Model
        /**
         * @var User $this
         */
        $valeurs['id'] = $this->id;

        $strChamp = implode(',', $champs);
        return $this->runQuery("UPDATE $this->table SET $strChamp WHERE id = :id", $valeurs);
    }

    /**
     * fct pour delete 
     *
     * @return PDOStatement|boolean
     */
    public function delete(): PDOStatement|bool
    {
        //DELETE FROM $this->table WHERE id= :id
        /**
         * @var User $this
         */
        return $this->runQuery("DELETE FROM $this->table WHERE id = :id", ['id' => $this->id]);
    }
    /**
     * fonction pour executer n'importe quelle requete SQL
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement|boolean
     */
    protected function runQuery(string $sql, array $params = []): PDOStatement|bool
    {
        //on recupere l'instance de Db
        $this->database = Db::getInstance();

        if (!empty($params)) {
            //je suis dans une requete préparée
            $query = $this->database->prepare($sql);
            $query->execute($params);
        } else {
            //requete simple
            $query = $this->database->query($sql);
        }

        return $query;
    }



    /**
     * fct qui prerempli les données sous forme d'objet pour automatiser apport de données(evite d ecrire les setter)
     *
     * @param array|object $data
     * @return static
     */
    public function hydrate(array|object $data): static
    {
        //automatisation des setter dynamiquement (nom devient setNom($value)), transforme un tableau en objet
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);

            //patch pour faire fct meme si roles est vide
            if ($key === 'roles') {
                $this->$setter($value ? json_decode($value) : null);
            } else if ($key === 'createdAt' || $key === 'updatedAt' && $value) {
                $this->$setter(new DateTime($value));
            } else {
                $this->$setter($value);
            }
        }
        return $this;
    }

    public function fetchHydrate(mixed $query): array|static|bool
    {
        if (is_array($query)) {
            $data = array_map(function (object $value): static {
                return (new static())->hydrate($value);
            }, $query);

            return $data;
        } else if (!empty($query)) {
            return (new static())->hydrate($query);
        }

        return $query;
    }
}

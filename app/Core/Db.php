<?php 

//fichier de la classe Db
//l'instance de Db va permettre la connexion a la bdd
namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    private const DB_HOST = "projetpoo-db-1";
    private const DB_USER = "root";
    private const DB_PASSWORD = "root";
    private const DB_NAME = "mvc_data";

    private static ?Db $instance = null;

    public function __construct()
    {   

        //lien de connexion en bdd
        $dsn = "mysql:dbname=" . self::DB_NAME . ";host=" . self::DB_HOST . ";charset=utf8mb4";

        //on essaie de se connecte ren bdd
        try{

         parent::__construct($dsn, self::DB_USER, self::DB_PASSWORD);

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAME utf8');

        } catch(PDOException $error) {
            die('Erreur: ' . $error->getMessage());
        }
    }

    /**
     * permet de récupérer l'instance de la connexion en bdd ou créer une si existe pas
     *
     * @return self
     */
    public static function getInstance(): self
    {
        //si l'instance existe pas elle se crée, sinon se retourne elle
        if (self::$instance === null) {
            self::$instance = new Db();
        }

        return self::$instance;
    }
}
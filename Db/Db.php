<?php

namespace App\Db;

use PDO;
use PDOException;

class Db extends PDO
{
    public const DB_HOST = 'mvcdebutexo-db-1';
    public const DB_USER = 'root';
    public const DB_PASSWORD = 'root';
    public const DB_NAME = "demo_mvc_esgi";

    // l'instance de la connexion en Base de donnée
    private static ?Db $instance = null;

    public function __construct()
    {
        // On définit l'url de notre BDD
        // mysql:dbname=demo_mvc;host=mvcdebutexo-db-1;
        $dsn = "mysql:dbname=" . self::DB_NAME . ';host=' . self::DB_HOST;

        try {
            parent::__construct($dsn, self::DB_USER, self::DB_PASSWORD);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            throw new PDOException($error->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

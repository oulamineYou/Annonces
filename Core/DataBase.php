<?php

namespace App_Olm\Core;

use PDO;
use PDOException;

/**
 * la classe de la connexion à la base de données
 * cette classe ne doit instancier qu'une sul fois (Singleton)
 * il hérite de la classe PDO
 */
class DataBase extends PDO
{

    /**
     * un instance de notre classe
     *
     * @var DataBase
     */
    private static $instance;

    //le hoste de la base de données
    private const DBHOST = "localhost";
    //le nom de la base de donnée
    private const DBNAME = "annonce";
    //le nom d'utilisateur de la base de données
    private const DBUSER = "root";
    //le password de la base de données
    private const DBPASSWORD = "";

    private function __construct(){
        $dsn = "mysql:host=". self::DBHOST.";dbname=".self::DBNAME;

        try {
            //la connexion avec la base de données
            parent::__construct($dsn, self::DBUSER, self::DBPASSWORD);

            $this->setAttribute(parent::MYSQL_ATTR_INIT_COMMAND,  'SET NAMES utf8');

            /**
             * le mode d'erreur va être mode d'exception
             * il va lancer une exception au cas d'erreur avec le code et les informations de cette erreur
             */
            $this->setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);

            //le retourne de la methode fetch va être des Objets
            $this->setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_OBJ);
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }   

    /**
     * le getteur de l'instance de notre base de donnée
     * il garantit que notre classe ne peut instanssier qu'une seul fois
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if(self::$instance === null)
            self::$instance = new self();
        return self::$instance;
    }

}
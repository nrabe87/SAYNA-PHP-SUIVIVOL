<?php

namespace Kernel;

use \Config\DB;

class Connexion
{
    private static $pdo;

    private function __construct()
    {
        return;
    }

    public static function get()
    {
        if (!isset(self::$pdo)) {
            try {
                //Création
                self::$pdo = new \PDO('mysql:host=' . DB::HOST . ';dbname=' . DB::NAME . ';port=4306', DB::USERNAME, DB::PASSWORD);

                //Configuration
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {

                //erreur de connexion
                echo 'Erreur de connexion :' . $e->getMessage();
            }
        }
        return self::$pdo;
    }
    public static function query($query,$class,$params=[])
    {
        $stmt = self::get()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_CLASS,$class);
    }

    public static function execute($query, $params = [])
    {
        $stmt = self::get()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_CLASS,$class);
    }
}
?>
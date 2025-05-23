<?php

class Database {
    private static ?mysqli $conn = null;

    public static function getConnection(): mysqli {
        if (self::$conn === null) {
            $servername = "arcadia-db";
            $username = "KeeperAdmin";
            $password = "WildLifeSecure33!";
            $dbname = "arcadia";

            self::$conn = new mysqli($servername, $username, $password, $dbname);

            if (self::$conn->connect_error) {
                die("La connexion à la base de données a échoué : " . self::$conn->connect_error);
            }
        }

        return self::$conn;
    }
}
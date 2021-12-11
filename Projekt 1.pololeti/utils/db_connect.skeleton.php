<?php

class DB {
    public static function connect(): PDO
    {
        // zde doplnit a poté přepsat z db_connect.skeleton.php na db_connect.php
        $host = '';
        $db = '';
        $user = '';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);

        return $pdo;
    }
}


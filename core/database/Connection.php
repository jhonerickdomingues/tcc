<?php

class Connection
{
    public static $pdo;

    public static function make($config)
    {

        try {
            self::$pdo = new PDO
            (
                'mysql:host='.$config["host"].';dbname='.$config['database'],
                $config['user'],
                $config['password'],
                $config['options']
            );
            return self::$pdo;
        } catch (PDOException $e) {
            echo 'Error!: ' , $e->getMessage() , '<br/>';
            die();
        }

    }
}
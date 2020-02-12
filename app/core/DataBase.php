<?php

class DataBase
{
    // параметры бд
    const HOST = 'localhost';
    const DB_NAME = 'vanilamvc';
    const USERNAME = 'root';
    const PASSWORD = '';


    // подключаемся к бд
    public static function connect()
    {
        $username = self::USERNAME;
        $password = self::PASSWORD;
        $host = self::HOST;
        $db_name = self::DB_NAME;

        $conn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($conn !== null){
            return $conn;
        }
        else {
            return false;
        }


//        try {
//            $conn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
//            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        } catch (PDOException $e) {
//            echo 'Connection Error: ' . $e->getMessage();
//        }
    }

}
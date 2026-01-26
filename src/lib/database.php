<?php

namespace Application\Lib\Database;

use PDO;

class DatabaseConnection {
    public ?\PDO $database = null;

    public function getConnection(): \PDO{
        if($this->database === null){
            $this->database = new \PDO('mysql:host=localhost;dbname=reservation_restaurant;charset=utf8', 'root', 'root');
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        return $this->database;
    }
}
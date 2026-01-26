<?php

namespace Application\Model\Admin;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;
use PDO;

class Admin
{
    public int $id;
    public string $username;
}

class AdminRepository
{
    protected DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }

    public function login($username, $mdp)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM admins WHERE username = ? LIMIT 1"
        );
        $statement->execute([$username]);
        $row = $statement->fetch(PDO::FETCH_OBJ);
        

        if ($row) {
            if(password_verify($mdp, $row->mdp)){
                $admin = new Admin();
                $admin->id = $row->id;
                $admin->username = $row->username;
                return $admin;
            }
        }
        return null;
    }
}

<?php

namespace Application\Model\TableRestaurant;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class TableRestaurant{
    public int $id;
    public int $numero;
    public int $capacite;
    public string $zone;
}

class TableRestaurantRepository{

    protected DatabaseConnection $connection;

    public function __construct() {
        $this->connection = new DatabaseConnection();
    }

    public function getTableRestaurant($id): TableRestaurant{
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM tables_restaurant WHERE id = ?"
        );
        $statement->execute([$id]);
        $row = $statement->fetch();
        $table = new TableRestaurant();
        $table->id = $row['id'];
        $table->numero = $row['numero'];
        $table->capacite = $row['capacite'];
        $table->zone = $row['zone'];
        return $table;
    }

    public function getTablesRestaurant(): array{
        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM tables_restaurant"
        );
        $tables = [];
        while(($row = $statement->fetch())){
            $table = new TableRestaurant();
            $table->id = $row['id'];
            $table->numero = $row['numero'];
            $table->capacite = $row['capacite'];
            $table->zone = $row['zone'];

            $tables[] = $table;
        }
        return $tables;
    }

    public function createTableRestaurant($numero, $capacite, $zone = ''): bool{
        $statement =  $this->connection->getConnection()->prepare(
            "SELECT * FROM tables_restaurant WHERE numero = ?"
        );
        $statement->execute([$numero]);
        $row = $statement->fetch();
        if(empty($row)){

            $statement = $this->connection->getConnection()->prepare(
                'INSERT INTO tables_restaurant(numero, capacite, zone) VALUES(?, ?, ?)'
            );
            $affectedLines = $statement->execute([$numero, $capacite, $zone]);
            return ($affectedLines > 0);
        }
        return false;
    }

    public function updateTableRestaurant(int $id, int $numero, int $capacite, string $zone) : bool{
        $statement =  $this->connection->getConnection()->prepare(
            "SELECT * FROM tables_restaurant WHERE numero = ? AND id != ?"
        );
        $statement->execute([$numero, $id]);
        $row = $statement->fetch();
        if(empty($row)){
            $statement = $this->connection->getConnection()->prepare(
                'UPDATE tables_restaurant SET numero = ?, capacite = ?, zone = ? WHERE id = ?'
            );
            $affectedLines = $statement->execute([$numero, $capacite, $zone, $id]);

            return ($affectedLines > 0);
        }
        return false;
    }

    public function deleteTableRestaurant($id) : bool{
        // TODO: before delete check if it's used at any reservation

        $statement = $this->connection->getConnection()->prepare(
            'DELETE FROM tables_restaurant WHERE id = ?'
        );
        $affectedLines = $statement->execute([$id]);
        return ($affectedLines > 0);
    }
}
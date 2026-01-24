<?php

namespace Application\Controllers;

require_once('src/lib/database.php');
require_once('src/model/table_restaurant.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\TableRestaurant\TableRestaurantRepository;

class TableRestaurantController{
    public function show(){

        $connection = new DatabaseConnection();
        $tableRestaurantRepository = new TableRestaurantRepository();
        $tableRestaurantRepository->connection = $connection;

        $tables = $tableRestaurantRepository->getTablesRestaurant();
      

        require('templates/table_restaurant/show.php');
    }

    public function add(array $input){
        $numero = null;
        $capacite = null;
        $zone = null;

        if (!empty($input['numero']) && !empty($input['capacite'])) {
            $numero = $input['numero'];
            $capacite = $input['capacite'];
            $zone = trim($input['zone']);
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        $connection = new DatabaseConnection();
        $tableRestaurantRepository = new TableRestaurantRepository();
        $tableRestaurantRepository->connection = $connection;

        $success = $tableRestaurantRepository->createTableRestaurant($numero, $capacite, $zone);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter la table restaurant!');
        } else {
            header('Location: index.php?action=table_restaurant');
        }
    }

    public function edit(array $input){
        $id = null;
        $numero = null;
        $capacite = null;
        $zone = null;

        if (!empty($input['id']) && !empty($input['numero']) && !empty($input['capacite'])) {
            $id = $input['id'];
            $numero = $input['numero'];
            $capacite = $input['capacite'];
            $zone = trim($input['zone']);
        } else {
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        $connection = new DatabaseConnection();
        $tableRestaurantRepository = new TableRestaurantRepository();
        $tableRestaurantRepository->connection = $connection;

        $success = $tableRestaurantRepository->updateTableRestaurant($id, $numero, $capacite, $zone);
        if (!$success) {
            throw new \Exception('Impossible de modifier la table restaurant!');
        } else {
            header('Location: index.php?action=table_restaurant');
        }

    }

    public function delete($id){
        if(isset($id) && !is_null($id)){
            $connection = new DatabaseConnection();
            $tableRestaurantRepository = new TableRestaurantRepository();
            $tableRestaurantRepository->connection = $connection;

            $success = $tableRestaurantRepository->deleteTableRestaurant($id);
            if (!$success) {
                throw new \Exception('Impossible de supprimer la table !');
            } else {
                header('Location: index.php?action=table_restaurant');
            }
        }
    }

    public function apiGet($id){
            
        if(isset($id) && !is_null($id)){
            $connection = new DatabaseConnection();
            $tableRestaurantRepository = new TableRestaurantRepository();
            $tableRestaurantRepository->connection = $connection;
            $table = $tableRestaurantRepository->getTableRestaurant($id);
            return json_encode($table);
        }
    }


}
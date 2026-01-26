<?php

namespace Application\Controllers;

require_once('src/model/table_restaurant.php');

use Application\Model\TableRestaurant\TableRestaurantRepository;

class TableRestaurantController{

    protected $tableRestaurantRepository;

    public function __construct() {

        if(!isset($_SESSION["admin"])){
            (new LoginController())->showLogin();
            exit;
        }

        $this->tableRestaurantRepository = new TableRestaurantRepository();
    }

    public function show(){
        $tables = $this->tableRestaurantRepository->getTablesRestaurant();
      
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

        $success = $this->tableRestaurantRepository->createTableRestaurant($numero, $capacite, $zone);
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
             $success = $this->tableRestaurantRepository->updateTableRestaurant($id, $numero, $capacite, $zone);
            if (!$success) {
                $_SESSION['error'] = 'Table restaurant déja exists!';
            } else {
                $_SESSION['success'] = 'La table est mise à jour avec succès';
            }
        } else {
            $_SESSION['error'] = 'Les données du formulaire sont invalides.';
        }
        header('Location: index.php?action=table_restaurant');
    }

    public function delete($id){
        if(isset($id) && !is_null($id)){

            $success = $this->tableRestaurantRepository->deleteTableRestaurant($id);
            if (!$success) {
                throw new \Exception('Impossible de supprimer la table !');
            } else {
                header('Location: index.php?action=table_restaurant');
            }
        }
    }

    public function apiGet($id){
        if(isset($id) && !is_null($id)){
            $table = $this->tableRestaurantRepository->getTableRestaurant($id);
            return json_encode($table);
        }
    }




}
<?php

use Application\Controllers\HomePageController;

require_once('src/controllers/homepage.php');

try {
    if (isset($_GET['action'])) {

        session_start();

        // home page
        if ($_GET['action'] === '') {
            (new HomePageController())->execute();
        }

        // add reservation
        if ($_GET['action'] === 'add_reservation') {
            (new HomePageController())->addReservation();
        }

        if($_GET['action'] === 'api_get_creneaux'){
            $date = $_GET['date'];
            echo (new HomePageController())->apiGetCreneauxAvailable($date);
        }

        if($_GET['action'] === 'api_get_available_table'){
            $date = $_GET['date'];
            $creneau = $_GET['creneau'];
            $nbr_personnes = $_GET['nbr_personnes'];
            echo (new HomePageController())->apiGetAvailableTableRestaurant($date, $creneau, $nbr_personnes);
        }


        if ($_GET['action'] === 'sauvegarder_reservation') {
                $inputs = $_POST;
                (new HomePageController())->sauvegarderReservation($inputs);
            }

        // dashboard
        require_once('routers/dashboard.php');

        // gestion des tables restaurants
        require_once('routers/table_resertaurant.php');

        // gestion des creneaux
        require_once('routers/creneau.php');
    } else {
        (new HomePageController())->execute();
    }
} catch (Exception $e) {
    // render page error
}

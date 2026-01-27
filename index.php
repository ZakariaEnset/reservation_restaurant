<?php

use Application\Controllers\HomePageController;
use Application\Controllers\LoginController;

require_once('src/controllers/homepage.php');
require_once('src/controllers/login.php');
require 'vendor/autoload.php';


try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    if (isset($_GET['action'])) {

        session_start();

        // home page
        if ($_GET['action'] === '') {
            (new HomePageController())->execute();
        }else if ($_GET['action'] === 'login_form') {
            (new LoginController())->showLogin();
        }else if ($_GET['action'] === 'login') {
            $username = $_POST['username'];
            $mdp = $_POST['mdp'];
            (new LoginController())->login($username, $mdp);
        }
        else if ($_GET['action'] === 'add_reservation') {
            (new HomePageController())->addReservation();
        }else if ($_GET['action'] === 'api_get_creneaux') {
            $date = $_GET['date'];
            echo (new HomePageController())->apiGetCreneauxAvailable($date);
        }else if ($_GET['action'] === 'api_get_available_table') {
            $date = $_GET['date'];
            $creneau = $_GET['creneau'];
            $nbr_personnes = $_GET['nbr_personnes'];
            echo (new HomePageController())->apiGetAvailableTableRestaurant($date, $creneau, $nbr_personnes);
        }else if ($_GET['action'] === 'sauvegarder_reservation') {
            $inputs = $_POST;
            (new HomePageController())->sauvegarderReservation($inputs);
        }elseif($_GET['action'] == 'logout'){
            unset($_SESSION['admin']);
            header('Location: ?action=');
        }


        // admin routes
       
        // dashboard
        require_once('routers/dashboard.php');

        // gestion des tables restaurants
        require_once('routers/table_resertaurant.php');

        // gestion des creneaux
        require_once('routers/creneau.php');

        require_once('routers/reservation.php');
    } else {
        (new HomePageController())->execute();
    }
} catch (Exception $e) {
    // render page error
}

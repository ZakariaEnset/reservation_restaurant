<?php

use Application\Controllers\HomePageController\HomePageController;

require_once('src/controllers/homepage.php');

try {
    if (isset($_GET['action'])) {

        session_start();

        if ($_GET['action'] === '') {
            (new HomePageController())->execute();
        }

        // Dashboard page
        if ($_GET['action'] === 'dashboard') {
            (new HomePageController())->dashboard();
        }

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

<?php

namespace Application\Controllers;


class DashboardController
{

    public function __construct() {
        if(!isset($_SESSION["admin"])){
            (new LoginController())->showLogin();
            exit;
        }
    }

    public function dashboard()
    {
        require('templates/dashboard.php');
    }
}

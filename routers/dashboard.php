<?php

use Application\Controllers\DashboardController;
use Application\Controllers\LoginController;

require_once('src/controllers/dashboard.php');
require_once('src/controllers/login.php');



 // Admin Dashboard page
if ($_GET['action'] === 'dashboard') {
    (new DashboardController())->dashboard();
}
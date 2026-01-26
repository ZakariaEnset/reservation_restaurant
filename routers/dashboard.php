<?php

use Application\Controllers\DashboardController;

require_once('src/controllers/dashboard.php');

 // Admin Dashboard page
if ($_GET['action'] === 'dashboard') {
    (new DashboardController())->dashboard();
}

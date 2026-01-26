<?php
require_once('src/controllers/creneau.php');


use Application\Controllers\CreneauController;

if ($_GET['action'] === 'creneaux') {
    (new CreneauController())->show();
} else if ($_GET['action'] === 'api_get_creneau') {
    $input = $_GET['id'];
    echo (new CreneauController())->apiGet($input);
} else if ($_GET['action'] === 'add_creneau') {
    $input = $_POST;
    (new CreneauController())->add($input);
} else if ($_GET['action'] === 'update_creneau') {
    $input = $_POST;
    (new CreneauController())->edit($input);
} else if ($_GET['action'] === 'delete_table_creneau') {
    $input = $_POST['id'];
    (new CreneauController())->delete($input);
} 

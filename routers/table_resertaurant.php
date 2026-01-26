<?php
require_once('src/controllers/table_restaurant.php');


use Application\Controllers\TableRestaurantController;

if ($_GET['action'] === 'table_restaurant') {
    (new TableRestaurantController())->show();
} else if ($_GET['action'] === 'api_get_table_restaurant') {
    $input = $_GET['id'];
    echo (new TableRestaurantController())->apiGet($input);
} else if ($_GET['action'] === 'add_table_restaurant') {
    $input = $_POST;
    (new TableRestaurantController())->add($input);
} else if ($_GET['action'] === 'update_table_restaurant') {
    $input = $_POST;
    (new TableRestaurantController())->edit($input);
} else if ($_GET['action'] === 'delete_table_restaurant') {
    $input = $_POST['id'];
    (new TableRestaurantController())->delete($input);
} 

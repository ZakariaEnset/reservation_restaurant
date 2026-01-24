<?php

require_once('src/controllers/homepage.php');


use Application\Controllers\Homepage\Homepage;

try{
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        
        // gestion des tables restaurants
        require_once('routers/table_resertaurant.php');
    }else{
        (new HomePage())->execute();     
    }
}catch(Exception $e){
    // render page error
}

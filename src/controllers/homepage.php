<?php

namespace Application\Controllers\HomePageController;

class HomePageController {
    public function execute(){
        require('templates/homepage.php');
    }

    public function dashboard(){
        require('templates/dashboard.php');
    }
}
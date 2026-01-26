<?php

namespace Application\Controllers;

use Application\Model\Admin\AdminRepository;

require_once('src/model/admin.php');


class LoginController {
    protected $adminRepositry;

    public function __construct()
    {
        $this->adminRepositry = new AdminRepository();
    }

    public function showLogin(){
        require_once('templates/login.php');
    }

    public function login($username, $mdp){
        if (!empty($username) && !empty($mdp)) {
            $admin = $this->adminRepositry->login($username, $mdp);
         
            if ($admin) {
                $_SESSION['admin'] = $admin->id;
                return header('Location: index.php?action=dashboard');
            } else {
               $_SESSION['error'] = 'Erreur connexion !';
            }
        } else {
            $_SESSION['error'] = 'Les données du formulaire sont invalides.';
        }
        header('Location: index.php?action=login_form');
    }

}

<?php

namespace Application\Controllers;

require_once('src/model/reservation.php');

use Application\Model\Reservation\ReservationRepository;

class DashboardController
{

    protected $reservationRepository;

    public function __construct() {
        if(!isset($_SESSION["admin"])){
            (new LoginController())->showLogin();
            exit;
        }

        $this->reservationRepository = new ReservationRepository();
    }

    public function dashboard()
    {
        $statistiquesReservations = $this->reservationRepository->getStatistiquesStatutReservation(); 
        require('templates/dashboard.php');
    }
}

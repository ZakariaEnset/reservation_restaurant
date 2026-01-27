<?php

namespace Application\Controllers;

use Application\Model\Reservation\ReservationRepository;
use Application\Model\TableRestaurant\TableRestaurantRepository;

require_once('src/model/reservation.php');
require_once('src/model/table_restaurant.php');


class ReservationController
{
    protected $reservationRepository;
    protected $tableRestaurantRepository;


    public function __construct()
    {
        if(!isset($_SESSION["admin"])){
            (new LoginController())->showLogin();
            exit;
        }

        $this->reservationRepository = new ReservationRepository();
        $this->tableRestaurantRepository = new TableRestaurantRepository();

    }

    public function show($filterParams = [])
    {
        $reservations = $this->reservationRepository->getReservations($filterParams);
        require_once('templates/reservation/show.php');
    }


    public function changeReservationStatut($idReservation, $statut)
    {
        if (!empty($idReservation) && !empty($statut)) {
              $success = $this->reservationRepository->changerStatutReservation($idReservation, $statut);
            if (!$success) {
                $_SESSION['error'] = "Erreur lors changement de statut conflit réservation";
            } else {
                $_SESSION['success'] = 'Le statut de réservation est mise à jour';
            }
        } else {
            $_SESSION['error'] = 'Les données sont invalides.';
        }

        header('Location: index.php?action=reservations');
    }

    public function calandar($date = ''){
        if(empty($date))
            $date =  date('Y-m-d');
      
        $filterParams['date'] = $date;
        $reservations = json_encode($this->reservationRepository->getReservations($filterParams));
        $tables = json_encode($this->tableRestaurantRepository->getTablesRestaurant());
        require_once('templates/reservation/calendar.php');

    }
}

<?php

namespace Application\Controllers;


require_once('src/model/creneau.php');
require_once('src/model/table_restaurant.php');
require_once('src/model/reservation.php');



use Application\Model\Creneau\CreneauRepository;
use Application\Model\Reservation\ReservationRepository;
use Application\Model\TableRestaurant\TableRestaurantRepository;

class HomePageController
{

    protected $creneauRepository;
    protected $tableRestaurantRepository;
    protected $reservationRepository;

    public function __construct()
    {
        $this->creneauRepository = new CreneauRepository();
        $this->tableRestaurantRepository = new TableRestaurantRepository();
        $this->reservationRepository = new ReservationRepository();
    }

    public function execute()
    {
        require('templates/homepage.php');
    }

    public function addReservation()
    {
        require('templates/add_reservation.php');
    }

    public function apiGetCreneauxAvailable($date)
    {
        if (isset($date) && !is_null($date)) {
            $creanux = $this->creneauRepository->getCreneauxWithAvailability($date);
            return json_encode($creanux);
        }
    }

    public function apiGetAvailableTableRestaurant($date, $creneau, $nb_personnes)
    {
        if (!empty($date) && !empty($creneau) && !empty($nb_personnes)) {
            $table = $this->tableRestaurantRepository->getAvailableTableRestaurant($date, $creneau, $nb_personnes);
            return json_encode($table);
        }
        return json_encode('');
    }

    public function sauvegarderReservation($inputs){
         $success = $this->reservationRepository->createReservation($inputs);
        if (!$success) {
            throw new \Exception('Impossible d\'éffectuer la réservation!');
        } else {
            $_SESSION['reservation_success'] = "Votre réservation est envoyé avec succès !";
            header('Location: index.php?action=add_reservation');
        }
    }
}

<?php

namespace Application\Controllers;

use Application\Model\Reservation\ReservationRepository;

require_once('src/model/reservation.php');


class ReservationController
{
    protected $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
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
}

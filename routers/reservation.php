<?php

use Application\Controllers\ReservationController;

require_once('src/controllers/reservation.php');

if ($_GET['action'] === 'reservations') {
    $filterParams = [];
    isset($_GET['statut']) ? $filterParams['statut'] = $_GET['statut'] : '';
    (new ReservationController())->show($filterParams);
}else if($_GET['action'] === 'change_statut_reservation'){
    $idReservation = $_POST['id'];
    $statut = $_POST['statut'];
    (new ReservationController())->changeReservationStatut($idReservation, $statut);
}

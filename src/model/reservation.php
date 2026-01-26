<?php

namespace Application\Model\Reservation;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;


class Reservation
{
    public int $id;
    public string $nomClient;
    public string $email;
    public string $telephone;
    public string $dateReservation;
    public int $creneauId;
    public int $tableId;
    public int $nbrPersonnnes;
    public string $commentaire;
    public string $status;
    public string $codeCofirmation;
    public string $dateCreation;
}


class ReservationRepository
{
    protected DatabaseConnection $connection;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
    }


    public function createReservation($inputs): bool
    {
        // TODO: check validation of reservation

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO reservations(nom_client, email, telephone, date_reservation, creneau_id, table_id, nombre_personnes, commentaires) "
                . "VALUES(?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $affectedLines = $statement->execute([
            $inputs['nomClient'],
            $inputs['email'],
            $inputs['tel'],
            $inputs['dateReservation'],
            $inputs['idCreneau'],
            $inputs['idTableRestaurant'],
            $inputs['nbrPersonnes'],
            $inputs['commentaires']
        ]);
        return ($affectedLines > 0);
    }
}

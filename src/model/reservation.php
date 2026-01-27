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


    public function getReservations($filterParams = []): array
    {
        $sqlQuery =  "SELECT r.*, tr.numero numero_table, tr.zone zone_table, c.heure heure_creneau, c.service service_creneau "
            . "FROM reservations r "
            . "INNER JOIN tables_restaurant tr on tr.id = r.table_id "
            . " INNER JOIN creneaux c on c.id = r.creneau_id WHERE 1=1 ";

        if (isset($filterParams['statut'])) {
            $sqlQuery .= " AND r.statut = :statut ";
        }

        $sqlQuery .= ' ORDER BY r.date_reservation DESC';

        $statement = $this->connection->getConnection()->prepare(
            query: $sqlQuery
        );

        if (isset($filterParams['statut'])) {
            $statement->bindParam('statut', $filterParams['statut']);
        }

        $statement->execute();
        $reservations = $statement->fetchAll();
        return $reservations;
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

    public function changerStatutReservation($idReservation, $statut): bool
    {
        if ($statut = 'confirmee') {
            // get infos current reservation
            $statement =  $this->connection->getConnection()->prepare(
                "SELECT * FROM reservations WHERE id = ?"
            );
            $statement->execute([$idReservation]);
            $reservation = $statement->fetch();

            // lookup if there is a reservation with the same conditions
            $statement =  $this->connection->getConnection()->prepare(
                "SELECT * FROM reservations WHERE date_reservation = ? AND creneau_id = ? AND table_id = ?  AND statut = ? LIMIT 1"
            );
            $statement->execute([$reservation['date_reservation'], $reservation['creneau_id'], $reservation['table_id'], 'confirmee']);
            $reservationConflit = $statement->fetch();
            if(!empty($reservationConflit)){
                return false;
            }
        }

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE reservations SET statut = ? WHERE id = ?"
        );
        $affectedLines = $statement->execute([$statut, $idReservation]);

        return ($affectedLines > 0);
    }
}

<?php

namespace Application\Model\Reservation;

require_once('src/lib/database.php');
require_once('src/lib/util.php');
require_once('src/lib/mail.php');



use Application\Lib\Database\DatabaseConnection;
use ReservationMail;

use function Application\Lib\generateRandomString;

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
    public string $statut;
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


    public function getReservations($filterParams): array
    {
        $sqlQuery =  "SELECT r.*, tr.numero numero_table, tr.zone zone_table, c.heure heure_creneau, c.service service_creneau "
            . "FROM reservations r "
            . "INNER JOIN tables_restaurant tr on tr.id = r.table_id "
            . " INNER JOIN creneaux c on c.id = r.creneau_id WHERE 1=1 ";

        if (isset($filterParams['statut'])) {
            $sqlQuery .= " AND r.statut = :statut ";
        }
        if (isset($filterParams['date']) && !empty($filterParams['date'])) {
            $sqlQuery .= " AND r.date_reservation = :date ";
        }


        $sqlQuery .= ' ORDER BY r.date_reservation DESC';

        $statement = $this->connection->getConnection()->prepare(
            query: $sqlQuery
        );

        if (isset($filterParams['statut'])) {
            $statement->bindParam('statut', $filterParams['statut']);
        }

         if (isset($filterParams['date']) && !empty($filterParams['date'])) {
            $statement->bindParam('date', $filterParams['date']);
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
            trim($inputs['nomClient']),
            $inputs['email'],
            $inputs['tel'],
            $inputs['dateReservation'],
            $inputs['idCreneau'],
            $inputs['idTableRestaurant'],
            $inputs['nbrPersonnes'],
            trim($inputs['commentaires'])
        ]);
        return ($affectedLines > 0);
    }

    public function changerStatutReservation($idReservation, $statut): bool
    {
        if ($statut == 'confirmee') {
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
            if (!empty($reservationConflit)) {
                return false;
            }

            // send code confirmation
            $code = generateRandomString(10);
            $mailSended = (new ReservationMail())->sendConfirmationCode($reservation['email'], $code);
            if($mailSended){
                $statement = $this->connection->getConnection()->prepare(
                    "UPDATE reservations SET  statut = ?,  code_confirmation = ? WHERE id = ?"
                );
                $affectedLines = $statement->execute([$statut, $code, $idReservation]);
    
                return $affectedLines > 0;
            }
            return false;
        }

        $statement = $this->connection->getConnection()->prepare(
            "UPDATE reservations SET statut = ?, code_confirmation = '' WHERE id = ?"
        );
        $affectedLines = $statement->execute([$statut, $idReservation]);

        return ($affectedLines > 0);
    }

    public function getStatistiquesStatutReservation(){
        $statement = $this->connection->getConnection()->query(
            "SELECT COUNT(id) total_count, SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) en_attente_count, "
            ."SUM(CASE WHEN statut = 'confirmee' THEN 1 ELSE 0 END) confirmee_count, "
            ." SUM(CASE WHEN statut = 'annulee' THEN 1 ELSE 0 END) annulee_count FROM reservations;"
        );
        $statement->execute();
        return $statement->fetch();
    }
}

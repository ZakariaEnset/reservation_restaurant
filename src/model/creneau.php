<?php

namespace Application\Model\Creneau;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Creneau {
    public int $id;
    public string $heure;
    public ServiceCreneau $service;
    public bool $is_available;
}

enum ServiceCreneau: string {
    case midi = 'midi';
    case soir = 'soir';
}

class CreneauRepository{
    protected DatabaseConnection $connection;

    public function __construct() {
        $this->connection = new DatabaseConnection();
    }

    public function getCreneau($id) : Creneau{
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM creneaux WHERE id = ?"
        );
        $statement->execute([$id]);
        $row = $statement->fetch();
        $creneau = new Creneau();
        $creneau->id = $row['id'];
        $creneau->heure = $row['heure'];
        $creneau->service = ServiceCreneau::from($row['service']);
        return $creneau;
    }

    public function getCreneaux(): array {
         $statement = $this->connection->getConnection()->query(
            "SELECT * FROM creneaux order by heure"
        );
        $creneaux = [];
        while(($row = $statement->fetch())){
            $creneau = new Creneau();
            $creneau->id = $row['id'];
            $creneau->heure = $row['heure'];
            $creneau->service = ServiceCreneau::from($row['service']);

            $creneaux[] = $creneau;
        }
        return $creneaux;
    }

    public function createCreneau($heure, $service) {
        $statement =  $this->connection->getConnection()->prepare(
            "SELECT * FROM creneaux WHERE heure = ?"
        );
        $statement->execute([$heure]);
        $row = $statement->fetch();

        if(empty($row)){
            $statement = $this->connection->getConnection()->prepare(
                'INSERT INTO creneaux(heure, service) VALUES(?, ?)'
            );
            $affectedLines = $statement->execute([$heure, $service]);
            return ($affectedLines > 0);
        }
        return false;
    }


    public function updateCreneau(int $id, $heure, $service) : bool{
        $statement =  $this->connection->getConnection()->prepare(
            "SELECT * FROM creneaux WHERE heure = ? AND id != ?"
        );
        $statement->execute([$heure, $id]);
        $row = $statement->fetch();

        if(empty($row)){
            $statement = $this->connection->getConnection()->prepare(
                'UPDATE creneaux SET heure = ?, service = ? WHERE id = ?'
            );
            $affectedLines = $statement->execute([$heure, $service, $id]);

            return ($affectedLines > 0);
        }
        return false;
    }

    public function deleteCreneau($id) : bool{
        // TODO: before delete check if it's used at any reservation

        $statement = $this->connection->getConnection()->prepare(
            'DELETE FROM creneaux WHERE id = ?'
        );
        $affectedLines = $statement->execute([$id]);
        return ($affectedLines > 0);
    }

    public function getCreneauxWithAvailability($date): array {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT c.*, CASE WHEN r.id  IS NULL THEN 1 ELSE 0 END as is_available "
            ." FROM creneaux c "
            ." LEFT JOIN reservations r on r.creneau_id = c.id AND r.date_reservation = ? AND r.statut = ? ORDER BY c.heure "
        );
        $statement->execute([$date, 'confirmee']);
        $creneaux = [];
        while(($row = $statement->fetch())){
            $creneau = new Creneau();
            $creneau->id = $row['id'];
            $creneau->heure = $row['heure'];
            $creneau->service = ServiceCreneau::from($row['service']);
            $creneau->is_available = $row['is_available'];
            $creneaux[] = $creneau;
        }
        return $creneaux;
    }
}
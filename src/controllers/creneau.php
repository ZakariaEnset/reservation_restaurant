<?php

namespace Application\Controllers;

require_once('src/model/creneau.php');

use Application\Model\Creneau\CreneauRepository;

class CreneauController
{

    protected $creneauRepository;

    public function __construct()
    {
        $this->creneauRepository = new CreneauRepository();
    }

    public function show()
    {
        $creneaux = $this->creneauRepository->getCreneaux();
        require('templates/creneau/show.php');
    }

    public function add(array $input)
    {
        $heure = null;
        $service = null;

        if (!empty($input['heure']) && !empty($input['service'])) {
            $heure = $input['heure'];
            $service = $input['service'];

            $success = $this->creneauRepository->createCreneau($heure, $service);
            if (!$success) {
                $_SESSION['error'] = 'Creneau déja exists!';
            } else {
                $_SESSION['success'] = 'Le creneau est crée avec succès';
            }
        } else {
            $_SESSION['error'] = 'Les données du formulaire sont invalides.';
        }
        header('Location: index.php?action=creneaux');
    }

    public function edit(array $input)
    {
        $id = null;
        $heure = null;
        $service = null;

        if (!empty($input['id']) && !empty($input['heure']) && !empty($input['service'])) {
            $id = $input['id'];
            $heure = $input['heure'];
            $service = $input['service'];

            $success = $this->creneauRepository->updateCreneau($id, $heure, $service);
            if (!$success) {
                $_SESSION['error'] = 'Creneau déja exists!';
            } else {
                $_SESSION['success'] = 'Le creneau est mise à jour avec succès';
            }
        } else {
            $_SESSION['error'] = 'Les données du formulaire sont invalides.';
        }

        header('Location: index.php?action=creneaux');
    }

    public function delete($id)
    {
        if (isset($id) && !is_null($id)) {
            $success = $this->creneauRepository->deleteCreneau($id);
            if (!$success) {
                $_SESSION['error'] = 'Impossible de supprimer ce creneau !';
            }
        }
        header('Location: index.php?action=creneaux');
    }

    public function apiGet($id)
    {
        if (isset($id) && !is_null($id)) {
            $creneau = $this->creneauRepository->getCreneau($id);
            return json_encode($creneau);
        }
    }
}

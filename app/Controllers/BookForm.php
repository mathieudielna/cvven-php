<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use \App\Models\Session;

/**
 * Classe technique permettant d'afficher le formulaire de réservation
 */
class BookForm extends Controller {

    /**
     * Vérifie si l'utilisateur est connecté et que les champs du formulaire sont bien rempli
     * 
     * @param void
     * @return string|object
     * -string retourne la vue avec ou sans les erreurs
     * -object redirige sur la Connexion et on demande à l'utilisateur de se connecter s'il ne l'est pas déja
     */
    public function index() {
        helper('form');

        Session::startSession();
        if (!Session::verifySession()) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        if (!$this->validate(['datedebut' => 'required', 'datefin' => 'required',
                    'pension' => 'required', 'typelogement' => 'required'],
                        ['datedebut' => ['required' => 'Merci d\'indiquer une date de début de séjour.'],
                            'datefin' => ['required' => 'Merci d\'indiquer une date de fin de séjour.'],
                            'pension' => ['required' => 'Merci d\'indiquer votre pension.'],
                            'typelogement' => ['required' => 'Veuillez selectionnez un type de séjour']])) {
            echo($this->request->getPost('pension'));
            $SiteReservationModel = new \App\Models\SiteReservationModel();
            echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
            echo view('form/book', ['validation' => $this->validator, 'data' => $SiteReservationModel->getTypeLogement()]);
            echo view('template/footer');
        } else {
            if ($this->control()) {
                return redirect()->to(site_url('PageUser'));
            }
        }
    }

    /**
     * Vérifie les éventuel erreurs lors de la création de l'objet(Durée de date incorrecte ou/et nombre de personne incorrecte)
     * 
     * @param void
     * @return bool|void    
     * - true si on a reussi à insérer les données,
     * - false en cas d'erreur.
     */
    private function control() {
        $leControlSiteReservation = new \App\Models\ControlSiteReservationModel($this->request->getPost('datedebut'), $this->request->getPost('datefin'), $this->request->getPost('nbpersonne'),
                $this->request->getPost('typelogement'),
                $this->request->getPost('pension'),
                $this->request->getPost('menage'));

        if ($leControlSiteReservation->Erreur()) {
            $tabException = $leControlSiteReservation->getException();
            foreach ($tabException as $Exception) {
                foreach ($Exception as $errorField => $errorValue) {
                    $this->validator->setError($errorField, $errorValue);
                }
            }
            $SiteReservationModel = new \App\Models\SiteReservationModel();
            echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
            echo view('form/book', ['validation' => $this->validator, 'data' => $SiteReservationModel->getTypeLogement()]);
            echo view('template/footer');
            return false;
        } else {
            Session::startSession();
            $leControlSiteReservation->insertUneReservation(Session::getSessionData('idUser'));
            return true;
        }
    }

}

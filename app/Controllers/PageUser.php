<?php
namespace App\Controllers;
use \CodeIgniter\Controller;
use \App\Models\Session;

/**
 * Classe technique permettant de visualiser les réservation d'un utilisateur
 *
 */
class PageUser extends Controller{
    /**
     * Récupère les informations de changement d'états de la réservation si l'utilisateur est bien sur connecté
     * 
     * Elle permet notamment d'annuler une réservation s'il n'est pas déja validé le controle de l'état se fait coté vue
     * 
     * @param void
     * @var $SiteReservationModel correspond au model de la réservation
     * @return string|object  
     * - string retourne la vue
     * - object redirige sur la Connexion et on demande à l'utilisateur de se connecter s'il ne l'est pas déja
     */
    public function index() {
        helper('form');
        
        Session::startSession();
        if(!Session::verifySession()){
            return redirect()->to(site_url('Connexion/deconnexion')); 
        }
        
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        if(!empty($this->request->getPost('idReservation'))){
            $SiteReservationModel->updateisValide($this->request->getPost('idReservation'), "Annulée");
        }
            echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
            echo view("form/pageuser",['tabReservation' => $SiteReservationModel->getLesReservationsByUser(Session::getSessionData('idUser'))]);
            echo view('template/footer');
    }
}

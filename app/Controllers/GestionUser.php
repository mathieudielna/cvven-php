<?php
namespace App\Controllers;
use \CodeIgniter\Controller;
use \App\Models\Session;

/**
 * Classe technique permettant de visualiser en admin
 *
 * @author Mathieu
 * @author Rémi
 * @author Martin
 */
class GestionUser extends Controller{
    /**
     * Vérifie l'utilisateur est connecté et qu'il a les permissions, puis on charge la vue
     * 
     * @param void
     * @return string|object
     * -string retourne la vue avec ou sans les erreurs
     * -object redirige sur la Connexion et on demande à l'utilisateur de se connecter s'il ne l'est pas déja
     */
    public function index() {
        helper('form');
        Session::startSession();
        if(!Session::verifySession() || Session::getSessionData('idUser') != 1){
            return redirect()->to(site_url('PageUser')); 
        }
        
        
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        if(!empty($this->request->getPost('idUtilisateur'))){
            $SiteReservationModel->deleteAllReservationByUser($this->request->getPost('idUtilisateur'));
            $SiteReservationModel->deleteUser($this->request->getPost('idUtilisateur'));
        }
        
        echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
        echo view("form/gestionuser",['tabUtilisateurs' => $SiteReservationModel->getLesUtilisateurs()]);
        echo view('template/footer');
    }
}

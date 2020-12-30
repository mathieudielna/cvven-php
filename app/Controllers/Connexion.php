<?php
namespace App\Controllers;
use \CodeIgniter\Controller;
use \App\Models\Session;
/**
 * Connexion : Classe Technique permettant de gérer la connexion
 */
class Connexion extends Controller{
    /**
     * Vérifie si les champs manquant du formulaire sont bien rempli
     * 
     * @param void
     * @return string|object  
     * - string retourne la vue avec les erreurs
     * - object redirige sur le controlleur hôme.
     */
    public function index() {
        helper('form');
        
        if (!$this->validate(['user' => 'required|min_length[4]|max_length[20]',
            'password' => 'required|min_length[4]|max_length[30]'],
        ['user' => ['required' => 'Merci d\'indiquer un login.', 'min_length' => 'Merci d\'indiquer un login d\'au moins 4 caractère', 
            'max_length' => 'La longueur du login ne peut pas dépasser 20 caractère'],
            'password' => ['required' => 'Merci d\'indiquer votre mot de passe','min_length' => 'Merci d\'indiquer un mot de passe d\'au moins 4 caractère', 
            'max_length' => 'La longueur du mot de passe ne peut pas dépasser 30 caractère']]))
        {
            echo view('template/header');
            echo view('form/login', ['validation' => $this->validator]);
            echo view('template/footer');
        }
        else
        {
            if($this->verifyLoginPassword()){
               return redirect()->to(site_url('Home')); 
            }
        }
    }
    
     /**
     * Vérifie si le login et le mot de passe correspondent 
     * 
     * @param void
     * @return string|object  
     * - string retourne la vue avec les erreurs
     * - object redirige sur le controlleur hôme.
     */
    private function verifyLoginPassword(){
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        if(intval($SiteReservationModel->countIdUserValide($this->request->getPost('user'), $this->request->getPost('password'))[0]['count']) != 1){
            if($SiteReservationModel->countUserLogin($this->request->getPost('user'))[0]['count'] != 1 ){
                $this->validator->setError("user", "Votre nom d'utilisateur n'éxiste pas !");
            }else{
                $this->validator->setError("password", "Le mot de passe est incorrect !");
            }
            echo view('template/header');
            echo view('form/login', ['validation' => $this->validator]);
            echo view('template/footer');
        }
        else{
            Session::initSession($SiteReservationModel->getIdUser($this->request->getPost('user'))[0]['id_user']);
            Session::setSessionData('nom', $SiteReservationModel->getNameUser($this->request->getPost('user'))[0]['nom']);
            return true; 
        }
    }
    
    /**
     * Déconnecte l'utilisateur et renvoie sur la page index
     * 
     * @param void
     * @return void
     */
    public function deconnexion() {
        Session::startSession();
        if(Session::verifySession()){
            Session::destructSession();
        }
        $this->index();
    }
   
}

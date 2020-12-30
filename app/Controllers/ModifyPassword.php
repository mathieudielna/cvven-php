<?php


namespace App\Controllers;
use CodeIgniter\Controller;
use \App\Models\Session;

/**
 * CreateUser Classe technique permettant de modifier son mot de passe
 *
 * @author Mathieu
 * @author Rémi
 * @author Louis
 */
class ModifyPassword extends Controller{
    /**
     * Vérifie si les champs manquant du formulaire sont bien rempli
     * 
     * @param void
     * @return string|object  
     * - string retourne la vue avec les erreurs
     * - object redirige sur la Connexion si l'utilisateur n'est pas connecté
     * - object redirige sur le controlleur verifyPassword si tout est bon
     */
    public function index() {
        helper('form');
        
        Session::startSession();
        if(!Session::verifySession()){
            return redirect()->to(site_url('Connexion/deconnexion')); 
        }
        
        if (!$this->validate(['password' => 'required|min_length[4]|max_length[20]', 'confirmPassword' => 'required|min_length[4]|max_length[30]'],
                        ['password' => ['required' => 'Merci d\'indiquer votre mot de passe.', 'min_length' => 'Merci d\'indiquer un mot de passe d\'au moins 4 caractère',
                                'max_length' => 'La longueur du mot de passe ne peut pas dépasser 20 caractère'],
                            'confirmPassword' => ['required' => 'Merci de confirmer votre mot de passe', 'min_length' => 'La confirmation du mot de passe doit avoir au moins 4 caractère',
                                'max_length' => 'La longueur du mot de passe ne peut pas dépasser 30 caractère']])) {
            echo view('template/header',['iduser' => Session::getSessionData('idUser')]);
            echo view('form/modifypassword', ['validation' => $this->validator]);
            echo view('template/footer');
        }
        else
        {
            if($this->verifPassword()){
                return redirect()->to(site_url('Connexion/deconnexion')); 
            }
        }
    }
    /**
     * Vérifie si les mot de passe sont équivalent et que l'utilisateur ne rentre pas son mot passe actuel
     * 
     * @param void
     * @return string|object  
     * - string retourne la vue avec les erreurs
     * - object redirige sur la Connexion et on demande à l'utilisateur de se connecter
     */
    private function verifPassword(){
        if($this->request->getPost('password') != $this->request->getPost('confirmPassword')){
            $this->validator->setError("password","vos mot de passe ne correspondent pas");
            echo view('template/header',['iduser' => Session::getSessionData('idUser')]);
            echo view('form/modifypassword', ['validation' => $this->validator]);
            echo view('template/footer');
            
            return false;
        }
        else{
            Session::startSession();
            $SiteReservationModel = new \App\Models\SiteReservationModel;
            if(intval($SiteReservationModel->countUserMdp(Session::getSessionData('idUser'), $this->request->getPost('password'))[0]['count']) != 0){
                $this->validator->setError("password", "Le mot de passe que vous avez entré est déja lié à vôtre compte !");
                echo view('template/header',['iduser' => Session::getSessionData('idUser')]);
                echo view('form/modifypassword', ['validation' => $this->validator]);
                echo view('template/footer');
                return false;
            }
            else{
                $SiteReservationModel->updateUserMdp(Session::getSessionData('idUser'), $this->request->getPost('password'));
                return true;
            }
        }
    }
}

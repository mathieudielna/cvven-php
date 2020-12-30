<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use \App\Models\Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Classe technique permettant de modifier un utilisateur
 * 
 * @author Mathieu
 */
class ModifyUser extends Controller {

    /**
     * Vérifie si l'utilisateur est connecté et qu'il a les permissions, et que les champs du formulaire sont bien rempli
     * 
     * @param void
     * @return string|object
     * -string retourne la vue avec ou sans les erreurs
     * -object redirige sur la Connexion et on demande à l'utilisateur de se connecter s'il ne l'est pas déja
     */
    public function index() {
        helper('form');
        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('idUser') != 1) {
            return redirect()->to(site_url('Connexion/deconnexion'));
        }

        $SiteReservationModel = new \App\Models\SiteReservationModel;
        if (!empty($this->request->getPost('idUtilisateur'))) {
            $SiteReservationModel = new \App\Models\SiteReservationModel;
            echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
            echo view("form/modifyuser", ['infoUser' => $SiteReservationModel->getInfoUser($this->request->getPost('idUtilisateur'))]);
            echo view('template/footer');
        } else if (!empty($this->request->getPost('idModifUser'))) {
            if ($this->updateUser()) {
                return redirect()->to(site_url('GestionUser'));
            }
        }
    }
    
    /**
     * Met à jour les données de l'utilisateur
     *  
     * @uses verifyFields Vérifie les champs
     * @return bool
     */
    private function updateUser(): bool {
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        $NewInfoUser = $this->verifyFields();
        $SiteReservationModel->updateInfoUser($this->request->getPost('idModifUser'), $NewInfoUser['nom'], $NewInfoUser['prenom'], $NewInfoUser['password']);
        return true;
    }
    
    /**
     * Vérifie si les champs sont remplis et si ils sont les mêmes
     * 
     * Lorsqu'un champs entré est différent de celui de la BDD il est remplacé.
     * 
     * @param void
     * @return array<String,mixed>   
     */
    private function verifyFields(): array {
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        $InfoUser = $SiteReservationModel->getInfoUSer($this->request->getPost('idModifUser'))[0];
        $newInfoUser = [];

        //nom 
        if (!empty($this->request->getPost('nom')) && $InfoUser['nom'] != $this->request->getPost('nom')) {
            $newInfoUser['nom'] = $this->request->getPost('nom');
        } else {
            $newInfoUser['nom'] = $InfoUser['nom'];
        }

        //prenom
        if (!empty($this->request->getPost('prenom')) && $InfoUser['prenom'] != $this->request->getPost('prenom')) {
            $newInfoUser['prenom'] = $this->request->getPost('prenom');
        } else {
            $newInfoUser['prenom'] = $InfoUser['prenom'];
        }

        //motDePasse
        if (!empty($this->request->getPost('password')) && $InfoUser['mdp'] != $this->request->getPost('password')) {
            $newInfoUser['password'] = $this->request->getPost('password');
        } else {
            $newInfoUser['password'] = $InfoUser['mdp'];
        }

        return $newInfoUser;
    }

}

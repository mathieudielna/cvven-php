<?php

namespace App\Controllers;

use \CodeIgniter\Controller;
use \App\Models\Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe technique permettant l'ajout d'un utilisateur
 */
class AddUserAdmin extends Controller {

    /**
     * Vérifie si l'utilisateur est connecté et qu'il est admin, et que les champs du formulaire sont bien rempli
     * 
     * @param void
     * @return string Si une erreur est détecté on retourne sur la vue et on affiche l'erreur. Sinon on appelle control
     */
    public function index() {
        helper('form');


        Session::startSession();
        if (!Session::verifySession() || Session::getSessionData('idUser') != 1) {
            return redirect()->to(site_url('PageUser'));
        }
        if (!$this->validate(['nom' => 'required|min_length[3]|max_length[60]',
                    'prenom' => 'required|min_length[3]|max_length[60]',
                    'user' => 'required|min_length[4]|max_length[20]',
                    'password' => 'required|min_length[4]|max_length[30]'],
                        ['nom' => ['required' => 'Merci d\'indiquer un nom.', 'min_length' => 'Merci d\'indiquer un nom d\'au moins 3 caractère',
                                'max_length' => 'La longueur du nom ne peut pas dépasser 60 caractère'],
                            'prenom' => ['required' => 'Merci d\'indiquer un prenom.', 'min_length' => 'Merci d\'indiquer un prenom d\'au moins 3 caractère',
                                'max_length' => 'La longueur du prenom ne peut pas dépasser 60 caractère'],
                            'user' => ['required' => 'Merci d\'indiquer un login.', 'min_length' => 'Merci d\'indiquer un login d\'au moins 4 caractère',
                                'max_length' => 'La longueur du login ne peut pas dépasser 20 caractère'],
                            'password' => ['required' => 'Merci d\'indiquer votre mot de passe', 'min_length' => 'Merci d\'indiquer un mot de passe d\'au moins 4 caractère',
                                'max_length' => 'La longueur du mot de passe ne peut pas dépasser 30 caractère']])) {
            echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
            echo view("form/admuser", ['validation' => $this->validator]);
            echo view('template/footer');
        } else {
            $this->verifyLoginExistAdmin();
        }
    }

    /**
     * Vérifie si le compte existe ou pas sinon ont crée le compte
     * 
     * @param void
     * @return string retourne la vue de connexion avec ou sans les erreur
     */
    private function verifyLoginExistAdmin() {
        $SiteReservationModel = new \App\Models\SiteReservationModel();
        if (intval($SiteReservationModel->countUserLogin($this->request->getPost('user'))[0]['count']) != 0) {
            $this->validator->setError("user", "Ce nom d'utilisateur existe déja");
            echo view('template/header',['iduser' => Session::getSessionData('idUser')]);
            echo view('form/admuser', ['validation' => $this->validator, 'connexion' => 'votre compte existe déja']);
            echo view('template/footer');
        } else {
            $SiteReservationModel->insertUser($this->request->getPost('nom'), $this->request->getPost('prenom'), $this->request->getPost('user'), $this->request->getPost('password'));
            echo view('template/header',['iduser' => Session::getSessionData('idUser')]);
            echo view('form/admuser', ['validation' => $this->validator, 'connexion' => 'Vous avez créer un compter utilisateur']);
            echo view('template/footer');
        }
    }

}

<?php

namespace App\Controllers;
use \CodeIgniter\Controller;
use \App\Models\Session;

/**
 * Classe technique permettant de modifier une réservation
 *
 * @author remi
 */
class ModifyReservation extends Controller{
    
    /**
     * Vérifie si l'utilisateur est connecté et qu'on a bien reçu un id
     * 
     * Nous avons trois cas possibles :
     * -Si l'utilisateur n'est pas connecté et qu'il n'est pas admin alors il est déconnecté et redirigé sur la vue Connexion
     * -Si l'admin a sélectionné l'action modifiée alors on l'affiche la vue modifyreservation
     * -Si l'admin a envoyé le formulaire et que tout est bon alors on le redirige sur GestionReservation sinon on lui affiche les erreurs sur la vue
     * -Sinon cela veut dire qu'aucune action et formulaire à été reçu alors on redirige sur GestionReservation
     * 
     * @var idReservationModif correspond à l'id de la réservation envoyé lorsque l'admin selectionne l'action modifiée
     * @var idUpdateReservation correspond à l'id de la réservation envoyé lorsque l'admin envoie le formulaire de modification
     * @param void
     * @return string|object  
     * - string retourne la vue du formulaire de modification avec ou sans erreur
     * - object redirige sur la Connexion et on demande à l'utilisateur de se connecter s'il ne l'est pas déja
     * - object redirige sur GestionReservation si aucun id de la réservation n'est reçu
     */
    public function index() {
        helper('form');
        Session::startSession();
        if(!Session::verifySession() || Session::getSessionData('idUser') != 1){
            return redirect()->to(site_url('Connexion/deconnexion')); 
        }
        
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        //Modifie la réservation
        if(!empty($this->request->getPost('idReservationModif'))){
            echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
            echo view("form/modifyreservation",['tabInfoReservation' => $SiteReservationModel->getUneReservationById($this->request->getPost('idReservationModif'))[0],
                'tabQueryTypeLogement' => $SiteReservationModel->getTypeLogement()]);
            echo view('template/footer');
        }
        else if(!empty($this->request->getPost('idUpdateReservation'))){
            if($this->verifFieldModif()){
                return redirect()->to(site_url('GestionReservation'));
            }
            else{
               echo view('template/header', ['iduser' => Session::getSessionData('idUser')]);
               echo view("form/modifyreservation",['tabInfoReservation' => $SiteReservationModel->getUneReservationById($this->request->getPost('idUpdateReservation'))[0],
                'tabQueryTypeLogement' => $SiteReservationModel->getTypeLogement(), 'validation' => $this->validator]);
               echo view('template/footer'); 
            }    
        }
        else{
            return redirect()->to(site_url('GestionReservation')); 
        }  
    }
    
    /**
     * Vérifie les éventuels erreurs lors de la création de l'objet(Durée de date incorrecte ou/et nombre de personne incorrecte)
     * 
     * Dans tous les cas on met à jour la BDD que sa soit avec les ancienne ou les nouvelles données
     * 
     * @param void
     * @return bool
     * -true si aucune erreur est rencontré
     * -false si une données est incorrecte
     */
    private function verifFieldModif() : bool{
        $InfoReservation = $this->verifFieldIsSame();
        $leControlSiteReservation = new \App\Models\ControlSiteReservationModel($InfoReservation['datedebut'], $InfoReservation['datefin'], $InfoReservation['nbpersonne'],
                $InfoReservation['typelogement'],
                $InfoReservation['pension'],
                $InfoReservation['menage']);
        $SiteReservationModel = new \App\Models\SiteReservationModel();
        
        if ($leControlSiteReservation->Erreur()) {
            $this->validate([]);
            $tabException = $leControlSiteReservation->getException();
            foreach ($tabException as $Exception) {
                foreach ($Exception as $errorField => $errorValue) {
                    $this->validator->setError($errorField, $errorValue);
                }
            }
            $SiteReservationModel->updateReservation($this->request->getPost('idUpdateReservation'), $InfoReservation['datedebut'], $InfoReservation['datefin'], 
                $InfoReservation['nbpersonne'], $InfoReservation['pension'], $InfoReservation['menage'], $InfoReservation['typelogement']);
            unset($leControlSiteReservation);
            return false;
        } else {
            $SiteReservationModel->updateReservation($this->request->getPost('idUpdateReservation'), $InfoReservation['datedebut'], $InfoReservation['datefin'], 
                $InfoReservation['nbpersonne'], $InfoReservation['pension'], $InfoReservation['menage'], $InfoReservation['typelogement']);
            unset($leControlSiteReservation);
            return true;
        }
    }
    
    /**
     * Vérifie si les champs sont remplis et si ils sont les mêmes
     * 
     * Lorsqu'un champs entré est différent de celui de la BDD il est remplacé.
     * 
     * @param void
     * @return array<String,mixed>   
     */
    private function verifFieldIsSame() : array{
        $SiteReservationModel = new \App\Models\SiteReservationModel;
        $InfoReservation = $SiteReservationModel->getUneReservationById($this->request->getPost('idUpdateReservation'))[0];
        $newInfoReservation = [];
        
        //Date debut
        if(!empty($this->request->getPost('datedebut')) && $InfoReservation['datedebut'] != $this->request->getPost('datedebut')){
            $newInfoReservation['datedebut'] = $this->request->getPost('datedebut');
        }
        else{
            $newInfoReservation['datedebut'] = $InfoReservation['datedebut'];
        }
        
        //Date Fin
        if(!empty($this->request->getPost('datefin')) && $InfoReservation['datefin'] != $this->request->getPost('datefin')){
            $newInfoReservation['datefin'] = $this->request->getPost('datefin');
        }
        else{
            $newInfoReservation['datefin'] = $InfoReservation['datefin'];
        }
        
        //nbPersonne
        if(!empty($this->request->getPost('nbpersonne')) && $InfoReservation['nbpersonne'] != $this->request->getPost('nbpersonne')){
           $newInfoReservation['nbpersonne'] = $this->request->getPost('nbpersonne'); 
        }
        else{
            $newInfoReservation['nbpersonne'] = $InfoReservation['nbpersonne'];
        }
        
        //typelogement
        if(!empty($this->request->getPost('typelogement')) && $InfoReservation['typelogement'] != $this->request->getPost('typelogement')){
           $newInfoReservation['typelogement'] = $this->request->getPost('typelogement'); 
        }
        else{
            $newInfoReservation['typelogement'] = $InfoReservation['typelogement'];
        }
        
        //Pension
        if(!empty($this->request->getPost('pension')) && $InfoReservation['pension'] != $this->request->getPost('pension')){
           $newInfoReservation['pension'] = $this->request->getPost('pension'); 
        }
        else{
            $newInfoReservation['pension'] = $InfoReservation['pension'];
        }
        
        //Menage
        if(!empty($this->request->getPost('menage')) && $InfoReservation['menage'] != $this->request->getPost('menage')){
           $newInfoReservation['menage'] = $this->request->getPost('menage'); 
        }
        else{
            $newInfoReservation['menage'] = $InfoReservation['menage'];
        }
        
        return $newInfoReservation;
    }
}

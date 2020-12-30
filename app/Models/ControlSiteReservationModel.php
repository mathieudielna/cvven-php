<?php
namespace App\Models;
use Date;
use App\Models\SiteReservationModel;

/**
 * Classe métier permettant le controle des données relatifs à la BDD
 * 
 *@author Rémi  
 */
class ControlSiteReservationModel{

    private $dateDebut;
    private $dateFin;
    private $nbPersonne;
    private $typeLogement;
    private $pension;
    private $option;
    /**
     *Contient toutes les erreurs 
     *  
     * @var array
     */
    private $exception;

    /**
     * Instancie un objet ControlSiteReservationModel
     * 
     * @uses Date
     * @param Date $datedebut
     * @param Date $datefin
     * @param int $nbPersonne
     * @param string $typeLogement
     * @param string $pension
     * @param bool $option
     * @return void
     */
    public function __construct($datedebut, $datefin, $nbPersonne, $typeLogement, $pension, $option){
        $this->dateDebut = new Date($datedebut);
        $this->dateFin = new Date($datefin);
        $this->nbPersonne = $nbPersonne;
        $this->typeLogement = $typeLogement;
        $this->pension = $pension;
        if(empty($option)){
            $this->option = false;
        }
        else{
            $this->option = true;
        }

    }
    
    /**
     * Retourne la date de début de séjour
     * 
     * @uses Date
     * @param void
     * @return Date $dateDebut
     */
    public function getDateDebut(){
        return $this->dateDebut;
    }
    
    /**
     * Retourne la date de fin de séjour
     * 
     * @uses Date
     * @param void
     * @return Date dateFin
     */
    public function getDateFin(){
        return $this->dateFin;
    }
    
    /**
     * Retourne le nombre de personne
     * 
     * @param void
     * @return int nbPersonne
     */
    public function getNbPersonne(){
        return $this->nbPersonne;
    }
    
    /**
     * Retourne le type de logement
     * 
     * @param void
     * @return string $typeLogement
     */
    public function getTypeLogement(){
        return $this->typeLogement;
    }
    
    /**
     * Retourne la pension
     * 
     * @param void
     * @return string $pension
     */
    public function getPension(){
        return $this->pension;
    }
    
    /**
     * Retourne l'option
     * 
     * @param void
     * @return bool $option
     */
    public function getOption(){
        return $this->option;
    }
    
    /**
     * Retourne les erreurs
     * 
     * @param void
     * @return array $exception
     */
    public function getException(){
        return $this->exception;
    }

    /**
     * Génère et ajoute des erreur à au tableau d'exception
     * 
     * Controle si la durée du séjour est strictement égale à 7 jours et que la capacité n'est pas supérieur à la capacité calculé dans la BDD
     * 
     * @param void
     * @return bool $erreur
     */
    public function Erreur() : bool{
        $erreur = false;
        if(!$this->controlDuree($this->getDateDebut(), $this->getDateFin())){
            $this->addException(array("datedebut" => "La durée du séjour est incorrecte!")); 
            $erreur = true;
        }
        if(!$this->controlCapacite()){
            $this->addException(array("nbpersonne" => "Le nombre de personnes n'est pas correcte par rapport à la capacité!"));   
            $erreur = true; 
        }
        return $erreur;
    }

    /**
     * Ajoute une exception
     * 
     * @param array<int,string> $tab
     * @return void
     */
    public function addException(array $tab) : void {
        $this->exception[] = $tab;
    }

    /**
     * Controle si le nombre de personne est inférieur à la capacité des chambres
     * 
     * @param void
     * @return bool retourne si la capacité est correcte
     */
    public function controlCapacite() : bool{
        $siteReservationModel = new SiteReservationModel();
        if($siteReservationModel->getNbLitDouble($this->getTypeLogement())[0]['nblitdouble'] != 0 || 
            $siteReservationModel->getNbLitSimple($this->getTypeLogement())[0]['nblitsimple'] != 0){
            if($this->getNbPersonne() <= intval($siteReservationModel->getNbLitDouble($this->getTypeLogement())[0]['nblitdouble'])*2){
                unset($siteReservationModel);
                return true;
            }
            elseif($this->getNbPersonne() <= intval($siteReservationModel->getNbLitSimple($this->getTypeLogement())[0]['nblitsimple'])){
                unset($siteReservationModel);
                return true;
            }
            else{
                unset($siteReservationModel);
                return false;
            }
        }
        else{
                unset($siteReservationModel);
                return false;
        }
        }
    
     /**
     * Controle la durée du séjour s'il est égale à 7 jours
     * 
     * @param void
     * @return bool retourne si la duré du sejour est correcte
     */
    public function controlDuree() : bool{
        if($this->getDateFin()->getDay() - $this->getDateDebut()->getDay()  == 7){
            return true;
        }
        else{
            return false;
        }
    } 

    /**
     * Créer une réservation et détruit le modèle
     * 
     * @param int $id_user id de l'utilisateur connecté
     * @return void
     */
    public function insertUneReservation($id_user) : void{
        $siteReservationModel = new SiteReservationModel();
        $siteReservationModel->insertReservation($this->getTypeLogement(), $id_user, $this->getDateDebut()->getDate(), $this->getDateFin()->getDate(), $this->getNbPersonne(), $this->getPension(), $this->getOption());
        unset($siteReservationModel);
    }
}
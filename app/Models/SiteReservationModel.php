<?php

namespace App\Models;
use CodeIgniter\Model;

/**
 * Classe héritière de Model permettant de récuper les données de la base de données
 * 
 * @author dasilvaremi
 */
class SiteReservationModel extends Model{

    /**
     * Constructeur par défault
     * 
     * @param pointer $db Valeur par défault = null; Permet de choisir sur qu'elle interface de la BDD on se connecte
     * @param object $validation Valeur par défault = null;
     * @return void
     */
    public function __construct(\CodeIgniter\Database\ConnectionInterface &$db = null, \CodeIgniter\Validation\ValidationInterface $validation = null) {
        parent::__construct($db, $validation);
        $this->db->connect('default');
    }

    /*--------------------------------------Table typelogement------------------------------------------------*/

    /**
     * retourne la colonne typelogement de la table typelogement
     * 
     * @param string $typelogement
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getTypeLogement($typelogement = ""){
        if(empty($typelogement)){
            return  $this->db->query("SELECT typelogement FROM public.typelogement;")->getResultArray();
        }
        else{
            return $this->db->query("SELECT typelogement FROM public.typelogement WHERE typelogement = :typelogement: LIMIT 1;",
                    ["typelogement" => $typelogement])->getResultArray();
        }
    }

    /**
     * retourne la colonne typelogement de la table typelogement
     * 
     * @param string $typelogement
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getNbLitDouble($typelogement){
        return $this->db->query("SELECT nblitdouble FROM public.typelogement WHERE typelogement = :typelogement: ORDER BY typelogement DESC;"
                ,["typelogement" => $typelogement])->getResultArray();
    }

    /**
     * retourne le nombre de lits simples
     * 
     * @param string $typelogement
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getNbLitSimple($typelogement){
        return  $this->db->query("SELECT nblitsimple FROM public.typelogement WHERE typelogement = :typelogement: ORDER BY typelogement DESC;"
                ,["typelogement" => $typelogement])->getResultArray();
    }
    
    /*--------------------------------------Table réservation------------------------------------------------*/
     /**
     * retourne l'id de la réservation
     * 
     * @param void
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getIdReservation(){
        return $this->db->query("SELECT id_reservation FROM public.reservation;")->getResultArray();
    }

    /**
     * retourne la date de début
     * 
     * @param void
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getDateDebut() {
        return $this->db->query("SELECT datedebut FROM public.reservation;")->getResultArray();
    }
    
    /**
     * retourne le nombre de personne pour une réservation
     * 
     * @param void
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getNbPersonne() {
        return $this->db->query("SELECT nbpersonne FROM public.reservation;")->getResultArray();
    }
    
    /**
     * retourne la validité d'une réservation
     * 
     * @param void
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getValide() {
        return $this->db->query("SELECT valide FROM public.reservation;")->getResultArray();
    }
    
    /**
     * retourne l'id de l'utilisateur
     * 
     * @param void
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getIdUser_Reservation() {
        return $this->db->query("SELECT id_user FROM public.reservation;")->getResultArray();
    }
    
    /**
     * retourne toutes les reservations de tous les utilisateurs
     * 
     * @param void
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getLesReservations(){
        return $this->db->query("SELECT id_reservation, datedebut, nbpersonne, (SELECT nom FROM user), pension, valide FROM public.reservation INNER JOIN public.user ON "
                . "public.reservation.id_user = public.user.id_user ORDER BY valide;")->getResultArray();
    }
    
    /**
     * Retourne toutes les réservations d'un utilisateur
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getLesReservationsByUser($id_user){
        return $this->db->query("SELECT id_reservation, datedebut, nbpersonne, (SELECT nom FROM user), pension, valide FROM public.reservation INNER JOIN public.user ON "
                . "public.reservation.id_user = public.user.id_user WHERE public.reservation.id_user = :id_user: ORDER BY valide;",['id_user' => $id_user])->getResultArray();
    }
    
    /**
     * Retourne toutes les réservations d'un utilisateur
     * 
     * @param int $id_reservation UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getUneReservationById($id_reservation){
        return $this->db->query("SELECT id_reservation, datedebut, datefin, nbpersonne, nbpersonne, pension, menage, typelogement FROM public.reservation "
                . "INNER JOIN public.user ON public.reservation.id_user = public.user.id_user "
                . "WHERE public.reservation.id_reservation = :id_reservation: ORDER BY valide;",['id_reservation' => $id_reservation])->getResultArray();
    }
    
    /**
     * Modifie le champs valide lorsque l'admin à accepté une réservation
     * 
     * @param int $id_reservation PRIMARY KEY; Correspond à l'id de la réservation
     * @param string $valide
     * @return void
     */
    public function updateisValide($id_reservation, $valide = "Valide") : void{
        $this->db->query("UPDATE public.reservation SET valide = :valide: WHERE id_reservation = :id_reservation:;",["valide" => $valide, "id_reservation" => $id_reservation]);
    }
    
    /**
     * Modifie les informations utilisateurs
     * 
     * @param int $id_reservation UNIQUE KEY; Correspond à l'id de la réservation
     * @param string $dateDebut Date en format YYYY-MM-DD 
     * @param string $dateFin Date en format YYYY-MM-DD 
     * @param int $nbpersonne
     * @param string $pension Correspond au type de pension
     * @param bool $menage Correspond à option
     * @param string $typelogement UNIQUE KEY; type du logement
     * @return void
     */
    public function updateReservation($id_reservation, $dateDebut, $dateFin, $nbpersonne, $pension, $menage, $typelogement){
        $this->db->query("UPDATE public.reservation SET datedebut = :datedebut:, datefin = :datefin:, nbpersonne = :nbpersonne:, pension = :pension:, menage = :menage:, "
                . "valide = :valide:, typelogement = :typelogement: WHERE id_reservation = :id_reservation:;",['id_reservation' => $id_reservation, 
                    'datedebut'=>$dateDebut, 'datefin'=>$dateFin, 'nbpersonne'=>$nbpersonne, 'pension'=>$pension, 'menage'=>$menage, 'typelogement'=>$typelogement,
                    'valide' => 'Modifiée']);
    }
    
    /**
     * insère des données dans la table réservation  
     * 
     * @param string $typelogement
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @param string dateDebut Date en format YYYY-MM-DD 
     * @param string dateFin Date en format YYYY-MM-DD 
     * @param int nbPersonne
     * @param string $pension Correspond au type de pension
     * @param string $menage Correspond à option
     * @return void
     */
    public function insertReservation($typelogement, $id_user,$dateDebut, $dateFin, $nbPersonne, $pension, $menage) : void{
        $this->db->query("INSERT INTO public.reservation (datedebut, datefin, nbpersonne, pension, menage, valide, id_user, num_logement, typelogement) "
                . "VALUES(:datedebut:, :datefin:, :nbpersonne:, :pension:, :menage: , :valide:, :id_user:, "
                . "(SELECT num_logement FROM logement WHERE typelogement = :typelogement:), :typelogement:);",
                ["datedebut" => $dateDebut, "datefin" => $dateFin, "nbpersonne" => $nbPersonne, "pension" => $pension, "menage" => $menage, "valide" => "En attente de validation",
                    "id_user" => $id_user, "typelogement" => $typelogement,]);
    }
    

    /**
     * Supprimer une reservation
     * 
     * @param int $id_reservation PRIMARY KEY; Correspond à l'id de la réservation
     * @return void
     */
    public function deleteReservation($id_reservation){
        $this->db->query("DELETE FROM public.reservation WHERE id_reservation=:id_reservation:;",["id_reservation" => $id_reservation]);
    }
    
    /**
     * Supprimer toutes les réservation d'un utilisateur
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @return void
     */
    public function deleteAllReservationByUser($id_user){
        $this->db->query("DELETE FROM public.reservation WHERE id_user=:id_user:;",["id_user" => $id_user]);
    }
    
    /*------------------------------------Table user---------------------------------------------------------*/
   
     /**
     * Retourne l'id de l'utilisateur
     * 
     * @param string $login UNIQUE KEY : Correspond au login
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getIdUser($login) {
        return $this->db->query("SELECT id_user FROM public.user WHERE login = :login:;",["login" => $login])->getResultArray();
    }
    
    /**
     * Retourne tous les utilisateurs sauf l'administrateur
     * 
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function getLesUtilisateurs(){
        return $this->db->query("SELECT id_user, nom, prenom, login FROM public.user WHERE id_user != 1;")->getResultArray();
    }
   
     /**
     * recupère les informations de l'utlisateurs
     * 
     *Recupere les infos utilisateurs par rapport a son id
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @return array<int,array<string,int>> contient les résultat de la requête
     */
    public function getInfoUser($id_user){
        return $this->db->query("SELECT nom,prenom,mdp, id_user FROM public.user WHERE id_user=:id_user:",["id_user"=> $id_user])->getResultArray();
    }
    
    /**
     * Retourne le nom de l'utilisateur
     * 
     * Au moins un des deux paramètre doit être non null
     * 
     * @param string $login UNIQUE KEY; Correspond au login
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @return array<int,array<string,int>>|bool
     * -array<int,array<string,int>> contient les résultat de la requête
     * -false si les deux paramètres sont vides
     */
    public function getNameUser($login = null, $id_user = null){
        if(!empty($id_user)){
            return $this->db->query('SELECT nom FROM public.user WHERE id_user = :id_user:;',['id_user' => $id_user])->getResultArray();
        }
        elseif(!empty($login)) {
            return $this->db->query('SELECT nom FROM public.user WHERE id_user = :id_user:;',['id_user' => $this->getIdUser($login)[0]['id_user']])->getResultArray();
        }
        else{
            return false;
        }
    }
    
     /**
     * Retourne le nombre de mot de passe
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @param string $mdp Correspond au mot de passe
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function countUserMdp($id_user, $mdp){
        return $this->db->query('SELECT COUNT(mdp) FROM public.user WHERE id_user = :id_user: AND mdp = :mdp:;',['id_user' => $id_user, 'mdp' => $mdp])->getResultArray();
    }

    /**
     * Retourne le nombre d'user
     * 
     * @param string $login Valeur UNIQUE KEY; Correspond au login
     * @return array<int,array<string,value>> contient les résultat de la requête
     */
    public function countUserLogin($login){
        return $this->db->query("SELECT COUNT(login) FROM public.user WHERE login = :login:;",['login' => $login])->getResultArray();
    }
    
    /**
     * Compte s'il y a bien qu'un user qui existe avec ce mot de passe et ce login
     * 
     * @param string $login UNIQUE KEY; Correspond au login
     * @param string $mdp Correspond au mot de passe
     * @return array<int,array<string,string|int>> contient les résultat de la requête
     */
    public function countIdUserValide($login, $mdp){
        return $this->db->query("SELECT COUNT(id_user) FROM public.user WHERE login = :login: AND mdp = :mdp:;",['login' => $login, 'mdp' => $mdp])->getResultArray();
    }
    
    /**
     * Insert un user
     * 
     * @param string $nom
     * @param string $prenom
     * @param string $login UNIQUE KEY; Correspond au login
     * @param string $mdp Correspond au mot de passe
     * @return void
     */
    public function insertUser($nom, $prenom, $login, $mdp) {
        $this->db->query('INSERT INTO public.user(nom, prenom, login, mdp) VALUES(:nom:, :prenom:, :login:, :mdp:);',['nom' => $nom, 'prenom' => $prenom, 'login' => $login, 'mdp' => $mdp]);
    }

    /**
     * Modifie le mot de passe
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @param string $mdp Correspond au mot de passe
     * @return void
     */
    public function updateUserMdp($id_user, $mdp){
        $this->db->query('UPDATE public.user SET mdp = :mdp: WHERE id_user = :id_user:;',['mdp' => $mdp, 'id_user' => $id_user]);
    }
    
    /**
     * Modifie les informations utilisateurs
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @param string $nom Nom de l'utilisateur
     * @param string $prenom Prénom de l'utilisateur
     * @param string $mdp Mot de passe de l'utilisateur
     * @return void
     */
    public function updateInfoUser($id_user,$nom,$prenom,$mdp){
        $this->db->query('UPDATE public.user SET nom=:nom:, prenom=:prenom:,  mdp=:mdp: WHERE id_user=:id_user:;',['id_user' => $id_user,'nom'=>$nom,'prenom'=>$prenom,'mdp'=>$mdp]);
    }
    
     /**
     * Supprime un utilisateur
     * 
     * @param int $id_user UNIQUE KEY; Correspond à l'id de l'utilisateur
     * @return void
     */
    public function deleteUser($id_user){
        $this->db->query('DELETE FROM public.user WHERE id_user=:id_user:;',['id_user' => $id_user]);
    } 
    
}

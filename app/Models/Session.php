<?php

namespace App\Models;

/**
 * Classe technique permettant de gérer les sessions
 *
 */
abstract class Session {
    
    private static $session;
    /**
     * Démarre une session
     * 
     * @param void
     * @return void
     * @var $session contient la variable session
     */
    public static function startSession(){
        Session::$session = \Config\Services::session();
    }
   
    /**
     * Initialise une session avec des paramètre par défault
     * 
     * @param int $idUser Id de l'utilisateur
     * @return void
     */
    public static function initSession($idUser) {
        Session::startSession();
        Session::setSessionData("idUser", $idUser);
    }
    
    /**
     * Détruit la session
     * 
     * @param void
     * @return void
     */
    public static function destructSession() {
        Session::$session->destroy();
    }

    /**
     * Détruit la session
     * 
     * @param void
     * @return bool Correspond à l'état de vérification
     * -false la session n'éxiste pas ou n'as pas d'idUser
     * -true la session est bonne
     */
    public static function verifySession() : bool{
        if(!isset(Session::$session)){
            return false;
        }
        elseif(Session::getSessionData('idUser') === NULL){
            Session::destructSession();
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Récupère une donnée de Session
     * 
     * @param string $idChamp correspond à l'index du tableau de la session
     * @return mixed renvoie la valeur du champs de la session 
     */
    public static function getSessionData($idChamp = ''){
        return Session::$session->get($idChamp);
    }
      
    /**
     * Ajoute une donnée de Session
     * 
     * @param string $idChamp correspond à l'index du tableau de la session
     * @param mixed $value correspond à la valeur du champs
     * @return bool|void
     * -false à rencontré une erreur
     */
    public static function setSessionData($idChamp, $value = ""){
        if(is_array($idChamp)){
            Session::$session->set($idChamp);
        }
        elseif(!empty ($value)){
            Session::$session->set($idChamp, $value);
        }
        else{
            return false;
        }

    }
    
    /**
     * Supprime un champs
     * 
     * @param string $idChamp correspond à l'index du tableau de la session
     * @return bool|void 
     * -false indique qu'il y'a eu une erreur
     */
    public static function removeSessionData($idChamp){
        if(!Session::hasSessionData($idChamp)){
            Session::$session-->remove($idChamp);
        }
        else{
            return false;
        }
    }
}

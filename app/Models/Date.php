<?php 
/**
 * Class métier techniques gérant les dates
 */
class Date {

    private $date;
    private $formatDate;
    /**
     * Instancie une date
     * 
     * @param string $date Date envoyée
     * @var string $formatDate
     * @uses Date::changeDateFormat()
     * @return void
     */
    public function __construct($date){
        $this->date = $date;
        $this->formatDate = "YYYY-MM-DD";
        $this->changeDateFormat(); 
    }

    /**
     * Retourne la date
     * 
     * @param void
     * @return string $date
     */
    public function getDate(){
        return $this->date;
    }

    /**
     * Retourne le format de la date
     * 
     * @param void
     * @return string $formatDate
     */
    public function getFormatDate(){
        return $this->formatDate;
    }

    /**
     * Retourne l'année
     * 
     * @param void
     * @uses cutDate
     * @return string 4 caractère
     */
    public function getYear(){
        return $this->cutDate("YYYY");
    }
    
    /**
     * Retourne le jour
     * 
     * @param void
     * @uses cutDate
     * @return string 2 caractère
     */
    public function getDay(){
        return $this->cutDate("DD");
    }

    /**
     * Retourne le mois
     * 
     * @param void
     * @uses cutDate
     * @return string 2 caractère
     */
    public function getMonth(){
        return $this->cutDate("MM");
    }

    /**
     * Retourne la date séparé dans un tableau
     * 
     * @param void
     * @uses Date::explodeValue
     * @return array
     */
    public function getTabDate(){
        return Date::explodeValue($this->getDate());
    }

    /**
     * Retourne le format de la date séparé dans un tableau
     * 
     * @param void
     * @uses Date::explodeValue
     * @return array
     */
    public function getTabFormatDate(){
        return Date::explodeValue($this->getFormatDate());
    }

    /**
     * Modifie la date
     * 
     * @param string $date
     * @return void
     */
    public function setDate($date){
        $this->date = $date;
    }

    /**
     * Modifie le format de la date
     * 
     * @param string $formatDate
     * @return void
     */
    public function setFormatDate($formatDate){
        $this->formatDate = $formatDate;
    }

     /**
     * Change le format de la date
     *
     * @uses explodeValue permet de couper le format en trableau
     * @uses getTabDate permet de récupérer la date sous forme de tableau
     * @uses getTabFormatDate permet de récupérer le format sous forme de tableau
     * @uses setFormatDate
     * @uses setDate
     * @param string|void $formatDate valeur par défault = "YYYY-MM-DD" 
     * @return void
     */
    public function changeDateFormat($formatDate = "YYYY-MM-DD"){
        $formatDate = strtoupper($formatDate);
        $tabFormatDateTemp = Date::explodeValue($formatDate);

        $tabDate = $this->getTabDate();
        $tabFormatDate = $this->getTabFormatDate();

        $newDate = [];

        for($j = 0; $j < count($tabFormatDateTemp); $j++){
            if($tabFormatDateTemp[$j] == $tabFormatDate[$j]){
                $newDate[] = $tabDate[$j];
            }
        }

        $this->setFormatDate($formatDate);
        $this->setDate($newDate[0]."-".$newDate[1]."-".$newDate[2]);
    }
    
    /**
     * Permet de séparer la partie de la date que l'on souhaite(Jour,Mois ou Année)
     * 
     * @param string $indexFormatDate désigne quelle partie on veut couper de la date
     * @uses getTabDate
     * @uses getTabFormatDate
     * @return string|bool
     * -false s'il ne trouve pas le champs envoyé en paramètre par rapport au format de la date
     * -string retourne la partie de la date que l'on à choisis
     */
    private function cutDate($indexFormatDate){
        for ($i=0; $i < count($this->getTabDate()); $i++) { 
            for($j = 0; $j < count($this->getTabFormatDate()); $j++){
                if($this->getTabFormatDate()[$j] == $indexFormatDate){
                    return $this->getTabDate()[$j];
                }
            }
        }
        return false;
    }

    /**
     * Permet de séparer une chaine de caractère séparé par un séparateur
     * 
     * @param string $value champ text avec des séparateur
     * @param char|string $separateur valeur par défault = ""; correspond au séparateur
     * @return array|bool
     * -false s'il ne trouve pas le séparateur envoyé
     * -array retourne le champs sépraré sous forme de tableau
     */
    public static function explodeValue($value,$separateur = ""){
        if(!empty($separateur)){
            if(strpos($value, $separateur)){
                return explode($separateur, $value);
            }
            else{
                return false;
            }
        }
        else{
            if(strpos($value, "-")){
                return explode("-", $value);
            }
            elseif(strpos($value, "/")){
                return explode("/", $value);
            }
            else{
                return false;
            }
        } 
        
    }
}

?>
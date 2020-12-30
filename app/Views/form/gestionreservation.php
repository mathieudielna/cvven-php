<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
<?= form_open('GestionReservation'); ?>
    <head>
        <title>Gestion de réservations</title>
    </head>
    <body>

        <div class="container">
            <div class="row">
                
                <H1>Gestion de réservations</H1>
            </div>
            <div class="row">
                <table class="table">
                    <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Date début</th>
                    <th scope="col">Nombre de personnes</th>
                    <th scope="col">Pension</th>
                    <th scope="col">Etat de la réservation</th>
                    <th scope="col">Actions</th>
                    </tr>
                    
                    <?php
                    if(isset($tabReservation)){
                        foreach ($tabReservation as $LesReservations) {
                            echo "<tr scope='row'>";
                            echo "<td>".$LesReservations['nom']."</td>";
                            echo "<td>".$LesReservations['datedebut']."</td>";                        
                            echo "<td>".$LesReservations['nbpersonne']."</td>";
                            echo "<td>".$LesReservations['pension']."</td>";
                            echo "<td>".$LesReservations['valide']."</td>";
                            echo '<td><div class="row">';
                            
                            /*---------------Validation----------*/
                            //Si la réservation est en attente ou modifiée on peut alors la validée
                            if($LesReservations['valide'] == "En attente de validation" || $LesReservations['valide'] == "Modifiée"){
                                echo form_open('GestionReservation');
                                echo '<input name="idReservationValide" type="hidden" value="'.$LesReservations['id_reservation'].'"/>'; 
                                echo form_button(array('name'=>'valider','type'=>'submit','class'=>'btn', 'content'=>'<i class="fa fa-check-circle fa-lg text-success"></i>'));
                                echo '</form>';
                            }
                            
                            /*---------------Refus----------*/
                            //Si la réservation est en attente ou modifiée on peut alors la validée
                            if($LesReservations['valide'] == "En attente de validation" || $LesReservations['valide'] == "Modifiée"){
                                echo form_open('GestionReservation');
                                echo '<input name="idReservationRefus" type="hidden" value="'.$LesReservations['id_reservation'].'"/>'; 
                                echo form_button(array('name'=>'refuser','type'=>'submit','class'=>'btn', 'content'=>'<i class="fa fa-times-circle fa-lg text-danger"></i>'));
                                echo '</form>';
                            }
                           
                            /*---------------Modification----------*/
                            //Si la réservation est en attente ou modifiée on peut alors la modifiée
                            if($LesReservations['valide'] == "En attente de validation" || $LesReservations['valide'] == "Modifiée"){
                                echo form_open('ModifyReservation');
                                echo '<input name="idReservationModif" type="hidden" value="'.$LesReservations['id_reservation'].'"/>';
                                echo form_button(array('name'=>'modifier','type'=>'submit','class'=>'btn', 'content'=>'<i class="fa fa-pencil-square-o fa-lg text-warning"></i>'));
                                echo '</form>';
                            }
                            
                            /*---------------Supprimer----------*/
                            //Si la réservation n'est pas valide alors on peut la supprimée
                            if($LesReservations['valide'] != "Validée"){
                                echo form_open('GestionReservation');
                                echo '<input name="idReservationSuppr" type="hidden" value="'.$LesReservations['id_reservation'].'"/>';
                                echo form_button(array('name'=>'supprimer','type'=>'submit','class'=>'btn', 'content'=>'<i class="fa fa-trash fa-lg text-danger"></i>'));
                                echo '</form>';
                                
                            }
                            echo '</div></td>';
                            echo "</tr>";   
                        }  
                    }
                    else {
                        echo 'Erreur : Champs Vide !!!';
                    }
                ?>     
                </table>
            </div>
    </body>
</html>

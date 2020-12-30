<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Gestion de réservations</title>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <h1>Gestion de réservations</h1>
            </div>
            <div class="row">
                <table class="table table-bordered table-hover"">
                    <tr class="thead-light">
                    <th scope="col">Nom</th>
                    <th scope="col">Date début</th>
                    <th scope="col">Nombre de personnes</th>
                    <th scope="col">Pension</th>
                    <th scope="col">Etat de la réservation</th>
                    <th scope="col">Annuler</th>
                    </tr>
                    <?php
                    if(isset($tabReservation)){
                        foreach ($tabReservation as $LesReservations) {
                            echo "<tr scope='row'>";
                            //echo "<td><input type='hidden' name='idReservation' value='".$LesReservations['id_reservation']."'/></td>";
                            echo "<td>".$LesReservations['nom']."</td>";
                            echo "<td>".$LesReservations['datedebut']."</td>";                        
                            echo "<td>".$LesReservations['nbpersonne']."</td>";
                            echo "<td>".$LesReservations['pension']."</td>";
                            echo "<td>".$LesReservations['valide']."</td>";
                            echo "<td>";
                            echo "";
                            //echo form_button(array('name'=>'modifier','type'=>'submit','class'=>'btn btn-warning', 'content'=>'<i class="fa fa-pencil-square-o"></i>'));
                            if($LesReservations['valide'] == "En attente de validation" || $LesReservations['valide'] == "Modifiée"){
                                echo form_open('PageUser');
                                echo '<input name="idReservation" type="hidden" value="'.$LesReservations['id_reservation'].'"/>'; 
                                echo form_button(array('name'=>'supprimer','type'=>'submit','class'=>'btn', 'content'=>'<i class="fa fa-times-circle fa-lg text-danger"></i>')); 
                                echo "</form>";
                            }
                            else{
                                echo 'Annulation impossible ';
                                echo '<i class="fa fa-exclamation-circle text-danger"></i>';
                            }
                            echo "</td>";
                            echo "</tr>";
                        }  
                    }
                    else {
                        echo 'Erreur : Champs Vide !!!';
                    }
                ?>  
                </table>
            </div>
        </div>
    </body>
</html>

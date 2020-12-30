<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Gestion de réservations</title>
    </head>
    <body>

        <div class="container">
            <div class="row">

                <H1>Gestion de réservations</H1>
            </div>
            <div class="row">
                <table class="table table-bordered table-hover">
                    <tr class="thead-light" >
                        <th scope="col">Nom / Prenom</th>
                        <th scope="col">Login</th>
                        <th scope="col">Action</th>

                    </tr>

                    <?php
                    if (isset($tabUtilisateurs)) {
                        foreach ($tabUtilisateurs as $LesUtilisateurs) {
                            if (isset($LesUtilisateurs['id_user'])) {
                                echo "<tr scope='row'>";
                                echo "<td>" . $LesUtilisateurs['nom'] . " - " . $LesUtilisateurs['prenom'] . "</td>";
                                echo "<td>" . $LesUtilisateurs['login'] . "</td>";
                                echo '<td><div class="row">';
                                echo form_open('ModifyUser');
                                echo '<input name="idUtilisateur" type="hidden" value="' . $LesUtilisateurs['id_user'] . '"/>';
                                echo anchor('AddUserAdmin', '<button class="btn fa fa-pencil-square-o fa-lg text-warning"/>');
                                echo "</form>";

                                echo form_open('GestionUser');
                                echo '<input name="idUtilisateur" type="hidden" value="' . $LesUtilisateurs['id_user'] . '"/>';
                                echo form_button(array('nom' => 'supprimerUser', 'type' => 'submit', 'class' => 'btn', 'content' => '<i class="fa fa-trash fa-lg text-danger"></i>'));
                                echo "</form>";
                                echo '</row></td>';
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo 'Erreur : Champs Vide !!!';
                    }
                    ?>     
                </table>
                <?php echo anchor('AddUserAdmin', '<input class="btn btn-success btn-block fa fa-user" value="Ajouter un utilisateur"/>'); ?>
            </div>
    </body>
</html>

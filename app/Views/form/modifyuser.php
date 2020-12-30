<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Modifier l'utilisateur</title>
        <link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 

    </head>
    <body>
        <div class="register-form">
            <div class="row">
                <h2 class="text-center">Modifier l'utilisateur</h2>       

                <table class="table table-bordered table-hover">
                    <tr class="thead-light" >
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Mot de passe</th>
                        <th scope="col">Valider modifications</th>
                        <?= form_open('ModifyUser'); ?>
                        <?php
                        if (isset($infoUser)) {
                            foreach ($infoUser as $user) {
                                if (isset($user['id_user'])) {
                                    echo "<form><tr scope='row'>";
                                    echo '<td><input type="text" class="form-control" placeholder="Nom" id="nom" name="nom" value="' . $user['nom'] . '" required="required"></td>';
                                    echo '<td><input type="text" class="form-control" placeholder="Prenom" id="prenom" name="prenom" value="' . $user['prenom'] . '" required="required"></td>';
                                    echo '<td><input type="password" class="form-control" placeholder="Mot de passe" id="password" name="password"></td>';

                                    echo '<td><input type="hidden" name="idModifUser" value="' . $user['id_user'] . '" />'
                                    . form_button(array('nom' => 'supprimerUser', 'type' => 'submit', 'class' => 'btn btn-success', 'content' => '<i class="fa fa-check"></i>'));
                                    echo "</form>";
                                    echo "</tr>";
                                }
                            }
                        } else {
                            echo 'Aucune information reçu !!!';
                        }
                        ?>
                </table>
            </div>
        </div>
    </body>
</html>


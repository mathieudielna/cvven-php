<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Ajouter un utilisateur</title>
<link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 

</head>
<body>
<div class="register-form">
    <?= form_open('AddUserAdmin'); ?>
        <h2 class="text-center">Ajouter un utilisateur</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Nom" id="nom" name="nom" required="required">
        </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Prenom" id="prenom" name="prenom" required="required">
        </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Pseudo" id="user" name="user" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Mot de passe" id="password" name="password" required="required">
        </div>
        <div class="form-group">
            <input type="submit" id="Envoyer" class="btn btn-primary btn-block" value="Ajouter un utilisateur"/>
            <br>
            <?php echo anchor('Connexion', '<input class="btn btn-danger btn-block" value="Annuler" />'); ?>
        </div>
        <div class="clearfix">
             <?php if(isset($validation)){
                echo $validation->listErrors();}?>
        </div>
    </form>
</div>
</body>
</html>
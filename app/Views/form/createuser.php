<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>INSCRIPTION CVVEN</title>
<link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 

</head>
<body>
<div class="register-form">
    <?= form_open('CreateUser'); ?>
        <h2 class="text-center">Inscription CVVEN</h2>       
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
            <button type="submit" class="btn btn-primary btn-block" id="Envoyer" >Inscription</button>
            <br>
            <?php echo anchor('Connexion', '<input type="button" class="btn btn-danger btn-block" value="Annuler" />'); ?>
        </div>
        <div class="clearfix">
             <?php if(isset($validation)){
                echo $validation->listErrors();}?>
        </div>
    </form>
</div>
</body>
</html>

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>CVVEN CONNEXION</title>
<link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 
</head>
<body>
<div class="login-form">
    <?= form_open('Connexion'); ?>
        <h2 class="text-center">Connexion</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Identifiant" id="user" name="user" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Mot de passe" id="password" name="password" required="required">
        </div>
        <div class="form-group">
            <input type="submit" id="Envoyer" class="btn btn-primary btn-block" value="Connexion"/>
        </div>
        <div class="clearfix">
             <?php if(isset($validation)){
                echo $validation->listErrors();}?>
        </div>
    </form>
    <p class="text-center"><?php echo anchor('CreateUser', 'Créer un compte'); ?></p>
</div>
</body>
</html>


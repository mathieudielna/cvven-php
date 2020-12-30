<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>CHANGE MDP CVVEN</title>
<link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 
</head>
<body>
<div class="changeMDP-form">
    <?= form_open('ModifyPassword'); ?>
        <h2 class="text-center">Modifier mon code d'accès</h2>       
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Nouveau mot de passe" id="password" name="password" required="required"/>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirmer mot de passe" id="confirmPassword" name="confirmPassword" required="required"/>
        </div>
        <div class="form-group">
            <input type="submit" id="Envoyer" class="btn btn-success btn-block" value="Modifier"/>
            <br>
            <?php echo anchor('Home', '<input type="button" class="btn btn-danger btn-block" value="Annuler" />'); ?>
        </div>
        <div class="clearfix">
             <?php if(isset($validation)){
                echo $validation->listErrors();}?>
        </div>
    </form>
</div>
</body>
</html>


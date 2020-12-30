<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Gestion de réservations</title>
        <link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 
    </head>
    <body>
        <?= form_open('PageAdmin'); ?>
        <div class="container">
            <div class="row">
                
                <H1>Gestion de réservations</H1>
            </div>
            <div class="container-fluid grid-home text-right">
                <h1 class="text-center">Page Admin</h1>
                <div class="row">
                    <div class="text-center col bg-light "><?php echo anchor('Home', ' ','class="fa fa-home fa-10x text-success"'); ?></div>
                    <div class="text-center col bg-light"><?php echo anchor('GestionUser', ' ','class="fa fa-user fa-10x text-primary"'); ?></div>
                    <div class="text-center col bg-light"><?php echo anchor('AddUserAdmin', ' ','class="fa fa-user-plus fa-10x text-primary"'); ?></div>
                </div>
                <div class="row">
                    <div class="text-center col bg-light"><?php echo anchor('BookForm', ' ','class="fa fa-search fa-10x text-success"'); ?></div>
                    <div class="text-center col bg-light"><?php echo anchor('GestionReservation', ' ','class="fa fa-database fa-10x text-primary"'); ?></div>
                    <div class="text-center col bg-light"><?php echo anchor('ModifyPassword', '  ','class="fa fa-cog fa-10x text-warning"'); ?></div>
                </div>
                <div class="row">
                    <div class="text-center col bg-light"></div>
                    <div class="text-center col bg-light"><?php echo anchor('Connexion/deconnexion', ' ','class="nav-link fa fa-sign-out fa-10x text-danger"');  ?></div>
                    <div class="text-center col bg-light"></div>
                </div>
            </div>
            </div>
    </body>
</html>

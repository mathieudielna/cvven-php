<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Modifier un séjour</title>
<link rel="stylesheet" href="<?= base_url('css/form.css'); ?>"> 
</head>

<body>
<div class="Sejour-form">
    <?= form_open('ModifyReservation'); ?>
        <h2 class="text-center">Modifier une réservation</h2>       
        <div class="form-group">
            <select name="typelogement" class="form-control">
                <option value="">-----Veuillez sélectionnez une option------</option>
                    <?php 
                    if(isset($tabQueryTypeLogement)){
                        foreach ($tabQueryTypeLogement as $tabTypeLogement) {
                            echo '<option value="'.$tabTypeLogement["typelogement"].'">'.$tabTypeLogement["typelogement"].'</option>';  
                        }  
                    }   
                    ?>          
            </select>
        </div>  
        <div class="form-group">
            <input type="date" name="datedebut" min="2021-01-02" size="50" step="7" value="<?php echo $tabInfoReservation['datedebut']; ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <input type="date" name="datefin" min="2021-01-09" size="50" step="7" value="<?php echo $tabInfoReservation['datefin']; ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <input type="number" name="nbpersonne" min="1" max="4" size="50"  value="<?php echo $tabInfoReservation['nbpersonne']; ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <select name="pension" class="form-control">
                <option value="">-----Veuillez sélectionnez une pension-----</option>
                <option value="pensioncomplete">pension complète</option>
                <option value="demipension">demi-pension</option>
            </select>
        </div>
        <div class="form-check">
            <label for="menage" class="form-check-label">
            <input type="checkbox" name="menage" value="TRUE" class="form-check-input">
            Ménage fin de séjour</label>
        </div>
   
        <div class="form-group">
            <?php if(isset($validation)){
                echo $validation->listErrors();
            }?>
        </div>
        
        <div class="form-group">
            <input type="hidden" name="idUpdateReservation" value="<?php echo $tabInfoReservation['id_reservation'];?>">
            <input type="submit" id="Envoyer" class="btn btn-success btn-block" value="Modifier la réservation"/>
        </div>
    </form>
</div>
</body>
</html>

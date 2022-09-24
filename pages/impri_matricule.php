<?php 
    session_start();
    require '../controller/data/connect.php';
    
    $nif = $_GET['nif'];

    $reqSQL = "SELECT * FROM matricule_fiscale WHERE nif = :nif";
    $stmnt = $bd->prepare($reqSQL);
    $stmnt->execute([
        ':nif' => $nif
    ]);
    $restlAllRow = $stmnt->fetch();

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimer impot Societe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
   <div class="container">
    <div class="col-2"></div>
    <div class="col-10 border-matr">
        <div class="row tete-one">
            <div class="col-7"><h6>REPUBLIQUE D'HAITI<br>DIRECTION GENERALE DES IMPOTS</h6> </div>  
            <dv class="col-5"><h6>REPUBLIQUE D'HAITI<br>DIRECTION GENERALE DES IMPOTS</h6></dv>  
        </div>
        <div class="row tete-two">
            <div class="col-7"><h5>MATRICULE FISCALE DU CONTRIBUABLE</h5></div>  
            <dv class="col-5"><h5>MATRICULE FISCALE DU CONTRIBUABLE</h5</dv>  
        </div>
        <div class="row">
        <div class="row">
            <div class="col-7"><p>NIF :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; <?php echo $restlAllRow['nif']; ?></p></div>  
            <dv class="col-5"><p>NIF :&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <?php echo $restlAllRow['nif']; ?></p></dv>  
        </div class="corpsMatricule"><hr>
            <div class="col-7">
                <p class="bottom-para">Nom :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp; &nbsp;&nbsp;&nbsp; <strong><?php echo $restlAllRow['nom']; ?></strong></p>
               
                <p class="bottom-para">prenom :&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp; &nbsp;&nbsp;&nbsp; <strong><?php echo $restlAllRow['prenom']; ?></strong></p>
               
                <p class="bottom-para">Code SAE :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp; &nbsp;<strong><?php echo $restlAllRow['lieu_emission']; ?></strong></p>
                
                <p class="bottom-para">Adresse :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $restlAllRow['adresse']; ?></strong></p>
                
                <p class="bottom-para">Fonction occupe :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $restlAllRow['activite']; ?></strong></p>
                <div class="row">
                    <div class="col-6">
                        <p class="bottom-para">CIN :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <strong><?php echo $restlAllRow['cin']; ?></strong></p>
                    </div>
                    <div class="col-6">
                       <p class="signature_contribuable">______________________________________<br> <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (signature contribuable)</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <p class="bottom-para">Lieu d'emission :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $restlAllRow['lieu_emission']; ?></strong></p>
            
                    <p class="bottom-para">No Quitance :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php ?></strong></p>

                    <p class="bottom-para">Date :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; &nbsp;<strong><?php echo date('d-m-Y') ?></strong></p>

                    <p class="bottom-para">Nom Agent :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<strong><?php echo $restlAllRow['nom_complet_agent']; ?></strong></p>
                    <br><br>
                    <p class="signature_dgi"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        _____________________________________<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>(Signature DGI)</p>
                </div>
        </div>
    </div>
    <div class="row bouton">
        <div class="col-6">
            <a class="btn btn-primary" href="print_matricule.php?nif=<?php echo $nif?>">Imprimer</a>
        </div>
            <div class="col-6">
                <a class="btn btn-danger" href="super_user.php">Retour</a>
        </div>
   </div>
   </div>
</div>
<?php session_destroy(); ?>
</body>
</html>

<style>

    .container{
        position: relative;
        left: 60px;
        
    }

    .border-matr{
        background-color: rgb(255,245,238);
        border: 2px solid blue;
        width: 1000px;
        padding-left: 10px;
        padding-right: 10px;
    }
    h5, h6{
        text-align: center;
    }

    .tete-one{
        background-color: blue;
        color: white;
    }

    .tete-two{
        background-color: red;
        color: white;
    }

    .bottom-para{
      margin-bottom: 6px;
      border-bottom: 1px dashed black;
    }

    .signature_contribuable{
        position: relative;
        top: 5px;
    }

    .signature_dgi{
        position: relative;
        top: -11px;
    }
    .btn-danger{
        position: relative;
        left: -450px;
    }

    .bouton{
        margin-top: 10px;
    }
    

    

   
</style>
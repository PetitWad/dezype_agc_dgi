<?php 
    session_start();
    require '../controller/data/connect.php';
    $code = intval($_GET['code']);

    $reqSQL = "SELECT * FROM contribuable WHERE code = :code";
    $societeStatement = $bd->prepare($reqSQL);
    $societeStatement->execute([
        'code' => $code
    ]);
    $restlAllRow = $societeStatement->fetchAll();
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
        <div class="row">
        <div class="col-2"></div>
            <div class="col-8" id="formeImpr">
                <!-- ligne pour l'entete de forme -->
                <div class="row">
                    <div class=""></div>
                    <div class=" ">
                      <img class="palmist-img" src="../public/images/palmiste.png" alt="logo palmiste">
                      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      &nbsp;  &nbsp; 
                      
                      <img class="dgi-img" src="../public/images/fond1.png" alt="logo palmiste">
                        <h6>REPUBLIQUE D'HAITI <br> DIRECTION GENERALE DES IMPOTS</h6>
                        <?php foreach($restlAllRow as $resltRow):  ?>
                        <p class="titre-doc">Certificat d'enregistrement <?php echo $resltRow['nomsecteur'];?></p>
                        
                    </div>
                </div>
                <!-- fin ligne entete forme -->
                <!-- nouvel ligne qui va prendre en compte les donnees dans deux colonne -->
                <div class="row">
                    <div class="col-12">
                      <?php endforeach  ?> 
    
                    <p class="p" style="text-align:justify; margin:10px; margin-left:-1px; margin-right:-1px;">
                        L'entreprise <strong><em><?php echo $resltRow['nom']?></em></strong> est enregistré au numero 
                        <strong><em><?php echo $resltRow['nif']?></em></strong> et son code fiscal est le: <strong><em><?php echo $resltRow['code']?></em></strong>  
                       Elle est une société <strong><em><?php echo $resltRow['typesociete']?></em></strong> qui évolue dans le secteur <strong><em><?php echo $resltRow['nomsecteur']?></em></strong>.
                        <br><br>
                         Selon le texte de loi, Article 4, Toute personne moral ou physique doit faire sa declaration definitive d'impot
                         pour l'année fiscal en Haïti en raison de l’ensemble de leurs revenus.
                            <br>
                         De ce fait, après l’enregistrement de ce contribuable, conformément aux exigences 
                         de la constitution haïtienne,nous les responsables de la DGI le qualifient éligible
                         à être soumis aux assujettissements des impôts et lui remettons ce présent document afin 
                         de servir et valoir ce que de droit.
                     </p>
                <div class="row cont_Dgi">
                    <div class="col-6"><br><br>
                        <div class=""><p>________________________ <br> Contribuable</p></div>
                    </div>
                    <div class="col-6 "><br><br>
                        <div class=" span"><p>________________________ <br> DGI</p></div>
                    </div>
                </div>
                <!-- fin ligne deux colonnes -->
            </div>
            <p>Fait à : <strong><em><?php echo strtoupper($resltRow['ville']) ."&nbsp; &nbsp; <br> Le ". date('d-m-Y') ?></strong></em></p>
        </div>
    </div>
    <div class="col-2"></div>
        <div class="row ">
            <div class="col-3 "><a href="print.php?code=<?php echo $code ?>" class="btn btn-primary">IMPRIMER &nbsp; <i class="bi bi-printer"></i></a></button> </div>
            <div class="col-2"><a href="super_user.php" class="btn btn-danger">Retour</a></button> </div>
            <div class="col-7"></div>
        </div>
    </div> 
</div>

    
    
</body>
</html>

<style>
.container{
    border: 3px solid black;
    margin-top: 15px;
    height: 600px;
    padding-bottom: 50px;
}

img{
    position: relative;
    top: 70px;
    height: 90px;
}

.palmist-img{
    position: relative;
    left: 45px;
}

.dgi-img{
    position: relative;
    right: 30px;
}

#formeImpr h6{
        
    font-size: 22px;
    color: black;
    text-align: center;
    padding: 5px;
    font-weight:bold;
}

.titre-doc{
    background-color: red;
    font-size: 18px;
    text-align: center;
    color: white;
    margin-top: 0px;
    padding: 1px;
}

.btn-danger, .btn-primary{
    position: relative;
    top: 50px;
}
  

.btn-danger{
    margin-left: -125px;    
}

.col-6{
    text-align: center;
}
    

strong{
    font-size: 15px;
}

.p{
    font-size:15px;
}
</style>
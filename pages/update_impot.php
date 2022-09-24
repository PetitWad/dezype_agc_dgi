<?php
session_start();
require '../controller/data/connect.php';

$code = intval($_GET['code']);

$reqSelect = "SELECT * FROM contribuable WHERE code = :code";
$stateSelect = $bd->prepare($reqSelect);
$stateSelect->execute([
    ':code'=>$code
]);
$rowSelect = $stateSelect->fetch();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>Update Impot</title>
</head>

<body class="sb-nav-fixed"
    style="background-color:white;
    background-attachment: fixed; 
    background-size: cover;">

    <div class="container-fluid">
      <?php include_once('navbar.php');?>
        <div id="layoutSidenav">
         <?php 
         require '../fonctions/authentifier.php';
         est_connecter();
         include_once('dashboard.php');?>
            <div id="layoutSidenav_content">
        <div class="row"> 
        <div id="style_revenu_masse" class="col-12">
            <!-- debut entete  -->
        <div class="row">
        <div class="col-5">
            <center> 
               <img style="height: 55px;" src="../public/images/palmiste.png" alt="logo palmiste">
               <h5 style="font-weight:bold;">REPUBLIQUE D'HAITI</h5>
               <h6>MINISTERE DE L’ECONOMIE ET DES FINANCES 
               <h5 style="font-weight:bold;">DIRECTION GENERALE DES IMPOTS</h5>
               <!-- <h2 style="font-weight:bold; color:red;">IMPOT SUR LES SOCIÉTÉS</h2> -->
            </center>
            </div>
        </div>
            <!-- fin entete -->
        <!--  debut ligne bouton operation -->
        <div id="btn-operation" class="row">
         <div class="col-3">
            <?php if(isset($_GET['error'])){ ?>
                <p class="alert alert-success"> <?php echo $_GET['error'] ?> </p>
            <?php } ?> 
         </div>
         <div class="col-4"></div>
         <div class="col-5">
                <h3>MODIFICATION IMPOT</h3>
            </div>
         </div>
     </div>
    
    <!--  fin ligne bouton operation -->
            <form action="../controller/postUpdateImpot.php" method="POST">
            <!-- debut premier ligne --><hr>
            <div id="firstRow" class="row">
                <div class="col-5">
                </div>
                <div class="col-4">
                <div class="mb-2">
                <label for="periode">PERIODE D'IMPOSITION</label>
                    <select class="form-select" aria-label="Default select" name="periode" value="<?php echo $rowSelect['periode'] ?>" >
                        <option value="Janvier">Janvier</option>
                        <option value="Fevrier">Fevrier</option>
                        <option value="Mars">Mars</option>
                        <option value="Avril">Avril</option>
                        <option value="Mai">Mai</option>
                        <option value="Juin">Juin</option>
                        <option value="Juillet">Juillet</option>
                        <option value="Aout">Aout</option>
                        <option value="Septembre">Septembre</option>
                        <option value="Octobre">Octobre</option>
                        <option value="Novembre">Novembre</option>
                        <option value="Decembre">Decembre</option>
                    </select>
                </div>
                </div>
                <div class="col-3">
                <div class="mb-2">
                <label for="typeDeclaration">Type de société</label>
                    <select class="form-select" aria-label="Default select" name="typesociete" value="<?php echo $rowSelect['typesociete'] ?>" >
                        <option value="SNC">Société en nom colectif</option>
                        <option value="SEC">Société en commandite</option>
                        <option value="SA">Société anonyme</option>
                        <option value="SAM">Société anonyme mixte</option>
                    </select>
                </div>
                </div> 
            </div><hr>
            <!-- fin premier ligne -->
            <!-- debut deuxieme ligne  -->
            <div id="secondRow" class="row">
                <div class="col">
                <div class="mb-2">
                        <label for="nif">NIF</label>
                        <input type="text" class="form-control" name="nif" value="<?php echo $rowSelect['nif'] ?>" >
                    </div>
                    <div class="mb-2">
                        <label for="Adresse">ADRESSE COMPLET</label>
                        <input type="text" class="form-control" name="adresse" value="<?php echo $rowSelect['adresse'] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="Telephone">TELEPHONE</label>
                        <input type="text" class="form-control" name="telephone" value="<?php echo $rowSelect['telephone'] ?>">
                    </div>
                    <div class="mb-2">
                        <input type="hidden"class="form-control" name="code" value="<?php echo $rowSelect['code'] ?>">
                    </div>
                </div>
                <div class="col">
                <div class="mb-2">
                        <label for="nom">NOM OU RAISON SOCIALE</label>
                        <input type="text" class="form-control" name="nom" value="<?php echo $rowSelect['nom'] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="ville">VILLE</label>
                        <input type="text" class="form-control" name="ville" value="<?php echo $rowSelect['ville'] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="email">EMAIL</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $rowSelect['email'] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="nomsecteur">NOM DU SECTEUR D'ACTIVITÉ:</label>
                        <input type="text" class="form-control" name="nomsecteur" value="<?php echo $rowSelect['nomsecteur'] ?>">
                    </div>
                </div>
            </div><hr>
            <div>
            <button type="submit" class="btn btn-primary">Modifier</button> &nbsp; &nbsp; &nbsp;
           
        </div>
            <!--fin deuxieme ligne -->
        </form>  
            </div>
        </div>
    </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
</body>
</html>

<style>
 body{
    margin-top: -60px;
 }   
center{
    position: relative;
    top: 75px;
}
form{
    margin-top:-50px;
}
.error{
color: red;
font-size: 18px;
font-weight: bolder;
}

#btn-operation{
    margin-top: 50px;
}

#style_revenu_masse{
    margin-top: 40px;
}

#firstRow, #secondRow{
    margin-right: 3px;
    padding: 12px;
}

.titre-revenu h2{
    margin-top: 80px;
}

.btn-group{
    margin-top:-120px;
}
/* .col-5 .dgi{
margin-top:-40px;
} */
.col-5{
    margin-top:-30px;  
}
.submit{
margin-bottom:30px;
}
h6{
    font-weight:bold;
    color:red;
}
</style>
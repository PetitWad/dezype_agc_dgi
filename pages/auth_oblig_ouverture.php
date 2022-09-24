<?php
session_start();
require '../controller/data/connect.php';

function Lister_timbre_oblig($table, $nif){
    require '../controller/data/connect.php';
    $an1 = date('Y');
    $an2 = date('Y')+1;
    $reqSQL = "SELECT * FROM $table WHERE nif = :nif";
    $revenuStatement = $bd->prepare($reqSQL);
    $revenuStatement->execute([
        ':nif'=>$nif,
    ]);
    $rowReq = $revenuStatement->fetchAll();
    return $rowReq;
}


if(isset($_POST['submit'])){
    $nif = $_POST['nif'];

    $_SESSION['nif'] = $nif;
    $nif = intval($nif);
    

// Requette dans la table revenu imposable pour authentifier
    $reqSQL = "SELECT * FROM matricule_fiscale WHERE nif = :nif LIMIT 1";
    $revenuStatement = $bd->prepare($reqSQL);
    $revenuStatement->execute([
        'nif'=>$nif
    ]);
    $rowReq = $revenuStatement->fetchAll();
    
    foreach($rowReq as $rowSelect):
        $nifVerifier = $rowSelect['nif'];
    endforeach;  

     if($nif === $nifVerifier){
        $_SESSION['nif'] = $nif;
        header("Location: obligation_ouverture.php");
     }else{
        header("Location: auth_oblig_ouverture.php?errAuth=😥Donnees sont introuvables...");
     }

}

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
    <title>Authentifier Pour obligation ouverture</title>
</head>
<body class="sb-nav-fixed"
    style="background-image:url('../public/images/Re.jpg');
    background-attachment: fixed; 
    background-size: cover;">
        <?php include_once('navbar.php');?>
            <div id="layoutSidenav">
         <?php 
            require '../fonctions/authentifier.php';
            est_connecter();
            include_once('dashboard.php');
        ?>
    <div class="container-fluid">
        <div class="row">
            <div class=" "> <?php require 'dashboard.php'; ?> </div>
            <div class="col-9">
                <div class="row">
                    <!-- <div class="col-6"></div> -->
                    <div id=formContent class="col-6">
                        <form action="#" method="post">
                            <h5> <span> Obligations fiscales de l’entreprise à l’ouverture<br></span> NIF pour authentifier</h5><br>
                            <?php if(isset($_GET['errAuth'])){ ?>
                                <p class="alert alert-danger error"> <?php echo $_GET['errAuth'] ?> </p>
                             <?php } ?> 
                            <div class="mb-4">
                                <i class="bi bi-lock iconUser"></i> <input class="form-control" name="nif" type="number" placeholder=" Entrer le Nif" required>
                            </div>
                            <div class="mb-4">
                                <button type="submit" name="submit" id="btn-auth"  class="btn btn-primary">Authentifier</button>
                            </div>
                        </form>
                    </div>   
                </div>
                    <!-- <div class="col-3"></div> -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
body{
    background-image:url('../public/images/fond.png');
    background-attachment: fixed; 
    background-size: cover;
}
#formContent{
        margin-top: 120px;
        margin-left:550px;
        height: 300px;
        box-shadow: 0px 0px 10px 0px black;
        padding-top: 50px;
        background-color: rgba(255, 255, 255, 0.082);
        
    }
    #formContent p{
        margin-top: -30px;
    }
    .iconUser{
        position: absolute;
        padding-left: 10px;
        padding-top: 1px;
        font-size: 22px;
    }

    .form-control{
        padding-left: 40px;
    }
    h5{
        text-align:center;
        padding-bottom: 10px;
        padding-top: 5px;
        margin-bottom: 20px;
        color: white;
        border-radius:20px;
        font-size:17px;
    }
    h5 span{
        color: yellow;
        font-weight: bolder;
        font-size: 20px;
    }

#btn-auth{
    box-shadow: 1px 2px 1px 1px black;
}

.alert-danger{
    text-align: center;
}
</style>
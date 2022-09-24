<?php
session_start();
require '../controller/data/connect.php';


if(isset($_POST['code'])){
    $code = $_POST['code'];

// Requette dans la table revenu imposable pour authentifier
    $reqSQL = "SELECT * FROM contribuable WHERE code = :code";
    $revenuStatement = $bd->prepare($reqSQL);
    $revenuStatement->execute([
        'code'=>$code
    ]);
    $rowReq = $revenuStatement->fetch();
       

     if($code == $rowReq['code']){
        $_SESSION['code'] = $code;
        header("Location: rechercheImpot.php?code=". $code);
     }else{
        header("Location: authRecherche.php?errAuth=😥Donnees sont introuvables...");
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
    <title>Authentifier Pour Modifier</title>
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
                    <div class="col-3"></div>
                    <div id=formContent class="col-5">
                       <?php if(isset($_GET['errAuth'])){ ?>
                            <p class="error"> <?php echo $_GET['errAuth'] ?> </p>
                        <?php } ?> 
                        <form action="#" method="post"><br>
                            <div class="mb-4">
                            <h5> <span>Authentifier </span>| Rechercher <i class="bi bi-search"></i> </h5>
                            <i class="bi bi-lock iconUser"></i><input class="form-control" name="code" type="text" placeholder="Code fiscal" required>
                            </div>
                            <div class="mb-4">
                                <button type="submit" id="btn-auth"  class="btn btn-primary">Autentifier</button>
                               <a href="super_user.php"  id="btn-retour" class="btn btn-danger">Retour</a>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4"></div> 
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
        margin-left:265px;
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
        background-color:yellow;
        border-radius:20px;
        font-size:17px;
        box-shadow: 0 3px 25px yellow;
    }
    h5 span{
        color:red;
    }
a{
    text-decoration:none;
    color:white;   
}

#btn-retour{
float:right;
}

#btn-auth, #btn-retour{
    box-shadow: 1px 2px 1px 1px black;
}

.error{
    color: white;
    font-size: 18px;
    text-align: center;
}
</style>
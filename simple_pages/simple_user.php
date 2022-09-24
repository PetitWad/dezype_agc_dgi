<?php
session_start();
require '../controller/data/bd_config.php';
require '../fonctions/FonctionReq.php';
try{
    $bd = new PDO($bd_dns, $bd_username, $bd_pass, $bd_options);
}catch(Exception $e){
    $e->getMessage();
}   

    if(isset($_POST['codeAuth']) && isset($_POST['nomAuth'])){
        $code = $_POST['codeAuth'];
        $nom = $_POST['nomAuth'];    
        
        if(empty($_POST['codeAuth'])){
            header("Location: simple_user.php?errAuth=Vueillez saisir le code...");
        }elseif(empty($_POST['nomAuth'])){
            header("Location: simple_user.php?errAuth=Vueillez saisir le nom...");
        }else{
            if(strlen($code) == 6){
                FonctionReq::ImpotReq($_POST['nomAuth'], $_POST['codeAuth']);
                $_SESSION['code'] = $code;
                header("Location: prelevelment.php?");
            }else{
                header("Location: simple_user.php?errAuth=Données sont introuvables...");
            }  
        }
    }

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>simple utilisateur</title>
</head>
<body class="sb-nav-fixed"

    >

    <div class="container">
      <?php include_once('navbar.php');?>
        <div id="layoutSidenav">
         <?php 
         require '../fonctions/authentifier.php';
         est_connecter();
         include_once('dashboard.php');?>
            <div id="layoutSidenav_content">
     <!-- <center>           
        <div class="row entete">
            <div class="col-3"></div>
            <div class="col-6">
                 <span><img style="width: 140px" src="../public/images/palmiste.png" alt=""></span>
                <p>REPUBLIQUE D'HAÏTI<br>MINISTERE DE L'ÉCONOMIE ET DES FINANCES <br> DIRECTION GÉNERALE DES IMPOTS </p>
            </div>
            <div class="col-3"></div>
        </div>
    </center>    -->
    <!-- fin ligne pour l'entete de forme  -->
    <!-- <div class="row section_form">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="col alert alert-primary label-prele">
                <h5 class="">Information du Contribuable</h5>
                <p>Déclaration Définitive Impot</p>
            </div>
            <form action="" method="post">
                <?php if(isset($_GET['errAuth'])){ ?>
                    <p class="error alert alert-warning"> <?php echo $_GET['errAuth'] ?> </p>
                <?php } ?> 
                <div class="mb-4">
                    <i class="bi bi-person iconUser"></i><input class="form-control" name="nomAuth" type="text" placeholder=" Put Your Username">
                </div>
                <div class="mb-4">
                    <i class="bi bi-lock iconUser"></i> <input class="form-control" name="codeAuth" type="password" placeholder=" Put Your Password">
                </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="mb-4">
                               <button type="submit" id="btn-modify" class="btn btn-primary">Autentifier</button>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-4">
                                <a href="../index.php" id="btn-modify" class="btn btn-danger">Exit</a>
                            </div>
                        </div>
                    </div>
              </form> -->
        </div>
        <div class="col-3"></div>
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

.iconUser{
    position: absolute;
    padding-left: 10px;
    padding-top: 1px;
    font-size: 22px;
}

.form-control{
    padding-left: 40px;
}

.entete{
    position: relative;
    top: 35px;
}

.entete, h5,p{
    text-align: center;
}

input{
    width: 200px;
}

.img-fluid{
    height: 130px;
    padding-left: 100px;
}

.text-img{
    padding-right: 120px;
    padding-top: 30px;
}
.section_form{
  position: relative;
  bottom: 30px;
}


h6{
    color:white;
}
</style>







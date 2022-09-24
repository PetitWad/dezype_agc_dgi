<?php
session_start();
require '../controller/data/connect.php';
require '../fonctions/FonctionReq.php';

if(isset($_POST['codeAuth']) && isset($_POST['nomAuth'])){
    $code = $_POST['codeAuth'];
    $nom = $_POST['nomAuth'];

    $_SESSION['code'] = $code;
    $code = intval($code);
    

// Requette dans la table revenu imposable pour authentifier
    $reqSQL = "SELECT * FROM contribuable WHERE code = :code  and nom = :nom LIMIT 1";
    $revenuStatement = $bd->prepare($reqSQL);
    $revenuStatement->execute([
        'code'=>$code,
        'nom'=>$nom,
    ]);
    $rowReq = $revenuStatement->fetch();
       


     if($code == $rowReq ['code'] && $nom = $rowReq['nom']){
        $_SESSION['code'] = $code;
        header("Location: ../simple_pages/prelevelment.php?code=". $code);
     }else{
        header("Location: auth_preleve.php?errAuth=😥Donnees sont introuvables...");
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
    <title>simple utilisateur</title>
</head>
<body>
    <div class="container">
      <!-- debut ligne pour l'entete de forme -->
        <div class="row entete">
          <div class="col-2"></div>
                <span><img src="../public/images/palmiste.png" alt=""></span>
                <p>REPUBLIQUE D'HAÏTI<br>MINISTERE DE L'ÉCONOMIE ET DES FINANCES <br> DIRECTION GÉNERALE DES IMPOTS </p>
        </div>
    <!-- fin ligne pour l'entete de forme  -->
    <div class="row">
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
                                <a href="super_user.php" id="btn-modify" class="btn btn-danger">Exit</a>
                            </div>
                        </div>
                    </div>
              </form>
        </div>
        <div class="col-3"></div>
    </div>
    </div>
</body>
</html>

<style>
body{
     font-family: 'Courier New', Courier, monospace;
    }

.iconUser{
    position: absolute;
    padding-left: 10px;
    padding-top: 1px;
    font-size: 30px;
    margin-top: 3px;
}

.label-prele{
    text-align: center;
    color: black;
    font-weight: bold;
}

.form-control{
    padding-left: 40px;
}

.entete{
        text-align: center;
        font-weight: bold;
        margin-top: 30px;
    }

.entete img{
        width: 120px;
    }

input{
    width: 200px;
    height: 50px;
    font-size: 20px;
}

.img-fluid{
    height: 130px;
    padding-left: 100px;
}

.text-img{
    padding-right: 120px;
    padding-top: 30px;
}
</style>
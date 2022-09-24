<?php
require '../controller/data/connect.php';
    
if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pwd'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['email'];
    $pwd = $_POST['pwd'];

    // requete qui verifie la duplication du nouvel insertion
    $reqSQL = "SELECT * FROM simple_user WHERE simple_user_code = :pwd LIMIT 1";
    $taxtStatement = $bd->prepare($reqSQL);
    $taxtStatement->execute([
        ':pwd'=>$pwd
    ]);

$rowReq = $taxtStatement->fetchAll();
foreach($rowReq as $rowSelect):
    $nom_verifier = $rowSelect['simple_user_nom'];
    $prenom_verifier = $rowSelect['simple_user_prenom'];
    $email_verifier = $rowSelect['email'];
endforeach;

    $req = $bd->prepare("INSERT INTO simple_user VALUES(:simple_user_code, :simple_user_nom, :simple_user_prenom, :email)");

    $req->bindParam(':simple_user_nom',$nom); 
    $req->bindParam(':simple_user_prenom',$prenom); 
    $req->bindParam(':email',$mail);
    $req->bindParam(':simple_user_code',$pwd); 

    if(isset($nom_verifier) == $nom && isset($prenom_verifier) == $prenom && isset($email_verifier) == $mail){
        header("Location: compteSimpleUser.php?error= Person Already Exist ❌"); 
    }else{
        $exc = $req->execute();
        if($exc){
            $reqSQL = "SELECT * FROM simple_user WHERE simple_user_code = :pwd LIMIT 1";
            $taxtStatement = $bd->prepare($reqSQL);
            $taxtStatement->execute([
                ':pwd'=>$pwd,
            ]);
           $rstRow = $taxtStatement->fetch();
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
    <link rel="stylesheet" href="../pages/revenu_imposable.php"/>
    <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>Création compte </title>
</head>
<body>
<body class="sb-nav-fixed"
    style="background-image:url('../public/images/Re.jpg');
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
            <div class="col-2"></div>
            <div class="col-8">
            <?php if(isset($exc)) : ?>
                <div class="container alert alert-success">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-4">
                            <h4>NOUVEAU COMPTE CRÉER</h4>
                        </div>
                        <div class="col-4">
                            <h6>NOM COMPTET : <?php echo strtoupper($rstRow['simple_user_nom']) .' '. ucfirst($rstRow['simple_user_prenom']);  ?> </h6>
                            <h6>MOT DE PASSE : <?php echo $rstRow['simple_user_code'] ?> </h6> 
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
                <?php endif ?>
                <div class="container">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-12 compte">
                            <div class="row">
                                <!-- <div class="col-3"></div> -->
                                <div class="col-6">
                                    <p class="titre one"><a href="compteSuperUser.php">Créer un compte DGI</a></p>
                                </div>
                                <div class="col-6">
                                    <p class="titre"><a href="compteSimpleUser.php">Créer un compte simple</a></p>
                                </div>
                                <!-- <div class="col-3"></div> -->
                        </div>
                            <form action="compteSimpleUser.php" method="POST">
                                <?php if(isset($_GET['error'])){ ?>
                                    <p style="text-align: center;" class="alert alert-danger"> <?php echo $_GET['error'] ?> </p>
                                <?php } ?> 
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-2">
                                            <input type="text" name="nom" class="form-control" required  placeholder="Nom">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-2">
                                            <input type="text" name="prenom" class="form-control" required  placeholder="Prenom">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <input type="mail" name="email" class="form-control" required  placeholder="E-mail">
                                </div>
                                <div class="mb-2">
                                    <input type="password" name="pwd" class="form-control" required  placeholder="Password">
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <button class="mb-2 btn btn-primary">CRÉER COMPTE</button>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-3">
                                        <a href="super_user.php" class=" mb-2 btn btn-danger">RETOUR</a>
                                    </div>
                                </div><br>
                            </form>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
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
    .container{
        margin-top: 3%;   
    }

    .compte{
        box-shadow: 1px 0px 4px 2px yellow;
        padding: 50px;
        background-color:gray;
    }

    .titre a{
        text-align: center;
        color: blue;
        font-weight: bolder;
        margin-left: 7px;
        margin-bottom: 30px;
    }

    a{
        text-decoration: none;
        font-size: 18px;
        

    }

    .one, .one a{
        background-color: white;
        color: black;
        font-size: 18px;
        font-weight: bolder;
        padding: 10px;
        border-radius: 5px;
    }

    .btn{
        font-size: 17px;
        margin-top: 3px;
    }
    .row{
right:10px;
    }
</style>
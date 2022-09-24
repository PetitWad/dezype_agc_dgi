<?php 
session_start();
require '../controller/data/connect.php';

    function validateInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST['commune']) && $_POST['mot_de_passe']){
        $commune = strtolower(validateInput($_POST['commune']));
        $mot_de_passe = validateInput($_POST['mot_de_passe']);

           $reqSQL = "SELECT super_user_code, commune FROM super_user WHERE  super_user_code = :super_user_code AND commune = :commune LIMIT 1";
           $stateReq = $bd->prepare($reqSQL);
           $stateReq->execute([
                'super_user_code'=> $mot_de_passe,
                'commune'=> $commune  
           ]);
           
           $reslt = $stateReq->fetchAll();
           foreach($reslt as $rowReq){
                $row_mot_de_passe = $rowReq['super_user_code'];
                $commune = $rowReq['commune'];   
           }

           if($commune == $commune && $row_mot_de_passe == $mot_de_passe){
                $_SESSION['commune'] = $commune;
                header("Location: rapport_communal.php");
           }else{
                header("Location: rapport.php?error= Desole la commune ou le mot de passe est incorrect");
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>Index Rapport</title>
</head>
<body class="sb-nav-fixed"
    style="background-color:'';
    background-attachment: fixed; 
    background-size: cover;"
    >
<div class="container-fluid">
      <?php include_once('navbar.php');?>
        <div id="layoutSidenav">
         <?php 
         require '../fonctions/authentifier.php';
         est_connecter();
         include_once('dashboard.php');?>
            <div id="layoutSidenav_content">
      
                <div class="container-fluid graph-container">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-4 graph-item"><?php require '../graph/first.php' ?></div>
                        <div class="col"></div>
                        <div class="col-5 graph-item"><?php require '../graph/second.php' ?></div>
                        <div class="col"></div>
                    </div>
                </div><br>
                <form action="./rapport.php" method="POST">
                <div class="container-fluid info-container">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8 input">
                            <div class="row">
                                    <h4 class="mb-3">Information Communal</h4>
                                    <div class="col-4"><input type="text" name="commune"  class="form-control"  placeholder="Commune"></div>
                                    <div class="col-4"><input type="text" name="mot_de_passe"  class="form-control" placeholder="Mot de Passe"></div>
                                    <div class="col-4"><button type="submit" class="btn btn-primary">Send</button></div>
                                    
                                    <?php if(isset($_GET['error'])){ ?>
                                    <p class="alert alert-danger mb-4"> <?php echo $_GET['error'] ?> </p>
                                    <?php } ?> 
                            </div>
                        </div>
                        <div  class="col-2"></div>
                </div>
        </div>
    </div>
    </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
</body>
</html>

<style>

    h4{
        margin-left: 150px;
    }
    

    .graph-container{
        margin-top: 100px;
    }
    .graph-item{
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        /* box-shadow: blue 0px 0px 0px 2px inset, rgb(255, 255, 255) 10px -10px 0px -3px, rgb(31, 193, 27) 10px -10px, rgb(255, 255, 255) 20px -20px 0px -3px, rgb(255, 217, 19) 20px -20px, rgb(255, 255, 255) 30px -30px 0px -3px, rgb(255, 156, 85) 30px -30px, rgb(255, 255, 255) 40px -40px 0px -3px, rgb(255, 85, 85) 40px -40px;    */
    }

    .info-container{
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        height: 300px;
    }

    .input{
        margin-top: 5%;
    }

    .input input{
        box-shadow: rgba(0, 0, 0, 0.4) 0px 30px 90px;
        height: 40px;
   }
</style>
<?php
session_start();
// $commune = $_SESSION['commune'];
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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>super user</title>
</head>
<body class="sb-nav-fixed"
    style="background-image:url('../public/images/Re.jpg');
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
        <div class="row">
            <div class="col-1">
               
            </div>
            <div class="col-11 section-controle">
                <div class="row">
                    <div class="col-12">
                       <h3>Gestion des contribuables</h3><hr>
                     </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <ul class="section-contribuable">
                            <li class="bg-primary mb-2"><a class="a" href="auth_oblig_ouverture.php">Obligation d'ouverture</a></li>
                            <li class="bg-primary mb-2"><a class="a" href="impot.php">Obligation à l'occasion de son fonctionnement</a></li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <ul class="section-contribuable">
                            <li class="bg-primary mb-2"><a class="a" href="impot.php">Obligations  de l’entreprise dans son rôle de collecter l’impôt</a></li>
                            <li class="bg-primary mb-2"><a class="a" href="impot.php">Obligation à l’occasion de la fermeture provisoire(SA)</a></li>
                        </ul>
                    </div>
                    <div class="col"></div>
                    <div class="col-3 horloge">
                        <?php require ('../fonctions/horloge.php'); ?>
                    </div>
                </div>
            </div>
            <!-- section obligation  --><br>
            <div class="row section_ouvert">
                <h3>Obligations fiscales à l’ouverture de l’entreprise</h3><hr>
                <div class="row">
                    <div class="col-4">
                        <p class="matricule"><a href="matricule.php"><i class="bi bi-arrow-right-circle-fill"></i> Matricule  fiscal</a></p>
                    </div>
                    <div class="col-4">
                        <p><a href=""><i class="bi bi-arrow-right-circle-fill"></i> Droit fixe + Droit variable</a></p>
                    </div>
                    <div class="col-4">
                        <p><a href=""><i class="bi bi-arrow-right-circle-fill"></i> Le timbre fixe (DSAV)</a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <p><a href=""><i class="bi bi-arrow-right-circle-fill"></i> Droit de timbre proportionnel sur capital social</a></p>
                    </div>
                    <div class="col-4">
                        <p><a href=""><i class="bi bi-arrow-right-circle-fill"></i> Droit de fonctionnement + DSAV</a></p>
                    </div>
                    <div class="col-4">
                        <p><a href=""><i class="bi bi-arrow-right-circle-fill"></i> La taxe sur actions (S.A)</a></p>
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

h3{
    color: yellow;
}

.section-controle{
    background-color: rgba(0, 0, 0, 0.5);
    padding: 30px 60px;
    position: relative;
    right: 50px;
    top: 15px;
}


.section-contribuable li{
    list-style: none;
    font-size: 18px;
    border-radius: 5px;
    padding: 6px 20px;
}

.section-contribuable li a{
    text-decoration: none;
    color: white;

}
.a{
    font-size:15px;
}

.section_ouvert{
    background-color: rgba(0, 0, 0, 0.5);
    padding: 30px 60px;
    position: relative;  
}


.section_ouvert p a{
    color: #fff;
    font-weight: bold;
    font-size: 18px;
}

.section_ouvert .col-4{
   position: relative;
   left: 60px;
}

.section_ouvert h3{
   position: relative;
   left: 45px;
}

.matricule{
    border: double 5px yellow;
}

.section_ouvert .col-4 p:hover {
    border: double 5px yellow;
}






</style>


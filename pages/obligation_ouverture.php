<?php 
   session_start();
   require '../controller/data/connect.php';
   require '../fonctions/FonctionReq.php';

   //................................Recuperation des inputs....................................

 $montant_droit_fixe = isset($_POST['montant_droit_fixe']);
 $timbre_fixe = isset($_POST['timbre_fixe']);
 $taxe_action = isset($_POST['taxe_action']);
 $droit_fonctionnement = isset($_POST['droit_fonctionnement']);

   $nif = $_SESSION['nif'];
   $annefiscale2 = date('Y') + 1;
   $table_montant_droit_fixe ='montant_droit_fixe';       
   $table_timbre_fixe = 'timbre_fixe';
   $table_droit_fonctionnement = 'droit_fonctionnement';

   $anne = FonctionReq::Oblig_ouvert_lister($table_montant_droit_fixe, $nif, $annefiscale2);
   $anne_timbre_fixe = FonctionReq::Oblig_ouvert_lister($table_timbre_fixe, $nif, $annefiscale2);
   $anne_droit_fonctionnement = FonctionReq::Oblig_ouvert_lister($table_droit_fonctionnement, $nif, $annefiscale2);

     $reqSQL = "SELECT * FROM matricule_fiscale WHERE nif = :nif";
     $societeStatement = $bd->prepare($reqSQL);
     $societeStatement->execute([
         'nif' => $nif
     ]);
     $restlAllRow = $societeStatement->fetchAll();

     foreach($restlAllRow as $rowSelect){
        $nom = $rowSelect['nom'];
     }    
    
    $annefiscale1 = date('Y');
    $annefiscale2 = date('Y') + 1;
    $dateEng = date('d-m-Y');
    $mois = date('m');
 

 /*
    @SQL + condition
    Une ou des patentes
    Droit fixe à l’ouverture
    Droit fixe + Droit variable ensuite
 */

 if($montant_droit_fixe){
    $montant_droit_fixe = 100;
    $montant_droit_fixe_sanction_2mois = ($montant_droit_fixe * 0.05) * 2 + $montant_droit_fixe;
    $montant_droit_fixe_sanction_autre_mois = (($montant_droit_fixe * 0.025) * (date('m')-2)) + $montant_droit_fixe;
    
    if($mois >= 1 && $mois <3){
        FonctionReq::Insert_montant_droit_fixe($table_montant_droit_fixe, $nif, $montant_droit_fixe_sanction_2mois, $annefiscale1, $annefiscale2, $dateEng);
        header("Location: obligation_ouverture.php");
    }elseif($mois >= 3 && $mois <10){
        FonctionReq::Insert_montant_droit_fixe($table_montant_droit_fixe, $nif, $montant_droit_fixe_sanction_autre_mois, $annefiscale1, $annefiscale2, $dateEng);
        header("Location: obligation_ouverture.php");
    }else{
        FonctionReq::Insert_montant_droit_fixe($table_montant_droit_fixe, $nif, $montant_droit_fixe, $annefiscale1, $annefiscale2, $dateEng);
        header("Location: obligation_ouverture.php");
    }
 }

 /*
    @SQL + condition
     À l’occasion du dépôt du bilan d’ouverture et des états  financiers annuels
 */

 if($timbre_fixe){
  $montant_timbre_fixe = 102;
    FonctionReq::Insert_montant_droit_fixe($table_timbre_fixe, $nif, $montant_timbre_fixe, $annefiscale1, $annefiscale2, $dateEng);
    header("Location: obligation_ouverture.php");
 }

/*
    @SQL + condition
    Du 1er au 30 oct. Ou le 31 déc. Au plus tard
 */

if($droit_fonctionnement){
    $montant_droit_fonctionnement = 1000;
      FonctionReq::Insert_montant_droit_fixe($table_droit_fonctionnement, $nif, $montant_droit_fonctionnement, $annefiscale1, $annefiscale2, $dateEng);
      header("Location: obligation_ouverture.php");
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
    <link rel="stylesheet" href="../pages/taxe_masse_salariale.php"/>
    <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>Impot</title>
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
        </div>
        
        <div class="container section_oblig_overture">
            <center><h3 class="alert alert-primary">Les obligations fiscales de l’entreprise  à l’ouverture </h3></center><br>
            <div class="row">
                <div class="col"></div>
                <div class="col-3">
                    <form action="obligation_ouverture.php" method="POST">
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="montant_droit_fixe" placeholder="Droit fixe à l’ouverture" <?php if($anne) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                        <div class="col-3"><button class="btn btn-primary" <?php if($anne) echo 'disabled="disabled"'; ?>>SEND</button></div>
                    </div>
                    </form>
                      <div class="alert alert-warning"> <i class="bi bi-info-circle-fill"></i> À la date d’ouverture de l’entreprise du 1er oct. au 15 déc. De chaque année <?php if($anne){?> <i class="bi bi-check-all"></i><?php }?>  </i></div>
                </div>
                <div class="col"></div>
                <div class="col-3">
                    <form action="obligation_ouverture.php" method="POST">
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="timbre_fixe" placeholder="Timbre fixe" <?php if($anne_timbre_fixe) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                        <div class="col-3"><button class="btn btn-primary" <?php if($anne_timbre_fixe) echo 'disabled="disabled"'; ?>>SEND</button></div>
                    </div>
                    </form>
                      <div class="alert alert-warning"><i class="bi bi-info-circle-fill"></i> À l’occasion du dépôt du bilan d’ouverture et des états  financiers annuels <?php if($anne_timbre_fixe){?> <i class="bi bi-check-all"></i><?php }?></div>
                </div>
                <div class="col"></div>
                <div class="col-3">
                    <form action="obligation_ouverture.php" method="POST">
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="droit_fonctionnement" placeholder="Droit de fonctionnement" <?php if($anne_droit_fonctionnement) echo 'disabled="disabled"'; ?>>
                                </div>
                            </div>
                        <div class="col-3"><button class="btn btn-primary" <?php if($anne_droit_fonctionnement) echo 'disabled="disabled"'; ?>>SEND</button></div>
                    </div>
                    </form>
                      <div class="alert alert-warning"><i class="bi bi-info-circle-fill"></i> Du 1er au 30 oct. Ou le 31 déc. Au plus tard <?php if($anne_droit_fonctionnement){?> <i class="bi bi-check-all"></i><?php }?></div>
                </div>
            </div><br>
            <!-- deuxieme lignes -->
            <div class="row">
                <div class="col"></div>
                <div class="col-8">
                    <form action="obligation_ouverture.php" method="POST">
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="montant_droit_fixe" placeholder="Droit de timbre proportionnel sur capital social">
                                </div>
                            </div>
                        <div class="col-3"><button class="btn btn-primary">SEND</button></div>
                    </div>
                    </form>
                      <div class="alert alert-warning"> <i class="bi bi-info-circle-fill"></i> Droit de timbre proportionnel sur capital social 2% du capital nominal de chaque action	Quelle que soit la date de la création de la société à l’émission de l’action d’un montant équivalent à 5,000.00 gdes	Amende de 20% du montant de l’action Art 24 et 27 du décret du 14 / 01 / 1974</div>
                </div>
                <div class="col"></div>
                <div class="col-3">
                    <button class="btn btn-primary" type="submit">Imprimer</button>
                </div>
                <!-- <div class="col-3">
                    <form action="obligation_ouverture.php" method="POST">
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="taxe_action" placeholder="La taxe sur actions ">
                                </div>
                            </div>
                        <div class="col-3"><button class="btn btn-primary">SEND</button></div>
                    </div>
                    </form>
                      <div class="alert alert-warning"><i class="bi bi-info-circle-fill"></i> Payable par tranche trimestrielle Montant à payer </div>
                </div> -->
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
.section_oblig_overture{
    position: relative;
    left: 50px;
    top: 100px;
}

.section_oblig_overture h3{
  width: 80%;
  margin-left: 100px;
}

.bi-check-all{
    text-align: justify;
    position: relative;
    /* left: 50px; */
    top: 20px;
    color: green;
    font-size: 20px;
    float: right;
}
</style>
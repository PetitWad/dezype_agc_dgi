<?php
session_start();
require '../controller/data/connect.php';
require '../fonctions/CalculPrelevTMS.php';
require '../fonctions/FonctionReq.php';

$code = intval($_SESSION['code']);


//  lister contribuable  masse salariale
    $reqLister = "SELECT * FROM contribuable WHERE code = :code";
    $stateLister = $bd->prepare($reqLister);
    $stateLister->execute([
        'code'=>$code ,
    ]);
    $rowReq = $stateLister->fetch();

// requette qui fait la jointure entre la table TMS et prelevement TMS 
    $reqSelect =  "SELECT
                    contribuable.nom, preleve_taxe_masse_sal.mois, 
                    preleve_taxe_masse_sal.annefiscal1, preleve_taxe_masse_sal.annefiscal2,
                    preleve_taxe_masse_sal.montant, preleve_taxe_masse_sal.taxePreleve,
                    preleve_taxe_masse_sal.penalite, preleve_taxe_masse_sal.datePreleve, totalPreleve 
                FROM contribuable
                INNER JOIN preleve_taxe_masse_sal  
                ON contribuable.code = preleve_taxe_masse_sal.code
                WHERE contribuable.code = :code";
$stateSelect = $bd->prepare($reqSelect);
$stateSelect->bindValue(':code', $code);

$stateSelect->execute();

// requette qui verifier si la table est vide
$reqListerPvTMS = "SELECT annefiscal2 FROM preleve_taxe_masse_sal WHERE code = :code";
    $statePvTMS = $bd->prepare($reqListerPvTMS);
    $statePvTMS->execute([
        'code'=>$code,
    ]);

    $annefis = $statePvTMS->fetch();

//Fonction Validation les champs
function validateInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

if(isset($_POST['submit'])){
    $mois =validateInput($_POST['mois']);
    $montant =validateInput($_POST['montant']);
    $annefiscal1 =validateInput($_POST['annefiscal1']); 
    $annefiscal2 =validateInput($_POST['annefiscal2']);
    $mois_prelevement= validateInput(intval($_POST['mois_prelevement']));
    $penalite = validateInput(intval($_POST['penalite']));
    $commune = validateInput($_POST['commune']);
    $dateEnrg = date('Y-m-d');
    
    $anEnrg = FonctionReq::AnneEnreg($code);
    $qnt_mois_sanction = CalculPrelevTMS::NmbreMois($code);

    $taxePreleve = $montant * 0.1;
    $sanction =  $qnt_mois_sanction * $taxePreleve * 0.1;
    $sans_sanction = 0;
    $totalPreleve = $taxePreleve + $sanction;


      if($annefiscal1 >= $annefiscal2 || $annefiscal1 > date('Y')){
            header("Location: preleveTaxMasseSal.php?error=Bien inserer les années fiscales");
        }elseif($annefiscal1 < $anEnrg){
            header("Location: preleveTaxMasseSal.php?error=Année insérer est inférieur à l'année d'enregistrement");
        }elseif($annefis == false){
            $req = $bd->prepare("INSERT INTO preleve_taxe_masse_sal VALUES(null, :code, :annefiscal1, :annefiscal2, :mois, :montant, :taxePreleve, :penalite, :totalPreleve, :datePreleve, :commune)");

                $req->bindParam(':code', $code , PDO::PARAM_INT); 
                $req->bindParam(':annefiscal1', $annefiscal1, PDO::PARAM_STR); 
                $req->bindParam(':annefiscal2', $annefiscal2, PDO::PARAM_STR); 
                $req->bindParam(':mois', $mois_prelevement); 
                $req->bindParam(':montant', $montant);
                $req->bindParam(':taxePreleve', $taxePreleve);
                $req->bindParam(':penalite', $sans_sanction);
                $req->bindParam(':totalPreleve', $taxePreleve);
                $req->bindParam(':datePreleve', $dateEnrg);
                $req->bindParam(':commune', $commune);
                $req->execute();
                header("Location: preleveTaxMasseSal.php?error=Prelevement effectuer ✔");
        }else{
            $req = $bd->prepare("INSERT INTO preleve_taxe_masse_sal VALUES(null, :code, :annefiscal1, :annefiscal2, :mois, :montant, :taxePreleve, :penalite, :totalPreleve, :datePreleve, :commune)");

            $req->bindParam(':code', $code , PDO::PARAM_INT); 
            $req->bindParam(':annefiscal1', $annefiscal1, PDO::PARAM_STR); 
            $req->bindParam(':annefiscal2', $annefiscal2, PDO::PARAM_STR); 
            $req->bindParam(':mois', $mois_prelevement); 
            $req->bindParam(':montant', $montant);
            $req->bindParam(':taxePreleve', $taxePreleve);
            $req->bindParam(':penalite', $sanction);
            $req->bindParam(':totalPreleve', $totalPreleve);
            $req->bindParam(':datePreleve', $dateEnrg);
            $req->bindParam(':commune', $commune);
            $req->execute();
            header("Location: preleveTaxMasseSal.php?error=Prelevement effectuer ✔");
        
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
    <title>Prelevement taxe sur la masse salariale </title>
</head>
<body class="sb-nav-fixed"
style="background-attachment: fixed; 
    background-size: cover;">
   <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark sb-nav-fixed">            
        <a class="navbar-brand ps-3" href="index.html"><img src="../public/images/logo.png" style="width:20%"; alt=""> AGC-DGI</a>
          
      <?php include_once('navbar.php');?>
        <div id="layoutSidenav">
         <?php 
         require '../fonctions/authentifier.php';
         est_connecter();
         include_once('dashboard.php');?>
            <div id="layoutSidenav_content">
            <div class="container-fluid">  

    <div class="container-fluid">
    <h3 class="alert alert-primary">Taxe sur la Masse Salariale <strong><?php echo strtoupper($rowReq['nom']) .' s.a' ?> </strong></h3>
        <div class="row">
            <div class="col-12">
            <form action="" method="POST">
        <div class="row">
            <?php if(isset($_GET['error'])){ ?>
               <p class="text-danger"> <?php echo $_GET['error'] ?></p>
            <?php } ?> 
        
            <div class="col-5">
                <div class="row">
                    <label id="anneFiscal" for="">Annee fiscale en cours</label> 
                    <div class="col-2"></div>
                    <div class="col-4">
                        <div class="mb-2">
                             <input type="text" name="annefiscal1" class="form-control"  required placeholder="Ex: <?php echo date('Y') ?>">
                        </div>
                    </div>
                    <div class="col-2">---</div>
                    <div class="col-4">
                        <div class="mb-2">
                            <input type="text" name="annefiscal2" class="form-control" required placeholder="Ex: <?php echo date('Y')+1?>">
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="col-2">
                <div class="mb-2">
                    <label for="">Mois Anterieur</label>
                        <select class="form-select" name="mois_prelevement" aria-label="Default select example">
                           <option selected value="1">Janvier</option>
                           <option value="2">Fevrier</option>
                           <option value="3">Mars</option>
                           <option value="4">Avril</option>
                           <option value="5">Mai</option>
                           <option value="6">Juin</option>
                           <option value="7">Juillet</option>
                           <option value="8">Aout</option>
                           <option value="9">Septembre</option>
                           <option value="10">Octobre</option>
                           <option value="11">Novembre</option>
                           <option value="12">Decembre</option>
                       </select>
                    </div>
                </div>
           <div class="col-2">
              <div class="mb-2">
                <label for="">Montant TMS</label>
                  <input type="number" name="montant" class="form-control" required  placeholder="Montant">
              </div>
            </div>
            <div class="col-3">
              <div class="mb-2"> 
              <label for="">Commune</label>
                  <input type="text" name="commune" class="form-control" required  placeholder="commune">
              </div>
            </div>
        </div>
            <button type="submit" name="submit" class="btn btn-primary">Préléver</button>
        </div>
    </div>
</form><br>
<center class="bg-warning"><?php if(CalculPrelevTMS::NmbreMois($code) > 0){ CalculPrelevTMS::MessageDouer($code); } ?></center>

<hr>
    <div class="container">
    <table class="step table table-bordered table-sm table-striped">
        <thead  class="table-dark">
            <tr><td class="titre"  colspan="7">
               <strong> Liste des transactions </strong>
            </td></tr>
                <th scope="col">Années Fiscales</th>
                <th scope="col">Mois</th>
                <th scope="col">Montant</th>
                <th scope="col">Prélévement à 2%</th> 
                <th scope="col">Penalite</th> 
                <th scope="col">Prélèvement + DSAV</th> 
                <th scope="col">Date prélèvement</th> 
        </thead>
        
        <tbody>
            <?php while($rowSelect = $stateSelect->fetch()){?>
                <tr>
                    <th scope="row"> <?php echo $rowSelect['annefiscal1'] ." - ". $rowSelect['annefiscal2'] ; ?> </th>
                    <td class="bcgris"> <?php echo $rowSelect['mois']?></td>
                    <td class="bcgris"><?php echo $rowSelect['montant']?>  HTG</td>
                    <td class="bcgris"><strong style="color:green"><?php echo $rowSelect['taxePreleve']?> GDS</strong></td>
                    <td class="bcgris"><?php echo $rowSelect['penalite']?>  HTG</td>
                    <td class="bcgris"><?php echo $rowSelect['totalPreleve']?>  HTG</td>
                    <td class="bcgris"><?php echo $rowSelect['datePreleve']?></td>
                </tr>
            <?php } ?> 
        </tbody> 
    </table>               
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

    .container-fluid{
        position: relative;
        top: 150px;
        right: 40px;
    }

    #anneFiscal{
        margin-left: 135px;
    }

    h3{
    text-align: center;
    margin-left: 60px; 
}


  
</style>
<?php
session_start();
require '../controller/data/connect.php';
require '../fonctions/FonctionReq.php';

$code = $_SESSION['code'];


//Fonction Validation les champs
function validateInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

// Requete Lister le nom de l'entreprise en question
$reqLister = "SELECT * FROM contribuable WHERE code = :code LIMIT 1";
$stateLister = $bd->prepare($reqLister);
$stateLister->execute([
    'code'=>$code ,
]);
$rowReq = $stateLister->fetch();


// Requete qui lister les element du tableau prelevement
$reqListerChigAff = "SELECT * FROM preleve_taxe_chif_affaire WHERE code = :code";
$stateChifAff = $bd->prepare($reqListerChigAff);
$stateChifAff->bindValue(':code', $code, PDO::PARAM_INT);
$stateChifAff->execute();


// Requete qui verfie les impots forfaitaire de base et simplifier 
// $anne2 = date('Y')+1;
// $sql = "SELECT * FROM preleve_taxe_chif_affaire WHERE codeTCA = :code AND annefiscal2 = :anne2";
// $state = $bd->prepare($sql);
// $state->execute([
//     ':code'=>$code,
//     ':annefiscal2', $anne2
// ]);
// $state->fetch();


//  verifier les annees fiscal
$reqListerPvTMS = "SELECT annefiscal2 FROM preleve_taxe_chif_affaire WHERE code = :code";
$statePvTMS = $bd->prepare($reqListerPvTMS);
$statePvTMS->execute([
    'code'=>$code,
]);

foreach($statePvTMS->fetchAll() as $rowSelect):
    $annefisVerifier2 = $rowSelect['annefiscal2'];
endforeach;


if(isset($_POST['chiffre_affaire'])){
    $annefiscal1 = validateInput($_POST['annefiscal1']);
    $annefiscal2 = validateInput($_POST['annefiscal2']);
    $chiffre_affaire = validateInput($_POST['chiffre_affaire']);
    $mois = validateInput($_POST['mois_prelevement']);
    $commune = validateInput($_POST['commune']);


    $anEnrg = FonctionReq::AnneEnreg($code);
    $taxePreleve = ($chiffre_affaire * 0.1)+ 252;
    $penalite = 0;


   if($annefiscal1 < $anEnrg){
        header("Location: prelevTaxeChifAffaire.php?error=Année insérer est inférieur à l'année d'enregistrement");
    }elseif($chiffre_affaire < 2250000 ){
        $tca = intval(($chiffre_affaire - 5000000) *0.1) ;

        $req = $bd->prepare("INSERT INTO preleve_taxe_chif_affaire VALUES(null, :code, :annefiscal1, :annefiscal2, :mois, :chiffre_affaire, :totalPreleve, :penalite, :datePreleve, :commune)");
        
        $dateEnrg = date('d-m-Y');
        $req->bindParam(':code', $code);
        $req->bindParam(':annefiscal1', $annefiscal1); 
        $req->bindParam(':annefiscal2', $annefiscal2); 
        $req->bindParam(':mois', $mois); 
        $req->bindParam(':chiffre_affaire', $chiffre_affaire); 
        $req->bindParam(':totalPreleve', $tca); 
        $req->bindParam(':penalite', $penalite);
        $req->bindParam(':datePreleve', $dateEnrg);
        $req->bindParam(':commune', $commune);
        $req->execute();
        header("Location: prelevTaxeChifAffaire.php?error=Declaration definitive impot regime simplifier effectuer avec succes ✔");  
        header("Location: prelevTaxeChifAffaire.php?preleveOk=preleveOk");      
    }else{
        // if(!empty($stateChifAff['chiffre_affaire']) && $stateChifAff['chiffre_affaire'] < 2250000){
        //     header("Location: prelevTaxeChifAffaire.php?error=Declaration definitive impot regime réel doit > 2,250,000.00 GDS 🚫");    
        // }else{
            $req = $bd->prepare("INSERT INTO preleve_taxe_chif_affaire VALUES(null, :code, :annefiscal1, :annefiscal2, :mois, :chiffre_affaire, :totalPreleve, :penalite, :datePreleve, :commune)");
            
            $dateEnrg = date('Y-m-d');
            $req->bindParam(':codeTCA', $code);
            $req->bindParam(':annefiscal1', $annefiscal1); 
            $req->bindParam(':annefiscal2', $annefiscal2); 
            $req->bindParam(':mois', $mois); 
            $req->bindParam(':chiffre_affaire', $chiffre_affaire); 
            $req->bindParam(':totalPreleve', $taxePreleve); 
            $req->bindParam(':penalite', $penalite);
            $req->bindParam(':datePreleve', $dateEnrg);
            $req->bindParam(':commune', $commune);
            $req->execute();
            header("Location: prelevTaxeChifAffaire.php?error=Declaration définitive impot régime réel effectuer avec succes ✔");
        }
    }
// }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prelevement taxe sur chiffre d'affaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
      <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
   </head>
   <body
    style=" background-size: cover;">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark sb-nav-fixed">            
        <!-- <a class="navbar-brand ps-3" href="index.html"><img src="../public/images/logo.png" style="width:20%"; alt=""> AGC-DGI</a> -->
          
      <?php include_once('navbar.php');?>
        <div id="layoutSidenav">
         <?php 
         require '../fonctions/authentifier.php';
         est_connecter();
         include_once('dashboard.php');?>
            <div id="layoutSidenav_content">
            <div class="container-fluid">  
<div class="container-fluid">
    <h3 class="alert alert-primary">Impot sur le Chiffre d'Affaire <strong><?php echo strtoupper($rowReq['nom']) .' s.a' ?> </strong>
</h3>
    <div class="row">
        <div class="col"></div>
        <div class="col-10">
        <h5>Impôt forfaitaire | Acompte Provisionnel </h5><hr>
        <form action="prelevTaxeChifAffaire.php" method="post">
            <div class="row">
                <?php if(isset($_GET['error'])){ ?>
                    <p class="alert alert-danger"> <?php echo $_GET['error'] ?> </p>
                <?php } ?>
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <label id="anneFiscal" for="">Annee fiscale en cours</label> 
                            <div class="col-2"></div>
                            <div class="col-4">
                                <div class="mb-2">
                                    <input type="text" name="annefiscal1" class="form-control"  required placeholder="Ex: <?php echo date('Y') ?>">
                                </div>
                            </div>
                            <div class="col-1">--</div>
                                <div class="col-3">
                                 <div class="mb-2">
                                    <input type="text" name="annefiscal2" class="form-control" required placeholder="Ex: <?php echo date('Y')+1?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
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
                    <div class="col-3">
                        <div class="mb-2">
                        <label for="commmune">Commune</label>
                        <input class="form-control" type="text" name="commune">
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="col-1"></div>
                <div class="col-7">
                    <div class="bg-gray mb-2">
                       <label for="chiffre_affaire">Chiffre d’Affaire ou Actif Total </label>
                     </div>
                </div>
                <div class="col-2">
                    <div class="mb-2">
                         <input type="number" name="chiffre_affaire" class="form-control" placeholder="Montant"  required>
                     </div>
                </div>
                </div>
                <div class="mb-3">
                    <input class="btn btn-success" type="submit" value="Enregistrer"<?php if(isset($_GET['preleveOk'])) echo 'disabled="disabled"'; ?>>
                </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row"><hr>
            <div class="col"></div>
            <div class="col-10">
                <table class="step table table-bordered table-sm table-striped">
                  <thead  class="table-dark">
                    <h6>Liste des transactions</h6>
                <tr>
                    <td class="titre"  colspan="7">
                    </td>
                </tr>
                    <th scope="col">Années Fiscales</th>
                    <th scope="col">Mois</th>
                    <th scope="col">Chiffre d'Affaire</th>
                    <th scope="col">Montant Préléver</th> 
                    <th scope="col">penalite</th>
                    <th scope="col">date Preleve</th>
                </thead>
                <tbody>
                    <?php while($rowSelect = $stateChifAff->fetch()){?>
                    <tr>
                        <th scope="row"> <?php echo $rowSelect['annefiscal1'] ." - ". $rowSelect['annefiscal2'] ; ?> </th>
                        <td class="bcgris"> <?php echo $rowSelect['mois']?></td>
                        <td class="bcgris"> <?php echo $rowSelect['chiffre_affaire']?> HTG</td>
                        <td class="bcgris"><?php echo $rowSelect['totalPreleve']?>  HTG</td>
                        <td class="bcgris"> <?php echo $rowSelect['penalite']?> HTG</td>
                        <td class="bcgris"> <?php echo $rowSelect['datePreleve']?></td>
                    </tr>
                <?php } ?> 
            </tbody> 
        </table>
     </div>
     <div class="col"></div>
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
    text-align: center;
   }

.container-fluid{
    position: relative;
    top: 130px;
}

  .bg-gray{
        background-color: gray;
        padding: 2px;
        border-radius: 3px;
        color: black;
        font-weight: bold;
    }

    form{
        margin-top: 20px;
    }
    .form-control{
        height: 33px;
    }
    label{
        padding: 3px;
    }

    .col-7, .col-2{
margin-top:10px;
    }
    

</style>
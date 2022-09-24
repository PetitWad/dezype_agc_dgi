<?php 
session_start();
require '../controller/data/connect.php';
require '../fonctions/FonctionReq.php';

$code = $_SESSION['code'];

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


//  verifier les annees fiscal
$reqListerImpSoc = "SELECT mois_prelevement FROM preleve_taxe_societe WHERE code = :code ";
$stateImpSoc = $bd->prepare($reqListerImpSoc);
$stateImpSoc->execute([
    'code'=>$code,
]);

foreach($stateImpSoc->fetchAll() as $rowSelect):
    $mois_prelevement = $rowSelect['mois_prelevement'];
endforeach; 

// Requete qui lister les element du tableau prelevement
$reqListerImpoSoc = "SELECT * FROM preleve_taxe_societe WHERE code = :code";
$stateImpSoc = $bd->prepare($reqListerImpoSoc);
$stateImpSoc->bindValue(':code', $code, PDO::PARAM_INT);
$stateImpSoc->execute();


if(isset($_POST['total_crs_terme'])){
//................ champs actif 
    $total_crs_terme = validateInput($_POST['total_crs_terme']);
    $total_immobilisation_financiere = intval(validateInput($_POST['total_immobilisation_financiere']));
    $total_immobilisation_corporelle = intval(validateInput($_POST['total_immobilisation_corporelle']));
    $total_immobilisation_incorporelle = intval(validateInput($_POST['total_immobilisation_incorporelle']));
//............... Calcul pour les champs actif
$total_actif_lng_terme = $total_immobilisation_financiere + $total_immobilisation_corporelle + $total_immobilisation_incorporelle;
$total_actif = $total_actif_lng_terme + $total_crs_terme;

//............... champs passif
    $total_cmpt_crediteur = intval(validateInput($_POST['total_cmpt_crediteur']));
    $total_impot_payer = intval(validateInput($_POST['total_impot_payer'])) ;
    $total_passif_long_terme = intval(validateInput($_POST['total_passif_long_terme']));
    $total_passif_et_capitaux_propre = intval(validateInput($_POST['total_passif_et_capitaux_propre']));
//............... Calcul pour les champs passif
$total_passif_court_terme = $total_cmpt_crediteur + $total_impot_payer;
$total_passif = $total_passif_court_terme + $total_passif_long_terme;

    
//.............. champs exercice fiscal
    $annefiscal1 = validateInput($_POST['annefiscal1']);
    $annefiscal2 = validateInput($_POST['annefiscal2']);
    $commune = validateInput($_POST['commune']);
    $mois_prelevement = validateInput($_POST['mois_prelevement']);
    $acompte_provisionnel = intval(validateInput($_POST['acompte_provisionnel']));
    $Benefice_imposable = intval(validateInput($_POST['Benefice_imposable']));

$anEnrg = FonctionReq::AnneEnreg($code);

//.............. Calcul exercice
$prelevement = $Benefice_imposable * 0.3;
// Date Enregistrement
$datePreleve = date('d-m-Y');


if($annefiscal1 < $anEnrg){
    header("Location: prelevImpotSociete.php?error=Année insérer est inférieur à l'année d'enregistrement");
}else{
    $req = $bd->prepare("INSERT INTO preleve_taxe_societe VALUES(:code, :annefiscal1, :annefiscal2, :mois_prelevement,
     :total_actif_lng_terme, :total_actif, :total_passif_court_terme, :total_passif, :acompte_provisionnel, :totalPreleve,
     :datePreleve, :commune)");
  
    $req->bindParam(':code', $code);
    $req->bindParam(':annefiscal1', $annefiscal1); 
    $req->bindParam(':annefiscal2', $annefiscal2); 
    $req->bindParam(':mois_prelevement', $mois_prelevement); 
    $req->bindParam(':total_actif_lng_terme', $total_actif_lng_terme);
    $req->bindParam(':total_actif', $total_actif); 
    $req->bindParam(':total_passif_court_terme', $total_passif_court_terme); 
    $req->bindParam(':total_passif', $total_passif); 
    $req->bindParam(':acompte_provisionnel', $acompte_provisionnel); 
    $req->bindParam(':totalPreleve', $prelevement); 
    $req->bindParam(':datePreleve', $datePreleve); 
    $req->bindParam(':commune', $commune);
    $req->execute();
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
    <title>Prelevement impot societe</title>
</head>
<body style="background-attachment: fixed; 
    background-size: cover;">
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
<h3 class="alert alert-primary">Impot sur les Societes <strong><?php echo strtoupper($rowReq['nom']) .' s.a' ?> </strong></h3>
    <div class="row">
        <div class="col"></div>
        <div class="col-11">
            <?php if(isset($_GET['error'])){ ?>
                <p class="alert alert-danger"> <?php echo $_GET['error'] ?> </p>
            <?php } ?>
    <form action="prelevImpotSociete.php" method="post">
        <div class="row bg-light">
            <div class="col"></div>
            <div class="col-5">
                <h4 class="">ACTIF DE L'ENTREPRISE</h4>
                <div class="mb-2">
                    <input type="text" name="total_crs_terme" class="form-control" required placeholder="Total à court terme">
                </div>
                <div class="mb-2">
                    <input type="text" name="total_immobilisation_financiere" class="form-control" required placeholder="Total Immobilisation Financière">
                </div>
                <div class="mb-2">
                    <input type="text" name="total_immobilisation_corporelle" class="form-control" required placeholder="Total Immobilisation Corporelle">
                </div>
                <div class="mb-2">
                    <input type="text" name="total_immobilisation_incorporelle" class="form-control" required placeholder="Total Immobilisation Incorporelle">
                </div>
            </div>
            <div class="col-5">
            <h4 class="">PASSIF DE L'ENTREPRISE</h4>
                <div class="mb-2"> 
                    <input type="text" name="total_cmpt_crediteur" class="form-control" required placeholder="Total Compte Créditeur">
                </div>
                <div class="mb-2">
                    <input type="text" name="total_impot_payer" class="form-control" required placeholder="Total Impot à Payer">
                </div>
                <div class="mb-2">
                    <input type="text" name="total_passif_long_terme" class="form-control" required placeholder="Total Passif à Long Terme">
                </div>
                <div class="mb-2">
                    <input type="text" name="total_passif_et_capitaux_propre" class="form-control" required placeholder="Total Passif et Capitaux Propre">
                </div>
            </div>
            <div class="col"></div>
        </div><hr>
        <div class="row bg-light">
            <!-- <h4 class="">ÉTAT DES RÉSULTATS EXCERCICES</h4> -->
            <div class="col"></div>
            <div class="col-5">
                <div class="mb-2"> 
                    <input type="text" name="commune" class="form-control" required placeholder="Commune">
                </div>
                <div class="mb-2">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-4">
                          <input type="text" name="annefiscal1" class="form-control" required placeholder="Ex:<?=date('Y')?>">
                        </div>  
                        <div class="col-2">--</div> 
                        <div class="col-4">
                          <input type="text" name="annefiscal2" class="form-control" required placeholder="Ex:<?=date('Y')+1?>">
                        </div>  
                        <div class="col"></div>
                    </div>
                </div>
                <div class="mb-2">
                    <select class="form-select" name="mois_prelevement" aria-label="Default select example">
                        <option>Mois Anterieur</option>
                        <option value="1">Janvier</option>
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
            <div class="col-5">   
                <div class="mb-2">
                    <input type="text" name="acompte_provisionnel" class="form-control" required placeholder="Acompte Provisionnel">
                </div>
                <div class="mb-2">
                    <input type="text" name="Benefice_imposable" class="form-control" required placeholder="Benefice imposable">
                </div>
                <div class="col"><input class="btn btn-success" type="submit" value="submit"></div>           
            </div>
            <div class="col"></div>
        </div>
    </form>
        </div>
</div>

<div class="container section_table"><br>
<div class="row">
    <!-- <div class="col-2"></div> -->
    <div class="col-12">
    <table class="step table table-bordered table-sm table-striped">
        <thead  class="table-dark">
            <tr>
                <td class="titre"  colspan="7">
                     <strong>Liste des transactions</strong>
                </td>
             </tr>
                <th scope="col">Années Fiscales</th>
                <th scope="col">Mois prelvement</th>
                <th scope="col">Total Actif</th>
                <th scope="col">Total Passif</th>
                <th scope="col">Total Prelevement</th>
                <th scope="col">Acompte provisionel</th> 
                <th scope="col">Date prelevement</th> 
        </thead>
        
        <tbody>
                <?php while($rowSelect = $stateImpSoc->fetch()){?>
                <tr>
                    <th scope="row"> <?php echo $rowSelect['annefiscal1'] ." - ". $rowSelect['annefiscal2'] ; ?> </th>
                    <td class="bcgris"> <?php echo $rowSelect['mois_prelevement']?> HTG</td>
                    <td class="bcgris"><?php echo $rowSelect['total_passif']?>  HTG</td>
                    <td class="bcgris"> <?php echo $rowSelect['total_passif']?> HTG</td>
                    <td class="bcgris"> <?php echo $rowSelect['totalPreleve']?> HTG</td>
                    <td class="bcgris"> <?php echo $rowSelect['acompte_provisionnel']?> HTG</td>
                    <td class="bcgris"> <?php echo $rowSelect['datePreleve']?> HTG</td>
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

.section_table{
    position: relative;
    left: 45px;
}

.btn{
    margin-top: 8px;
    text-transform: uppercase;
}

h3{
    text-align: center;
    margin-top: 50px;
    margin-left: 80px;
} 

.container-fluid{
    position: relative;
    top: 150px;
    right: 30px;
    margin-left: 15px;
}

.container{
    position: relative;
    right: 40px;
}

.bg-light{
    padding-top: 20px;
    padding-bottom: 10px;
}




</style>
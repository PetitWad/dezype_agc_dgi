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

//Verifier les annees fiscal
$reqListerAnne = "SELECT annefiscal2 FROM preleve_taxe_patente WHERE codePatente = :code ";
$statePtente = $bd->prepare($reqListerAnne);
$statePtente->execute([
    'code'=>$code,
]);

foreach($statePtente->fetchAll() as $rowSelect):
    $annefisVerifier2 = $rowSelect['annefiscal2'];
endforeach; 

// Requete qui lister les element du tableau prelevement
   $reqListerPatente = "SELECT * FROM preleve_taxe_patente WHERE codePatente = :code";
   $statePatente = $bd->prepare($reqListerPatente);
   $statePatente->bindValue(':code', $code, PDO::PARAM_INT);
   $statePatente->execute();


if(isset($_POST['submit'])){

$chif_affaire = validateInput($_POST['chif_affaire']);
$masse_sal = validateInput($_POST['masse_sal']);
$impot_deja_paye = validateInput($_POST['impot_deja_paye']);
$annefiscal1 =  date('Y');
$annefiscal2 =  date('Y')+1;
$commune =  validateInput($_POST['commune']);
$dateEnrg = date('Y-m-d');

$anEnrg = FonctionReq::AnneEnreg($code);
$difernce_chifAffaire_et_masseSal = $chif_affaire - $masse_sal;
$impot_partie_variable = $difernce_chifAffaire_et_masseSal * 4 / 1000;
$impot_a_calculer = $impot_partie_variable + 1000;
$prelevment = $impot_a_calculer - $impot_deja_paye;

if($chif_affaire > 0 && $masse_sal > 0){
    $req = $bd->prepare("INSERT INTO preleve_taxe_patente VALUES(:codePatente, :annefiscal1, :annefiscal2, :chif_affaire, :masse_sal, :impot_deja_paye, :impot_a_calculer, :datePreleve, :prelevment, :commune)");
        
        $req->bindParam(':codePatente', $code); 
        $req->bindParam(':annefiscal1', $annefiscal1); 
        $req->bindParam(':annefiscal2', $annefiscal2); 
        $req->bindParam(':chif_affaire', $chif_affaire); 
        $req->bindParam(':masse_sal', $masse_sal); 
        $req->bindParam(':impot_deja_paye', $impot_deja_paye); 
        $req->bindParam(':impot_a_calculer', $impot_a_calculer);
        $req->bindParam(':datePreleve', $dateEnrg); 
        $req->bindParam(':prelevment', $prelevment);
        $req->bindParam(':commune', $commune);

        if($annefiscal1 >= $annefiscal2 || $annefiscal1 > date('Y')){
            header("Location: prelevePatente.php?error=Bien inserer les années fiscales");
        }elseif($annefisVerifier2 == $annefiscal2){
            header("Location: prelevePatente.php?error=Patente pour cette année fiscale est déjà assujéti...");
        }elseif($annefiscal1 < $anEnrg){
            header("Location: prelevePatente.php?error=Année insérer est inférieur à l'année d'enregistrement");
        }else{
            $req->execute();
            header("Location: prelevePatente.php?error=Prelevement effectuer ✔");
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
</div></div></div></div></nav>
<div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-8">
            <h3 class="alert alert-primary">Section Patente | <strong><?php echo strtoupper($rowReq['nom']) .' s.a'?> </strong></h3>
            <form action="prelevePatente.php" method="post">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-7">
                      <?php if(isset($_GET['error'])){ ?>
                          <p class="alert alert-danger"> <?php echo $_GET['error'] ?> </p>
                     <?php } ?>
                    <div class="mb-2">
                       <label for="chif_affaire">Chiffre d'affaires (dernier exercice)</label>
                     </div>
                     <div class="mb-2">
                       <label for="masse_sal">Masse salariale (dernier exercice)</label>
                     </div>
                     <div class="mb-2">
                       <label for="impot_deja_paye">Impot déjà payé </label>
                     </div>
                     <div class="mb-2">
                       <label for="impot_deja_paye">Commune</label>
                     </div>
                </div>
                <div class="col-2">
                    <div class="mb-2">
                         <input type="number" name="chif_affaire" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="number" name="masse_sal" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="number" name="impot_deja_paye" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="text" name="commune" class="form-control"  required>
                     </div><br>
                </div>
                <div class="col-1"></div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <input class="btn btn-success" type="submit" name="submit" value="Enregistrer">
                </div>
            </div>
        </form>
            </div>
            <div class="col-5"></div>
        </div>
        
    </div>
   
<div class="container-fluid">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-8">
        <table class="step table table-bordered table-sm table-striped">
        <thead  class="table-dark">
            <tr>
                <td class="titre"  colspan="7">
                     <strong>Liste des années payer
                </td>
             </tr>
                <th scope="col">Années Fiscales</th>
                <th scope="col">Chiffre d'Affaire</th>
                <th scope="col">Masse Salariale</th>
                <th scope="col">Impot Déjà Payé</th> 
                <th scope="col">Impot à Calculer</th>
                <th scope="col">Prélèvement</th> 
                <th scope="col">Print</th> 
        </thead>
        <tbody>
                <?php while($rowSelect = $statePatente->fetch()){?>
                <tr>
                    <th scope="row"> <?php echo $rowSelect['annefiscal1'] ." - ". $rowSelect['annefiscal2'] ; ?> </th>
                    <td class="bcgris"> <?php echo $rowSelect['chif_affaire']?> HTG</td>
                    <td class="bcgris"><?php echo $rowSelect['masse_sal']?>  HTG</td>
                    <td class="bcgris"> <?php echo $rowSelect['impot_deja_paye']?> HTG</td>
                    <td class="bcgris"><?php echo $rowSelect['impot_a_calculer']?>  HTG</td>
                    <td class="bcgris"><strong style="color:green"><?php echo $rowSelect['impot_a_calculer']?> HTG</strong></td>
                    <td>&nbsp;&nbsp;<a href="impri_patente.php?anne=<?php echo $rowSelect['annefiscal1'] ?>"><i class="bi bi-printer"></i></a>&nbsp;</td>
                </tr>
            <?php } ?> 
        </tbody> 
    </table>
        </div>
        <div class="col-2"></div>
</div>          

</body>
</html>

<style>
    body{
        margin-top: 20px;
    }

    h3{
        text-align: center;
    }

    .container-fluid{
        position: relative;
        top: 30px;
    }

    .form-control{
        height: 30px;
    }

    label{
        padding: 3px;
    }

    .bg-gray{
        background-color: gray;
        padding: 2px;
        border-radius: 3px;
        color: black;
        font-weight: bold;
    }
</style>
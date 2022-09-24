<?php
session_start();
require '../controller/data/connect.php';

$code = $_GET['code'];
var_dump($code);
exit();

//Fonction Validation les champs
function validateInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

if(isset($_POST['submit'])){

$valeur_objet = validateInput($_POST['valeur_objet']);
$frais_transport = validateInput($_POST['frais_transport']);
$pourcentage_douane = validateInput($_POST['pourcentage_douane']);
$taux_tva = validateInput($_POST['taux_tva']);
$frais_dossier = validateInput($_POST['frais_dossier']);

$estimation_droit_douane = ($valeur_objet + $frais_transport) * $pourcentage_douane / 100;
$taxe_tva =  ($estimation_droit_douane + $valeur_objet + $frais_transport) * $taux_tva / 100;

$prelev_tva_douane = $estimation_droit_douane + $taxe_tva + $frais_dossier;

if($valeur_objet > 0 && $frais_transport > 0 && $pourcentage_douane > 0 && $taux_tva > 0 && $frais_dossier > 0){
    $req = $bd->prepare("INSERT INTO preleve_droit_douane VALUES(:dateEnrg, :codeDouane, :valeur_objet, :frais_transport, :pourcentage_douane, :taux_tva, :frais_dossier, :estimation_droit_douane, :taxe_tva, :prelev_tva_douane)");
    $dateEnrg = date('Y-m-d');
        $req->bindParam(':dateEnrg', $dateEnrg); 
        $req->bindParam(':codeDouane', $code , PDO::PARAM_INT); 
        $req->bindParam(':valeur_objet', $valeur_objet); 
        $req->bindParam(':frais_transport', $frais_transport); 
        $req->bindParam(':pourcentage_douane', $pourcentage_douane); 
        $req->bindParam(':taux_tva', $taux_tva);
        $req->bindParam(':frais_dossier', $frais_dossier);
        $req->bindParam(':estimation_droit_douane', $estimation_droit_douane);
        $req->bindParam(':taxe_tva', $taxe_tva);
        $req->bindParam(':prelev_tva_douane', $prelev_tva_douane);
        $req->execute();
}

$reqListerPvDouane = "SELECT * FROM preleve_droit_douane WHERE codeDouane = :code LIMIT 1";
$statePvDouane = $bd->prepare($reqListerPvDouane);
$statePvDouane->execute([
    'code'=>$code,
]);

$rowSelect = $statePvDouane->fetch();

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prelevement droit de douane</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
   </head>
<body>
    <div class="container">
        <form action="prelevDroitDouane.php" method="post">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-7">
                    <div class="mb-2">
                       <label for="valeur_objet">Valeur réelle de l'objet (Gourdes)</label>
                     </div>
                     <div class="mb-2">
                       <label for="frais_transport">Montant des frais de transport : port + assurance (Gourdes)</label>
                     </div>
                     <div class="mb-2">
                       <label for="pourcentage_douane">Pourcentage des droits de douane :</label>
                     </div>
                     <div class="mb-2">
                       <label for="taxe_tva">Taxe sur la Valeur Ajoutée en France : la TVA est de 20 % ou 5.5 % (pourcentage)</label>
                     </div>
                     <div class="mb-2">
                       <label for="frais_dossier">Frais de dossier du transporteur en charge de la perception des droits de douane</label>
                     </div>
                </div>
                <div class="col-2">
                    <div class="mb-2">
                         <input type="number" name="valeur_objet" value="<?= $rowSelect['valeur_objet']?>" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="number" name="frais_transport" value="<?= $rowSelect['frais_transport']?>" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="number" name="pourcentage_douane" value="<?= $rowSelect['pourcentage_douane']?>" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="number" name="taux_tva" value="<?= $rowSelect['taux_tva']?>"  class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input type="number" name="frais_dossier" value="<?= $rowSelect['frais_dossier']?>" class="form-control"  required>
                     </div>
                     <div class="mb-2">
                         <input class="btn btn-success" name="submit" type="submit" value="Enregistrer">
                     </div>
                </div>
                <div class="col-1"></div>
            </div>
        </form>
    </div>
</body>
</html>

<style>
    body{
        margin-top: 20px;
    }
    .form-control{
        height: 30px;
    }
    label{
        padding: 3px;
    }
</style>
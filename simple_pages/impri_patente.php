<?php session_start();
require '../controller/data/connect.php';

$an = $_GET['anne'];
$code = $_SESSION['code'];

// Requete qui lister les element du tableau prelevement
$reqListerAnne = "SELECT * FROM preleve_taxe_patente WHERE annefiscal1 = :annefiscal LIMIT 1";
$statePtente = $bd->prepare($reqListerAnne);
$statePtente->execute([
    'annefiscal'=>$an,
]);

$select = $statePtente->fetchAll();

// Requete qui en charge le numero de la matricule fiscal, le nom social et autre info de l'entreprise
$reqLister = "SELECT * FROM contribuable WHERE code = :code LIMIT 1";
$stateLister = $bd->prepare($reqLister);
$stateLister->execute([
    'code'=>$code
]);
$rowReq = $stateLister->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prelevement Patente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
   </head>
<body  onload="window.print()">
    <div class="container">
        <div class="row">
            <div class="col entete">
                <span><img src="../public/images/palmiste.png" alt=""></span>
                <p>REPUBLIQUE D'HAÏTI<br>MINISTERE DE L'ÉCONOMIE ET DES FINANCES <br> DIRECTION GÉNERALE DES IMPOTS </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h4>CERTIFICAT DE PATENTE</h4>
            <?php foreach($select as $rowSelect): ?>
                <div class="content-text">
                  <p>Numéro patente : &nbsp;<em><?php echo $rowSelect['codePatente'] ?></em></p>
                  <p>Pour l'exercice fiscale : <em><?php echo $rowSelect['annefiscal1'] ?> - <?php echo $rowSelect['annefiscal2'] ?></em></p>
                  <p> Délivre à : <em><?php echo $rowReq ['nom'] ?></em></p>
                  <p> Numéro d'immatriculation fiscale : <?php echo $rowReq ['nif'] ?></p>
                  <p> Résident au : <em><?php echo $rowReq ['adresse'] ?></em></p>
                  <p> Commune : <em><?php echo $rowSelect['commune'] ?></em></p>
                  <p> Pour le secteur d'activité économique :  <br><em><?php echo $rowReq ['nomsecteur'] ?></em></p>
              </div>
                
                <p class="pied-feuille">
                    Fait à : <?php echo $rowSelect['commune'] ?><br>
                    Le <?php echo date('d-m-Y')?>
                </p>
                <div id="signature">     _____________________
                     <p class="signature">Diretion Génerale</p>
                </div>
           <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>

<style>
    .container{
        font-family: 'Courier New', Courier, monospace;
        border: thick double black;
        width: 820px;
        height: 700px;
    }

    .entete{
        text-align: center;
        font-weight: bold;
        margin-top: 30px;
    }

    .entete img{
        width: 120px;
    }

    h4{
        font-weight: bolder;
        text-align: center;
    }

    .content-text{
        position: relative;
        left: 150px;
        top: 30px;
    }

    .content-text p{
        margin-top: -7px;
    }

    .pied-feuille{
        position: relative;
        left: 34px;
        top: 65px;
    }

    #signature{
        float: right;
        margin-right: 20px;
        margin-top: 60px;
    }

    .signature{
        margin-left: 12px;
    }


</style>
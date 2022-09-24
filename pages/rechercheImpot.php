<?php 
 require '../controller/data/connect.php';
    if(isset($_GET['code'])){
    $code = intval($_GET['code']);

    $reqSQL = "SELECT * FROM contribuable WHERE code = :code";
    $stateCont = $bd->prepare($reqSQL);
    $stateCont->execute([
        ':code' => $code
    ]);

   $rsltAll = $stateCont->fetch();

   
   $reqSqlTMS = "SELECT MAX(datePreleve) as derniere_date FROM preleve_taxe_masse_sal WHERE code = :code";
   $stateTMS = $bd->prepare($reqSqlTMS);
   $stateTMS->execute([
       ':code' => $code
   ]);

   $rowAll = $stateTMS->fetchAll();

   foreach($rowAll as $rslTMS):
     $rowFind = $rslTMS['derniere_date'];
   endforeach;


   $reqSqlTCA = "SELECT MAX(datePreleve) as derniere_date FROM preleve_taxe_chif_affaire WHERE code = :code";
   $stateTCA = $bd->prepare($reqSqlTCA);
   $stateTCA->execute([
       ':code' => $code
   ]);

   $rowAllTCA = $stateTCA->fetchAll();

   foreach($rowAllTCA as $rslTCA):
     $rowFindTCA = $rslTCA['derniere_date'];
   endforeach;

;

 

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
        <title>Recherche</title>
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
            <div id="layoutSidenav_content">
        <div class="row blockRapport"> 
        <div id="style_revenu_masse" class="col-12">
            <!-- debut entete  -->
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
              <div class="col-8">
              <h5 class="alert alert-secondary">Rapport de la dernière date paiement de l'Entreprises  <em class="text-primary"> <strong><?= $rsltAll['nom'] ?> </strong> </em></h5>
              </div>
        <!-- </div></div></div></div></div></div></div> -->

        <div class="container content_search">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-9">
                    <p>
                    <strong><?= $rsltAll['nom'] ?> </strong>  est une entreprise Haïtienne qui est enregistré au numero <strong><?= $rsltAll['nif'] ?></strong>  et son code fiscal est le: <strong><?= $rsltAll['code'] ?></strong>
                       Elle est une société <strong><?= $rsltAll['typesociete'] ?></strong>  qui évolue dans le secteur <strong><?= $rsltAll['nomsecteur'] ?>.</strong><br>
                        <strong>Adresse : <em> <?= $rsltAll['adresse'] ?> </em></strong>  |  <strong>Adresse : <em> <?= $rsltAll['telephone'] ?> </em></strong> 
                    </p>
                    <div class="row">
                        <!-- <div class="col-2"></div> -->
                        <div class="col">
                            Dernière déclaration (Taxe Masse Salariale)<br>
                           <strong> Le  <?=  $rowFind  ?></strong> 
                        </div>
                        <div class="col">
                        Dernière déclaration(Impot sur les Sociétés)<br>
                        <strong> Le  <?=  $rowFindTCA  ?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>


</body>


<style>
    .ccontent_search p{
       position: relative;
       top: 200px;
    }

</style>
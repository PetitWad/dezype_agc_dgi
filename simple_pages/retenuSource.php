<?php  session_start();
require '../controller/data/connect.php';
require_once 'config.php';
$code = $_SESSION['code'];




   // Requete qui lister les element du tableau prelevement
   $reqListerRetenu = "SELECT * FROM retenu_a_source WHERE code = :code";
   $stateRetenu = $bd->prepare($reqListerRetenu);
   $stateRetenu->bindValue(':code', $code, PDO::PARAM_INT);
   $stateRetenu->execute();


    if(isset($_POST['submit'])){
        $salaire_mensuel = $_POST['salaire_mensuel'];
        $impot_total = $_POST['impot_total'];
        $bonus = $_POST['bonus'];
        $revenu_distribuer = $_POST['revenu_distribuer'];
        $annefiscal1 = $_POST['annefiscal1'];
        $annefiscal2 = $_POST['annefiscal2'];
        $mois = $_POST['mois_prelevement'];
        $commune = $_POST['commune'];

        $rslt_bonus = $bonus * 0.1;
        $rslt_revenu_distribuer = $revenu_distribuer * 0.2;
        $rslt_fdu_et_cas = $salaire_mensuel * 0.1;

        $pay = $rslt_bonus + $rslt_revenu_distribuer + $rslt_fdu_et_cas;


    $req = $bd->prepare("INSERT INTO retenu_a_source VALUES(:code, :annefiscal1, :annefiscal2, :mois, :salaire_mensuel, :bonus, :revenu_distribuer, :caisse_assistance, :font_urgence, :datePreleve, :commune)");

    $dateEnrg = date('Y-m-d');
    $req->bindParam(':code', $code);
    $req->bindParam(':annefiscal1', $annefiscal1);
    $req->bindParam(':annefiscal2', $annefiscal2);
    $req->bindParam(':mois', $mois);
    $req->bindParam(':salaire_mensuel', $salaire_mensuel);
    $req->bindParam(':bonus', $rslt_bonus);
    $req->bindParam(':revenu_distribuer', $revenu_distribuer);
    $req->bindParam(':caisse_assistance', $rslt_fdu_et_cas);
    $req->bindParam(':font_urgence', $rslt_fdu_et_cas);
    $req->bindParam(':datePreleve', $dateEnrg);
    $req->bindParam(':commune', $commune);
    $reqOk = $req->execute();

    if($reqOk){
          header("Location: pay.php?pay=".$pay);
        }else{
        header("Location: retenuSource.php?error=Erreur d'enregistrement 🚫");
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
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>retenu a la source</title>
</head>
<body>
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
            <!-- </div></div></div></nav> -->

            <div class="container-fluid" style="position: relative; top: 300px;">
                <div class="row">
                <?php if(isset($_GET['error'])){ ?>
                    <p class="alert alert-danger"> <?php echo $_GET['error'] ?> </p>
                <?php } ?>
                    <div class="col-"></div>
                    <div class="col-8">
                    <form action="retenuSource.php" method="POST">
                        <div class="bg-gray mb-2" style="padding: 5px; background-color:gray; color: white;">
                            <label for="chiffre_affaire">salaires | Montant mensuel</label>
                        </div>
                        <div class="bg-gray mb-2" style="padding: 5px; background-color:gray; color: white;">
                            <label for="chiffre_affaire">salaire | Impot total a payer</label>
                        </div>
                        <div class="bg-gray mb-2"  style="padding: 5px; background-color:gray; color: white;">
                            <label for="chiffre_affaire">Total bonis mensuel</label>
                        </div>
                        <div class="bg-gray mb-2" style="padding: 5px; background-color:gray; color: white;">
                            <label for="chiffre_affaire">Revenu distribuer  | Monyant total mensuel</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-1">
                            <input type="number" name="salaire_mensuel" class="form-control" placeholder="Montant"  required>
                       </div>
                       <div class="mb-1">
                            <input type="number" name="impot_total" class="form-control" placeholder="Montant"  required>
                       </div>
                       <div class="mb-1">
                            <input type="number" name="bonus" class="form-control" placeholder="Montant"  required>
                       </div>
                       <div class="mb-2">
                            <input type="number" name="revenu_distribuer" class="form-control" placeholder="Montant"  required>
                       </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                           <label for="Commune">Commune</label>
                        <div class="mb-2">
                            <input type="text" name="commune" class="form-control" placeholder="Commune"  required>
                       </div>

                    </div>
                        <div class="col-3">
                            <div class="mb-2">
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
                    </div>
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
                </div>
                <div class="col-4">
                    <!--  form paiment avec stripe API PHP -->
                        <!-- <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_51LlY2LHxPTQ0uXfNHvH6FErV7LOC07Q8zLLy17pURCVJShPWTdoSJnxx2AVl5yYcGmIesbUTYydmQjuNmrltN80W009HM5Lnqm"
                            data-amount="600"
                            data-name="AGC-DGI"
                            data-description="Direction Generale des Impots"
                            data-locale="auto"
                            data-image= ""
                            data-currency="USD"
                            data-label="Valider | Payer">
                        </script> -->
                  <input class="btn btn-success" type="submit" name="submit" value="Declarer">
                </div>
            </form>
                </div>
            </div>

        <div class="container-fluid"style="position: relative; top: 370px; right: 60px">
        <div class="row">
            <div class="col"></div>
            <div class="col-12">
                <table class="step table table-bordered table-sm table-striped">
                  <thead  class="table-dark">
                <tr>
                    <td class="titre"  colspan="7">
                    <h6>Liste des transactions</h6>
                    </td>
                </tr>
                    <th scope="col">Annee fiscale</th>
                    <th scope="col">Mois</th>
                    <th scope="col">Salaire Mensuel</th>
                    <th scope="col">Fond d'urgence</th>
                    <th scope="col">Caisse assistance sociale</th>
                    <th scope="col">date Preleve</th>
                </thead>
                <tbody>
                    <?php while($rst =  $stateRetenu->fetch()){?>
                    <tr>
                        <th scope="row"> <?= $rst['annefiscal1'] ." - ". $rst['annefiscal2'] ; ?> </th>
                        <td class="bcgris"> <?= $rst['mois']?></td>
                        <td class="bcgris"> <?= $rst['salaire_mensuel']?> HTG</td>
                        <td class="bcgris"><?= $rst['font_urgence']?>  HTG</td>
                        <td class="bcgris"> <?= $rst['caisse_assistance']?> HTG</td>
                        <td class="bcgris"> <?= $rst['datePreleve']?></td>
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

    .section_form{
        position: absolute;
        top: 370px;
    }

    .bg-gray{
        background-color: gray;
        padding: 6px;
        border-radius: 3px;
        color: black;
        font-weight: bold;
    }
</style>
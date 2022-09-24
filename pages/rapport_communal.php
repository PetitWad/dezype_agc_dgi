 <?php 
 session_start();
require '../controller/data/connect.php';

$commune =$_SESSION['commune'];
$tableTMS = 'preleve_taxe_masse_sal';
$tableTCA = 'preleve_taxe_chif_affaire';
$tatbleSoc = 'preleve_taxe_societe';

if(isset($_POST['checkName']) || isset($_POST['searchYear']) || isset($_POST['mois'])){
    $selectFind = $_POST['checkName'];
    $searchYear = $_POST['searchYear'];
    $moisCherche = intval($_POST['mois']);
    
//    Requette total prelevement masse salariale
   $reqTMS = "SELECT SUM(totalPreleve) as sumPrTMS FROM preleve_taxe_masse_sal WHERE commune = :commune AND annefiscal2 = :searchYear AND mois = :moisCherche";
   $statePvTMS = $bd->prepare($reqTMS);
   $statePvTMS->execute([
       ':commune'=>$commune,
       ':searchYear'=>$searchYear,
       ':moisCherche'=>$moisCherche 
   ]);

    $rslt = $statePvTMS->fetchAll();

    foreach($rslt as $rstRow){
        $totalTMS = $rstRow['sumPrTMS'];
    }



    // Requette total prelevement Patente
    $reqPatente = "SELECT SUM(prelevment) as sumPrePatent FROM preleve_taxe_patente WHERE commune = :commune AND annefiscal2 = :searchYear";
    $statePatente= $bd->prepare($reqPatente);
    $statePatente->execute([
        ':commune'=>$commune,
        ':searchYear'=>$searchYear,
        // ':moisCherche'=>$mois 
    ]);

    $rslt = $statePatente->fetchAll();
    
    foreach($rslt as $rstRow){
        $totalPatente = $rstRow['sumPrePatent'];
    }

        // Requette total prelevement chiffre d'ffaire
        $reqChifAffaire = "SELECT SUM(totalPreleve) as sumPreChifAff FROM preleve_taxe_chif_affaire WHERE commune = :commune AND annefiscal2 = :searchYear AND mois = :moisCherche";
        $stateChifAff= $bd->prepare($reqChifAffaire);
        $stateChifAff->execute([
            ':commune'=>$commune,
            ':searchYear'=>$searchYear,
            ':moisCherche'=>$moisCherche 
        ]);
    
        $rslt = $stateChifAff->fetchAll();
        foreach($rslt as $rstRow){
            $totalChifAff = $rstRow['sumPreChifAff'];
        }

    }

    //@SQL Fonction sql qui lister les donnees des tables pour une annee fiscal
    function Rappor_table($table, $commune){
        require '../controller/data/connect.php';
        $an1 = date('Y');
        $an2 = date('Y')+1;
        $reqSQL = "SELECT * FROM $table WHERE annefiscal1 = :an1 AND annefiscal2 = :an2 AND commune = :commune";
        $revenuStatement = $bd->prepare($reqSQL);
        $revenuStatement->execute([
            ':an1'=>$an1,
            ':an2'=>$an2,
            ':commune'=>$commune
        ]);
        $rowReq = $revenuStatement->fetchAll();
        

        foreach($rowReq as $line){
            $link = "rechercheImpot.php?code=".$line['code'];
            echo '<tr>';
            echo '<th scope="col"><a href="'.$link.'">'.$line['code'].'</a></th>',"\n";
            echo '<th scope="col">'.$line['datePreleve'].'</th>',"\n";
            echo '<th scope="col">'.$line['totalPreleve'].'</th>',"\n";
            echo '</tr>';
        }

    }

    // @Function SQl qui permet de rechercher dans les tables 
    function Rechercher($tableR, $varR, $commune){
        require '../controller/data/connect.php';
        if(isset($varR) && !empty($varR)){    
    
        //@SQL requete qui permet d'authentifier pour un super utilisateur
            $sqlSugestion = $bd->prepare("SELECT * FROM $tableR WHERE commune = ? AND code LIKE ?");
            $sqlSugestion->execute(array(
                $commune,
                "%$varR%"
            ));
            $rsltRecheche = $sqlSugestion->fetchAll();     
    
            foreach($rsltRecheche as $lineR){
                $link = "./rechercheImpot.php?code=".$lineR['code'];
                echo '<tr>';
                echo '<th scope="col"><a href="'.$link.'">'.$lineR['code'].'</a></th>',"\n";
                echo '<th scope="col">'.$lineR['datePreleve'].'</th>',"\n";
                echo '<th scope="col">'.$lineR['totalPreleve'].'</th>',"\n";
                echo '</tr>';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../pages/taxe_masse_salariale.php"/>
    <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <title>Rapport</title>
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
            <div class="col"></div>
              <div class="col-10">
              <h5 class="alert alert-secondary">Liste Entreprises actif pour l'année fiscale <em class="text-primary"> <?php echo  date('Y').' - '. date('Y')+1 ." | ". strtoupper($commune); ?></em></h5>

<!-- ------------------------------TMS Tableau--------------------------------------------- -->
<div class="row barre-titre">
        <div class="col-9 ">        
            <h4><i id="btn_tms_hide" class="bi bi-arrow-down-circle-fill text-primary"></i> <i id="btn_tms_show" class="bi bi-arrow-up-circle-fill text-primary"></i> Liste Taxe sur la Masse Salariale</h4>
        </div>
        <div class="col-3">
            <form action="#" method="GET">
                <input  style="margin-bottom: 10px;" class="form-control" name="r_tms" type="text" placeholder="Search by code fiscal">
            </form>
        </div>
    </div>    
<div id="identifiant_tms">
    <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                    <table class="step table table-bordered table-sm table-striped">
                        <thead  class="table-dark">
                                <th scope="col">Code Fiscal</th>
                                <th scope="col">Date transaction</th>
                                <th scope="col">Montant</th>
                        </thead>
                        <tbody>  
                             
                             <tr>
                                <?php if(empty($_GET['r_tms'])){
                                    echo Rappor_table($tableTMS, $commune); 
                                    }else{
                                        echo Rechercher($tableTMS, $_GET['r_tms'], $commune);
                                    } 
                                ?>
                            </tr>
                        </tbody> 
                    </table>
                </div>
            </div> 
        </div>
    </div>
<br>
<!-- --------------------------------TCA tableau------------------------------------------- -->
<div class="row barre-titre">
        <div class="col-9 ">        
        <h4><i id="btn_tca_hide" class="bi bi-arrow-down-circle-fill text-primary"></i> <i id="btn_tca_show" class="bi bi-arrow-up-circle-fill text-primary"></i> Liste Taxe sur les Chiffres d'Affaires</h4>
        </div>
        <div class="col-3">
            <form action="#" method="GET">
                <input  style="margin-bottom: 10px;" class="form-control" name="r_tca" type="text" placeholder="Search by code fiscal">
            </form>
        </div>
</div>
<div id="identifiant_tca">
    <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <table class="step table table-bordered table-sm table-striped">
                    <thead  class="table-dark">
                            <th scope="col">Code Fiscal</th>
                            <th scope="col">Date transaction</th>
                            <th scope="col">Montant</th>
                    </thead>
                    <tbody>
                            <tr>
                                <?php if(empty($_GET['r_tca'])){
                                     echo Rappor_table($tableTCA, $commune); 
                                    }else{
                                        echo Rechercher($tableTCA, $_GET['r_tca'], $commune);
                                    } 
                                ?>
                            </tr>
                    </tbody> 
                </table>
            </div>
        </div> 
    </div>
</div>  <br>
<!-- ----------------------------------Impot sur les societes------------------------------ -->
<div class="row barre-titre">
        <div class="col-9 ">        
        <h4><i id="btn_soc_hide" class="bi bi-arrow-down-circle-fill text-primary"></i> <i id="btn_soc_show" class="bi bi-arrow-up-circle-fill text-primary"></i> Liste Impot sur les Societes</h4>
        </div>
        <div class="col-3">
            <form action="#" method="GET">
                <input  style="margin-bottom: 10px;" class="form-control" name="r_soc" type="text" placeholder="Search by code fiscal">
            </form>
        </div>
</div>
<div id="identifiant_soc">
    <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <table class="step table table-bordered table-sm table-striped">
                    <thead  class="table-dark">
                            <th scope="col">Code Fiscal</th>
                            <th scope="col">Date transaction</th>
                            <th scope="col">Montant</th>
                    </thead>
                    <tbody>
                            <tr>
                                <?php if(empty($_GET['r_soc'])){
                                     echo Rappor_table($tatbleSoc, $commune); 
                                    }else{
                                        echo Rechercher($tatbleSoc, $_GET['r_soc'], $commune);
                                    } 
                                ?>
                            </tr>
                    </tbody> 
                </table>
            </div>
        </div> 
        </div>
    </div>
</div>
    <div class="col"></div>
</div><br><br>
<!-- -------------------------------------------------------------------------------------- -->


    <div class="container-fluid">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
            <h5 class="alert alert-secondary">Rapport recette de l'assiette fiscale <em class="text-primary"> <?php echo " | ". strtoupper($commune); ?></em></h5>
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row">
            <div class="col-4">
                <form action="./rapport_communal.php" method="POST">
                    <div class="row formSearch">
                        <p class="bg-light"><strong>Filtrer votre rapport</strong> <button type="submit" class="btn btn-primary btn-filtre">Filtrer</button></p>
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="checkName[]" value="TMS" checked="checked">
                                <label for="form-check-label" for="checkNameLabel">Masse taxe Salariale</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="checkName[]" value="ImpSoc" checked="checked">
                                <label for="form-check-label" for="checkNameLabel">Impot Societe</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="checkName[]" value="ChifAffaire"checked="checked">
                                <label for="form-check-label" for="checkNameLabel">Chiffre d'Affaire</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="checkName[]" value="Patente" checked="checked">
                                <label for="form-check-label" for="checkNameLabel">Patente</label>
                            </div>
                        </div>
                        <div class="col-4">
                        <div class="mb-2">
                                <strong><label for="form-control"> Anné/Mois </label></strong>
                                <input type="text" name="searchYear" class="form-control" value="<?php echo date('Y'); ?>">
                            </div>
                            <div class="mb-2">
                            <select name="mois" class="form-select" aria-label="Default select" > 
                                    <option value="01">Jan</option>
                                    <option value="02">Fev</option>
                                    <option value="03">Mars</option>
                                    <option value="04">Avr</option>
                                    <option value="05">Mai</option>
                                    <option value="06">Juin</option>
                                    <option value="07">Juil</option>
                                    <option value="08">Aout</option>
                                    <option value="09">Sept</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div>
                    </div>   
                </form>
            </div>
            <div class="col"></div>
            <div class="col-6">
                <table class="step-primary table table-md table-striped">
                    <th>Type prélèvement</th>
                    <th>Date</th>
                    <th>Montant Total</th>
                <?php if(isset($selectFind)){ foreach($selectFind as $valueFind){ ?>
                    <div class="col-6">
                    <tr> <?php if($valueFind  == 'TMS'){ ?>
                        <th scope="row">Taxe sur la masse salariale</th>
                        <td class="bcgris"><?php echo"$moisCherche - $searchYear" ?></td>
                        <td class=""><strong><?php echo ($totalTMS == null) ? '0 HTG' : $totalTMS.' HTG ' ?></strong></td>
                    </tr>
                    <tr><?php }elseif($valueFind  == 'Patente'){ ?>
                        <th scope="row"> Patente</th>
                        <td class="bcgris"><?php echo"$searchYear" ?></td>
                        <td class=""><strong><?php echo ($totalPatente == null) ? '0 HTG' : $totalPatente.' HTG ' ?></strong></td>
                    </tr>
                    <tr><?php }elseif($valueFind  == 'ImpSoc'){ ?>
                        <th scope="row">Impot sur les societes</th>
                        <td class="bcgris"><?php echo"$moisCherche - $searchYear" ?></td>
                        <td class=""><strong><?php echo ($totalChifAff == null) ? '0 HTG' : $totalChifAff.' HTG ' ?></strong></td>
                    </tr>
                    <tr><?php }elseif($valueFind  == 'ChifAffaire'){ ?>
                        <th scope="row">Taxe sur les chiffres d'affaires</th>
                        <td class="bcgris"><?php echo"$moisCherche - $searchYear" ?></td>
                        <td><strong><?php echo ($totalChifAff == null) ? '0 HTG' : $totalChifAff.' HTG ' ?></strong></td>
                        
                    <!--fin lister pour un seul cas Et debut pour deux cas -->
                    <tr> <?php }elseif($valueFind  == 'TMS' && $valueFind  == 'Patente'){ ?>
                        <th scope="row">Taxe sur la masse salariale</th>
                        <td class="bcgris">2022</td>
                        <td class=""><strong><?php echo $totalTMS .' HTG ' ?></strong></td>
                    </tr>
                    <tr>
                        <th scope="row">Patente</th>
                        <td class="bcgris"><?php echo"$mois - $searchYear" ?></td>
                        <td class=""><strong><?php echo $totalPatente .' HTG ' ?></strong></td>
                    </tr><?php }elseif($valueFind  == 'TMS' && $valueFind  == 'ImpSoc'){ ?>
                    <tr> 
                        <th scope="row">Taxe sur la masse salariale</th>
                        <td class="bcgris"><?php echo"$mois - $searchYear" ?></td>
                        <td class=""><strong><?php echo $totalTMS .' HTG ' ?></strong></td>
                    </tr>
                    <tr>
                        <th scope="row">Impot sur les societes</th>
                        <td class="bcgris"><?php echo"$mois - $searchYear" ?></td>
                        <td class=""><strong><?php echo $totalChifAff .' HTG ' ?></strong></td>
                    </tr><?php }elseif($valueFind  == 'TMS' && $valueFind  == 'ChifAffaire'){ ?>
                    <tr> 
                        <th scope="row">Taxe sur la masse salariale</th>
                        <td class="bcgris"><?php echo"$mois - $searchYear" ?></td>
                        <td class=""><strong><?php echo $totalTMS .' HTG ' ?></strong></td>
                    </tr>
                    <tr>
                        <th scope="row">Taxe sur les chiffres d'affaires</th>
                        <td class="bcgris"><?php echo"$mois - $searchYear" ?></td>
                        <td><strong><?php echo $totalChifAff .' HTG ' ?></strong></td>
                    
                   
                </table>
                <?php } ?>
                <?php }
                  }else{ ?>
                    <p class="alert alert-primary">Bien filtrer pour mieux rapporter...</p>
                  <?php } ?>
                </div>
            <div class="col"></div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
        <script src="display_bloc_rapport.js"></script>

</body>
</html>

<style>
    i{
        cursor: pointer;
    }

    .barre-titre h4, input{
        margin-top: 10px;
    }

    .barre-titre{
        background-color: wheat;
    }

.blockRapport{
    position: relative;
    top: -60px;
}

.btn-filtre{
    position: relative;
    left: 100px;
}
.error{
    color: red;
    font-size: 18px;
    font-weight: bolder;
}

#btn-operation{
    margin-top: 50px;
}

#style_revenu_masse{
    margin-top: 40px;
}

#firstRow, #secondRow{
    margin-right: 3px;
    padding: 12px;
}

.titre-revenu h2{
    margin-top: 80px;
}
body{
        margin-top: 30px;
    }
.btn-group{
    margin-top:-120px;
}
.col-5 .dgi{
margin-top:-100px;
}
.col-5{
    margin-top:-30px;  
}
.submit{
margin-bottom:30px;
}
h6{
    font-weight:bold;
    color:red;
}
</style>

</style>
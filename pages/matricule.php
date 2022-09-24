<?php 
require '../controller/data/connect.php';
require '../fonctions/FonctionCode.php';


if(isset($_POST['submit'])){
    $codeNif = FonctionCode::codeNif();
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $activite = $_POST['activite'];
    $nom_complet_agent = $_POST['nom_complet_agent'];
    $lieu_emission = $_POST['lieu_emission'];
    $date_emission = date('d-m-Y');
    $cin = $_POST['cin'];

// Verification nif existant
    $reqSQL = "SELECT * FROM matricule_fiscale WHERE cin = :cin";
    $stmnt = $bd->prepare($reqSQL);
    $stmnt->execute([
        ':cin' =>  $cin
    ]);
    $restlAllRow = $stmnt->fetch();


    if($cin == $restlAllRow['cin'] && $nom == $restlAllRow['nom'] && $prenom == $restlAllRow['prenom']){
        header("Location: matricule.php?error=Cette personnes est deja existe 😰");
    }else{
        $req = $bd->prepare("INSERT INTO matricule_fiscale VALUES(null, :nif, :nom, :prenom, :adresse, :activite, :nom_complet_agent, :lieu_emission, :date_emission, :cin)");

        $req->bindParam(':nif',$codeNif); 
        $req->bindParam(':nom',$nom); 
        $req->bindParam(':prenom',$prenom);
        $req->bindParam(':adresse',$adresse); 
        $req->bindParam(':activite',$activite); 
        $req->bindParam(':nom_complet_agent',$nom_complet_agent); 
        $req->bindParam(':lieu_emission',$lieu_emission);
        $req->bindParam(':date_emission',$date_emission); 
        $req->bindParam(':cin',$cin);
        $req->execute();
        header("Location: impri_matricule.php?nif=$codeNif");
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
    <title>Impot</title>
</head>

<body class="sb-nav-fixed"
    style="background-color:white;
    background-attachment: fixed;">

    <div class="container-fluid">
        <?php include_once('navbar.php');?>
            <div id="layoutSidenav">
                <?php 
                    require '../fonctions/authentifier.php';
                    est_connecter();
                    include_once('dashboard.php');
                ?>
          </div>     
          <div class="container-fluid forme-matricule">
          <form action="matricule.php" method="POST">
            <div class="row">
                <center><h2 class="text-primary">Section Matricule Fiscale</h2></center>
                <center>
                    <?php if(isset($_GET['error'])){ ?>
                      <p class="text-danger"> <?php echo $_GET['error'] ?> </p>
                    <?php } ?>
                </center>
                    <div class="col-2"></div>
                    <div class="col-5">
                        <div class="mb-2">
                            <div class="row">
                                <div class="col"> 
                                    <label for="nomsecteur">NOM :</label>
                                     <input type="text" class="form-control" name="nom" required></div>
                                <div class="col">
                                    <label for="nomsecteur">PRENOM :</label>
                                    <input type="text" class="form-control" name="prenom" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="nomsecteur">PROFESSION / SECTEUR ACTIVITE :</label>
                            <input type="text" class="form-control" name="activite" required>
                        </div>
                        <div class="mb-2">
                            <label for="nomsecteur">Adresse :</label>
                            <input type="text" class="form-control" name="adresse" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="mb-2">
                            <label for="nomsecteur">NOM COMPLET AGENT :</label>
                            <input type="text" class="form-control" name="nom_complet_agent" required>
                        </div>
                        <div class="mb-2">
                        <div class="row">
                                <div class="col"> 
                                    <label for="nomsecteur">LIEU D'EMISSION :</label>
                                     <input type="text" class="form-control" name="lieu_emission" required></div>
                                <div class="col">
                                    <label for="nomsecteur">DATE EMISSION :</label>
                                    <input type="text" class="form-control" name="date_emission" disabled placeholder="Automatique">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="nomsecteur">CIN CLIENT :</label>
                                <input type="text" class="form-control" name="cin" required>
                            </div>
                        <div class="mb-2">
                            <input type="submit" name="submit" class="btn btn-success" value="CRÉER">
                             <a href="auth_matricule.php" class="btn btn-primary">IMPRIMER MATRICULE</a>
                        </div>
                            </div>
                        </div>
                    </div>
                </form>
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
.forme-matricule{
    position: relative;
    top: 70px;
}

h2{
    position: relative;
    left: 20px;
    margin-bottom: 30px;
}
</style>
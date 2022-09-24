<?php
session_start();
require '../controller/data/connect.php';
$code = $_POST['code'];

      $reqUpdate = 'UPDATE contribuable SET  periode = :periode, typesociete = :typesociete, nif = :nif,
                    adresse = :adresse, telephone = :telephone, nom = :nom, ville = :ville, 
                    email = :email, nomsecteur = :nomsecteur WHERE code = :code';

    $stateUpdate = $bd->prepare($reqUpdate);

    $stateUpdate->bindValue(':code', $_POST['code'], PDO::PARAM_INT);     
    $stateUpdate->bindValue(':periode', $_POST['periode'], PDO::PARAM_STR);
    $stateUpdate->bindValue(':typesociete', $_POST['typesociete'], PDO::PARAM_STR);
    $stateUpdate->bindValue(':nif', $_POST['nif'], PDO::PARAM_INT);
    $stateUpdate->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
    $stateUpdate->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_INT);
    $stateUpdate->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
    $stateUpdate->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
    $stateUpdate->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $stateUpdate->bindValue(':nomsecteur', $_POST['nomsecteur'], PDO::PARAM_STR);
 
    $reqOk = $stateUpdate->execute();

    if($reqOk){ 
        $_SESSION['code'] = $code;
        header("Location: ../pages/impri_impot.php?code=$code");
    }else{
        header("Location: ../pages/update_.php?error=Année fiscal incorrect ❌"); 
    }

    
?>


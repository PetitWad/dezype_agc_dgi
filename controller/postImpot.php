<?php
session_start();
require 'data/connect.php';
require '../fonctions/FonctionCode.php';

function validateInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}


$periode =validateInput($_POST['periode']);
$typesociete =validateInput($_POST['typesociete']);
$dateEnrg = date('Y-m-d');
$nif =validateInput($_POST['nif']);
$adresse =validateInput($_POST['adresse']);
$telephone =validateInput($_POST['telephone']);
$nom =validateInput($_POST['nom']);
$ville =validateInput($_POST['ville']);
$email =validateInput($_POST['email']);
$nomsecteur =validateInput($_POST['nomsecteur']);


$reqSQL = "SELECT * FROM impot WHERE email = :email  and nif = :nif";
$taxtStatement = $bd->prepare($reqSQL);
$taxtStatement->execute([
    ':email'=>$email,
    ':nif'=>$nif,
]);

$rowReq = $taxtStatement->fetchAll();

foreach($rowReq as $rowSelect):
    $nifverifier = $rowSelect['nif'];
    $emailverifier = $rowSelect['email'];
    $codeverifier =  $rowSelect['code'];
endforeach;


if( $nifverifier == $nif && $emailverifier == $email && $code == $codeverifier){
    header("Location: ../pages/impot.php?error=Ce contribuable est deja existe");
}else{
   
$req = $bd->prepare("INSERT INTO contribuable VALUES(:code, :periode, :typesociete, :dateEnrg,  :nif, :adresse,
:telephone, :nom, :ville, :email, :nomsecteur)");

$code =  FonctionCode::codeImpot();

$req->bindParam(':code', $code); 
$req->bindParam(':periode', $periode); 
$req->bindParam(':typesociete', $typesociete); 
$req->bindParam(':dateEnrg', $dateEnrg);
$req->bindParam(':nif', $nif);
$req->bindParam(':adresse', $adresse);
$req->bindParam(':telephone', $telephone);
$req->bindParam(':nom', $nom);
$req->bindParam(':ville', $ville);
$req->bindParam(':email', $email);
$req->bindParam(':nomsecteur', $nomsecteur);


    if($dateEnrg == date('Y-m-d') ){
        $_SESSION['code'] = $code;
        $req->execute(); 
        header("Location: ../pages/impri_impot.php?code=$code");  
    }else{
        header("Location: ../pages/impot.php?error=Date enregistrement incorrect ❌"); 
    }

}          

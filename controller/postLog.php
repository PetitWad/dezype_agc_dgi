<?php
session_start();
require 'data/connect.php';
require '../fonctions/authentifier.php';


/*
* @funtion qui valider et formaterles donnees saisies par les users
*/
function validateInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


/*
* Recuperation des donnees dans le formulaire
*/
$user = strtolower(validateInput($_POST['user_dgi']));
$pwd = strtolower(validateInput($_POST['code_dgi']));

$reqSQL = "SELECT * FROM simple_user WHERE simple_user_nom = :nom AND  simple_user_code = :code LIMIT 1";
$statementRow = $bd->prepare($reqSQL);

$statementRow->bindValue(':nom', $user, PDO::PARAM_STR);
$statementRow->bindValue(':code', $pwd, PDO::PARAM_STR);
$statementRow->execute();

$restlRow = $statementRow->fetch();


/*
* @condition pour qu'un super  et un simple user soient connecter
*/


if(isset($user) and isset($pwd)){
    if(empty($user)){
        header("Location: ../index.php?error= Put your username");
    }elseif(empty($pwd)){
        header("Location: ../index.php?error= Put your password");
    }else{
        if(strtolower($restlRow['simple_user_nom']) == $user && strtolower($restlRow['simple_user_code']) == $pwd){
            header("Location: ../simple_pages/simple_user.php");
        }elseif($user === 'dgi' && $pwd==12345){
            header("Location: ../pages/super_user.php");
        }else{
            header("Location: ../index.php?error= Your password or username is incorrect");
        }
    }

}




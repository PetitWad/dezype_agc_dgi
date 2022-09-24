<?php
function est_connecter(): bool{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    return !empty($_SESSION['connecte']);
}

function acccess_to_connect():void{
    if(!est_connecter()){
        header("Location: /index.php");
        exit();
    }
}

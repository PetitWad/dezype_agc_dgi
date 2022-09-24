<?php
require 'bd_config.php';

try{
    $bd = new PDO($bd_dns, $bd_username, $bd_pass, $bd_options);
}catch(Exception $e){
    $e->getMessage();
}
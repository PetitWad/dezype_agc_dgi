<?php
$bd_dns ='mysql:host=localhost;dbname=agc_dgi';
$bd_username = 'admin';
$bd_pass = 'jamsly';
$bd_options =[
    PDO::MYSQL_ATTR_INIT_COMMAND => 'set NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES =>false
];

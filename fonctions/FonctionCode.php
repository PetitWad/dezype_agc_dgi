<?php

class FonctionCode{

// code de 6 fichres Taxe sur la masse salariale
    static function codeImpot(){
        for($i=0; $i<100; $i++){
           $code = rand(100000, 999999);
        }
        return $code;
    }

    static function codeNif(){
        for($i=0; $i<1000; $i++){
           $code = rand(100000000, 999999999);
        }
        return $code;
    }

}





   

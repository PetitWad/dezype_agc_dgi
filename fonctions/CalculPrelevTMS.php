<?php

Class CalculPrelevTMS{
            
    static function MessageDouer($code){
        require '../controller/data/connect.php';
        $reqListerPvTMS = "SELECT MAX(mois) as maxMois, MAX(annefiscal2) as maxAnne FROM preleve_taxe_masse_sal WHERE code = :code ";
        $statePvTMS = $bd->prepare($reqListerPvTMS);
        $statePvTMS->execute([
            'code'=>$code,
        ]);
        
        $RowAll = $statePvTMS->fetchAll();

        foreach($RowAll as $rowSelect):
            $maxMois = $rowSelect['maxMois'];
        endforeach;
        

        $moisActuel = intval(date('m'));

        $nbrMois =  intval($moisActuel - $maxMois)-1;

        if($nbrMois > 0){
            echo "Vous devez acquiter : ". $nbrMois  ." mois de penalités";
          }

    }

// Nombre de mois
    static function NmbreMois($code){
        require '../controller/data/connect.php';
        $reqListerPvTMS = "SELECT MAX(annefiscal2) as maxAnne,  MAX(mois) as maxMois FROM preleve_taxe_masse_sal WHERE code = :code LIMIT 1 ";
        $statePvTMS = $bd->prepare($reqListerPvTMS);
        $statePvTMS->execute([
            'code'=>$code,
        ]);
        
        $RowAll = $statePvTMS->fetchAll();

        foreach($RowAll as $rowSelect):
            $maxMois = $rowSelect['maxMois'];
        endforeach;
        
        $moisActuel = date('m');
        $moisActuel = $moisActuel;

        $nbrMois = $moisActuel - $maxMois -1;

        if($nbrMois > 0){
            return $nbrMois;
          }
    }

  
}
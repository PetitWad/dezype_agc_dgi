<?php

class FonctionReq{
    /*
        Requette qui verifie les prelevement ne soient pas effectuer dans une anne
        infirieur a la date enregistrement      
    */

    static public function AnneEnreg($code){
        require '../controller/data/connect.php';
        $reqDateEnrg = "SELECT YEAR(dateEnrg) anne_enrg FROM impot where code = :code LIMIT 1";
        $stateReq = $bd->prepare($reqDateEnrg);
        $stateReq->execute([
            'code'=>$code
        ]);

        foreach($stateReq as $rsl){
            $anEng = $rsl['anne_enrg'];
        }

        return $anEng;
    }

    // requete dans la table impot 
    static function ImpotReq($nom, $code){
        require '../controller/data/connect.php';
        $reqSQL = "SELECT * FROM impot WHERE code = :code  and nom = :nom LIMIT 1";
        $revenuStatement = $bd->prepare($reqSQL);
        $revenuStatement->execute([
            'code'=>$code,
            'nom'=>$nom,
        ]);
        $rowReq = $revenuStatement->fetchAll();
        return $rowReq;
    }

    //requete qui lister les table obligation ouverture
    static function Oblig_ouvert_lister($table, $nif, $annefiscale2){
        require '../controller/data/connect.php';

        $reqSQLMSF = "SELECT * FROM $table WHERE nif = :nif and annefiscale2 = :annefiscale2";
        $societeStatementMSF = $bd->prepare($reqSQLMSF);
        $societeStatementMSF->execute([
            'nif' => $nif,
            'annefiscale2'=> $annefiscale2
        ]);
        $restlAllRowMSF = $societeStatementMSF->fetchAll();
        $annefiscale2_vrai = isset($restlAllRowMSF['annefiscale2']);

        foreach($restlAllRowMSF as $rowSelectMSF){
           $annefiscale2_vrai = $rowSelectMSF['annefiscale2'];
        }

        return $annefiscale2_vrai;
    }

    // fonction insertion Insert_montant_droit_fixe
        static function Insert_montant_droit_fixe($table, $nif, $montant, $annefiscale1, $annefiscale2, $dateEng){
        require '../controller/data/connect.php';
        $req = $bd->prepare("INSERT INTO $table VALUES(null, :nif, :montant, :annefiscale1, :annefiscale2, :dateEng)");
    
        $req->bindParam(':nif',$nif); 
        $req->bindParam(':montant',$montant); 
        $req->bindParam(':annefiscale1',$annefiscale1);
        $req->bindParam(':annefiscale2',$annefiscale2); 
        $req->bindParam(':dateEng',$dateEng); 
        $exc = $req->execute();
        return $exc;
    }


}
<?php

    /*
     * Permette di ritornare array associative contente le informazioni di tutti i prodotto
     * di un materia scelta dall'utente (o T-shirt di default).
     * */
    function getProdInfo($catParam){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $cat = $db->quote($catParam);
            $rows = $db->query("SELECT * FROM Prodotto WHERE idCat = $cat;");
            $db = null;
            return $rows;
        }catch (PDOException $er){
            return null;
        }
    }

    //Gestione dell'errore in caso di fallimento
    if (isset($_POST["nameCat"])) {
        $arrProducts = getProdInfo($_POST["nameCat"]);
        if($arrProducts != null) {
            $result = $arrProducts->fetchAll();
            echo json_encode($result);
        }else {
            header('HTTP/1.1 500 Internal DB error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
    }

?>
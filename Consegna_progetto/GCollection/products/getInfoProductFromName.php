<?php

    /*
     * Fornito il nome del prodotto, ne vengono restituite tutte le caratteristiche.
     * */
    function getProdInfoFromName($name){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $name_protected = $db->quote($name);
            $rows = $db->query("SELECT * FROM Prodotto WHERE nome = $name_protected;");
            $db = null;
            return $rows;
        }catch (PDOException $er){
            return null;
        }
    }

    if(isset($_POST["nomeItem"])){
        $item = getProdInfoFromName($_POST["nomeItem"]);
        if($item != null) {
            $result = $item->fetch();
            echo json_encode($result);
        }else {
            header('HTTP/1.1 500 Internal DB error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
    }

?>
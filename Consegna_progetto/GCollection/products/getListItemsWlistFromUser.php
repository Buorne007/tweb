<?php
    /*
     * Permette di ritornare l'ID della wishlist di uno specifico utente passato per parametro.
     * */
    function getIdWlist($usrName)
    {
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $usrName_protected = $db->quote($usrName);
            $rows = $db->query("SELECT idwlist FROM Utente WHERE username = $usrName_protected;");

            $db = null;
            return $rows;
        } catch (PDOException $er) {
            return null;
        }
    }

    /*
     * La funzione ritorna un array associativo contenente tutti gli elementi presenti in una specifica wishlist.
     * */
    function getListItemWl($id){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $id_protected = $db->quote($id);
            $rows = $db->query("SELECT nomeProd FROM Contiene WHERE idWishlist = $id_protected;");
            $db = null;
            return $rows;
        } catch (PDOException $er) {
            return null;
        }
    }

    if (isset($_POST["usrName"])) {
        $arrProducts = getIdWlist($_POST["usrName"]);
        if ($arrProducts != null) { //Gestione dell'errore in caso di fallimento
            $idW = $arrProducts->fetch(PDO::FETCH_NUM);
            if($idW != null) { //Gestione dell'errore in caso di fallimento
                $list = getListItemWl($idW[0]);
                echo json_encode($list->fetchAll());
            }else{
                header('HTTP/1.1 500 No user with that name.');
                header('Content-Type: application/json; charset=UTF-8');
                echo (json_encode(array('message' => 'ERROR', 'code' => 1337)));
            }
        } else {
            header('HTTP/1.1 500 Internal DB error');
            header('Content-Type: application/json; charset=UTF-8');
            echo (json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
    }


?>
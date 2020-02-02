<?php
    /*
     * Dati in ingresso nome prodotto, la funzione elimina la tupla corrispondente
     * presente nella tabella Contiene.
     * */
    function deleteItemCart($nomeItem){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $nomeItem_protected = $db->quote($nomeItem);
            $idCarr = $_SESSION["logged"]["idcarrello"];
            $sql = "DELETE FROM Contiene WHERE idWishlist = '$idCarr' AND nomeProd = $nomeItem_protected ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
        }catch (PDOException $err){}
    }

    session_start();
    if (!isset($_SESSION["logged"])) {
        header("location: login.php");
    }else{
        unset($_SESSION["error_login"]);
        if(isset($_GET["nome"])){
            //Elimino item da wlist
            deleteItemCart($_GET["nome"]);
            header("location: ../shoppingcart.php?sec=wlist");
        }
    }
?>

<?php
    /*
     * Dati in ingresso nome prodotto e data di inserimento nel carrello, la funzione elimina la tupla corrispondente
     * presente nella tabella Composti. Se la qta fosse > 1 allora viene fatta update e non delete.
     * */
    function deleteItemCart($nomeItem, $dataOrder){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $nomeItem_protected = $db->quote($nomeItem);
            $dataOrder_protected = $db->quote($dataOrder);
            $idCarr = $_SESSION["logged"]["idcarrello"];
            $numItemSql = "SELECT qta FROM Composti WHERE idCarrello = '$idCarr' AND nomeProd = $nomeItem_protected AND dataOrd = $dataOrder_protected";
            $numItem = $db->query($numItemSql)->fetch(PDO::FETCH_NUM)[0];
            if($numItem == 1) {
                $sqlUpdateNumItem = "DELETE FROM Composti WHERE idCarrello = '$idCarr' AND nomeProd = $nomeItem_protected AND dataOrd = $dataOrder_protected";
            }else{
                $numItemNow = $numItem - 1;
                $sqlUpdateNumItem = "UPDATE Composti SET qta = $numItemNow WHERE idCarrello = '$idCarr' AND nomeProd = $nomeItem_protected AND dataOrd = $dataOrder_protected";
            }
            $stmt = $db->prepare($sqlUpdateNumItem);
            $stmt->execute();
            $db = null;
        }catch (PDOException $err){}
    }

    session_start();
    if (!isset($_SESSION["logged"])) {
        header("location: login.php");
    }else{
        unset($_SESSION["error_login"]);
        if(isset($_GET["nome"]) && isset($_GET["date"])) {
            deleteItemCart($_GET["nome"],$_GET["date"]);
            header("location: ../shoppingcart.php");
        }
    }
?>

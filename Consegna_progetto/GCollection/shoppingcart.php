<?php
    /*
     * Dato id del carrello dell'utente ritorna array associativo con tutti i dati dei prodotti nel suo carrello.
     * */
    function getOrdersFromUser(){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $idCarr = $_SESSION["logged"]["idcarrello"];
            $rows = $db->query("SELECT * FROM Composti WHERE idCarrello = '$idCarr'");
            $db = null;
            if($rows->rowCount() > 0)
                return $rows;
            else
                return null;
        }catch (PDOException $err){}
    }

    /*
     * Dato id della wishlist dell'utente ritorna array associativo con tutti i dati dei prodotti nella sua wishlist.
     * */
    function getItemWlist(){
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $idCarr = $_SESSION["logged"]["idcarrello"];
            $rows = $db->query("SELECT * FROM Contiene WHERE idWishlist = '$idCarr'");
            $db = null;
            if($rows->rowCount() > 0)
                return $rows;
            else
                return null;

        }catch (PDOException $err){}
    }

    /*
     * Dato nome del prodotto, ritorno tutte le informazioni associato ad esso.
     * */
    function getSingleProdDetails($nomeParam){
        $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
        $nome_protected = $db->quote($nomeParam);
        $rows = $db->query("SELECT * FROM Prodotto WHERE nome = $nome_protected;");
        $db = null;
        return $rows->fetch();
    }

    /*
     * Controllo della presenza in sessione del login dell'utente.
     * */
    session_start();
    $opt = "order"; //Mi serve per tenere conto di quale voce è stata celta. In base a quella faccio comparire o meno le cose
                    //Voglio settarla in fase di caricamento. Default = "order"
    $totPrice = 0;
    if (!isset($_SESSION["logged"])) {
        header("location: login.php");
    }else{
        unset($_SESSION["error_login"]);
        //echo $_SESSION["logged"]["username"]." ".$_SESSION["logged"]["email"]." ".$_SESSION["logged"]["idwlist"]." ".$_SESSION["logged"]["idcarrello"];
        if(isset($_GET["sec"])) {
            $opt = $_GET["sec"];
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--
        Cortese Gabriele
        La seguente pagina ha il compito di mostrare tutti i prodotti del proprio carrello e della propria wishlist.
        Per entrambe le opzioni è possibile vedere nel dettaglio i prodotti e decidere se elimanrli o meno.
        Solo per la parte inerente al carrello è possibile vedere un subtotale.
        La pagina è raggiunta tramite il click del bottone presente nella navabar.
        -->
        <meta charset="utf-8">
        <title>The collection</title>
        <meta name="author" content="The Collection">
        <meta property="og:title" content="The Collection">
        <meta property="og:url" content="thecollection.com">
        <meta property="og:description" content="Minimalism, special, unique, gold and fashon">
        <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/effects_shopcart.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/stile.css">
        <link rel="stylesheet" href="css/stileShop.css">
        <link rel="icon" href="img/logo.png">
        <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <body>
    <?php include("navbar.html"); ?>
    <div id="container">
        <div class="row">
            <div class="col-6">
                <a id="ordTitle" class="subNav" href="shoppingcart.php?sec=order">To order</a>
            </div>
            <div class="col-6">
                <a id="wlTitle" class="subNav" href="shoppingcart.php?sec=wlist">Manage wishlist</a>
            </div>
        </div>
            <?php
                if($opt == "order"){ //Richiesto elenco prodotti carrello
                        $prod_array = getOrdersFromUser();
                        if($prod_array == null){
                            ?>
                            <?= "<h2 id=\"noRes\"> No items in your shopcart</h2>" ?>
                            <?php
                        }else{
                            foreach ($prod_array as $row) {
                                $prodInfo = getSingleProdDetails($row["nomeProd"]);
                                $totPrice += ($prodInfo["prezzo"]*$row["qta"]);
                        ?>
                            <?= "<div class=\"row singleProdRow\">
                                    <div class=\"col-sm-4\">
                                        <a href='./details.php?nome=$row[nomeProd]&cat=$prodInfo[idCat]'>
                                        <img class='imgProd' src=$prodInfo[pathImg] alt=\"imgProduct\"></a>
                                    </div>
                                    <div class=\"col-sm-4 descSpace\">
                                        <p><span>Category: </span>$prodInfo[idCat]</p>
                                        <p><span>Name: </span>$row[nomeProd]</p>
                                        <p><span>Price: </span>$prodInfo[prezzo] &euro;</p>
                                        <p><span>Size: </span>$row[taglia]</p>
                                        <p><span>Qta: </span>$row[qta]</p>
                                    </div>
                                    <div class=\"col-sm-4\">
                                        <a class=\"xDelete\" href='./products/deleteItemFromCarrello_script.php?nome=$row[nomeProd]&date=$row[dataOrd]'><h1>x</h1></a>
                                    </div>
                                </div><hr>"  ?>
                      <?php } ?>
                            <?= "<p id=\"priceTot\">Total price: $totPrice&euro;</p>" ?>
                <?php }
                            ?>
                    <?php
                } else if($opt == "wlist"){ //Richiesto item in wishlist
                    $prod_array = getItemWlist();
                    if($prod_array == null) {
                        ?>
                        <?= "<h2 id=\"noRes\"> No items in your wishlist</h2>" ?>
                        <?php
                    }else {
                        foreach ($prod_array as $row) {
                            $prodInfo = getSingleProdDetails($row["nomeProd"]);
                        ?>
                        <?= "<hr><div class=\"row singleProdRow\">
                                <div class=\"col-sm-4\">
                                    <a href='./details.php?nome=$row[nomeProd]&cat=$prodInfo[idCat]'>
                                    <img class='imgProd' src=$prodInfo[pathImg] alt=\"imgProduct\"></a>
                                </div>
                                <div class=\"col-sm-4 descSpace\">
                                    <p><span>Category: </span>$prodInfo[idCat]</p>
                                    <p><span>Name: </span>$row[nomeProd]</p>
                                    <p><span>Price: </span>$prodInfo[prezzo] &euro;</p>
                                </div>
                                <div class=\"col-sm-4\">
                                    <a class=\"xDelete\" href='./products/deleteItemFromWlist_script.php?nome=$row[nomeProd]'><h1>x</h1></a>
                                    <a href='details.php?nome=$row[nomeProd]&cat=$prodInfo[idCat]'>Details item</a>
                                </div>
                            </div>" ?>
                 <?php   }
                    }
                    ?>
            <?php
                }
                ?>
    </div>
    <?php include("footer.html"); ?>
    </body>
</html>

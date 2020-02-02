<?php
    /*
     * Permette di ritornare la categoria di prodotti d'interesse dell'utente.
     * Nel caso in cui non fosse ancora selezionata la prima a comparire sarà T-shirt.
     * */
    function getCatName(){
        if(isset($_GET["cat"])){
            return $_GET["cat"];
        }else
            return "T-shirt";
    }

    /*
     * Controllo della presenza in sessione del login dell'utente.
     * */
    session_start();
    $categoria = "";
    if (!isset($_SESSION["logged"])) {
        header("location: login.php");
    }else{
        unset($_SESSION["error_login"]);
        $categoria = getCatName();
        //echo $_SESSION["logged"]["username"]." ".$_SESSION["logged"]["email"]." ".$_SESSION["logged"]["idwlist"]." ".$_SESSION["logged"]["idcarrello"];
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--
        Cortese Gabriele
        La seguente pagina ha il compito di mostrare i prodotti presenti nel database filtrando sulla cateogoria d'interesse.
        La categoria viene scelta trmite il menù a tendina presente nella navbar importata con navbar.html.
        Tale pagina è raggiungibile dopo il login e al ritorno dalla pagina details.php.
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
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/stile.css">
        <link rel="icon" href="img/logo.png">
        <script src="js/effects_index.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
        </head>
    <body>
    <?php include("navbar.html"); ?>
    <div id="nameContainer">
        <div class="row">
            <div class="col-12">
                <h1 id="nameSoc">The collection</h1>
            </div>
        </div>
    </div>
    <div id="categoryName">
        <div class="row">
            <div class="col-12">
                <h3 id="catSpace">
                    <?=getCatName()?>
                </h3>
                <hr>
            </div>
        </div>
    </div>
    <div id="container">
    </div>

    <?php include("footer.html"); ?>
    </body>
</html>
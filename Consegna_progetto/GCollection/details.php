<?php
    /*
     * Reperimento parametri GET per completamento pagina.
     * */
    $nomeProd = $_GET["nome"];
    $nomeCat = $_GET["cat"];

    session_start();
    if (!isset($_SESSION["logged"])) { //Controllo per sicurezza
        header("location: login.php");
    }else{
        unset($_SESSION["error_login"]);
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--
        Cortese Gabriele
        La seguente pagina ha il compito di mostrare il dettaglio di un singolo prodotto preso in esame.
        Per giungere in questa sezione è necessario scegliere un item presente nella pagina index.php oppure
        cliccando su "details" nella sezione shoppingcart.php
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
        <link rel="stylesheet" href="css/stileDetails.css">
        <link rel="icon" href="img/logo.png">
        <script src="js/effects_details.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php include("navbar.html"); ?>

    <div class="container">
        <div class="row" id="infoDetNav">
            <div class="col-sm-4 pull-left" id="arrBack">
                <?= "<a href='index.php?cat=$nomeCat'><p>&larr;</p></a>" ?>
            </div>
            <div class="col-sm-4 pull-left" id="nomeProd">
                <p id="nomeItem"><?= $nomeProd ?></p>
            </div>
        </div>
        <div class="row" id="detProd">
            <div class="col-sm-6 pull-left">
            </div>
            <div class="col-sm-6 pull-left" id="infoProd">
                <p><span>Category: </span><d id="catSpace"></d></p>
                <p><span>Description: </span><d id="descSpace"></d></p>
                <p><span>Color: </span><d id="colSpace"></d></p>
                <p><span>Material: </span><d id="matSpace"></d></p>
                <p><span>Price: </span><d id="priceSpace"></d></p>
                <p><span>Size: </span>
                    <select id="taglia">
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </p>
                <input type="button" value="Add to card" id="addCar" class="addBtn">
                <input type="button" value="Add to wishlist" id="addWl" class="addBtn">
            </div>
        </div>
        <div class="row" id="confirmSpace">
            <p id="msgError"></p>
            <p id="msgOk"></p>
        </div>
        <div class="row" id="commentSpace">
        </div>
        <form>
            <div class="form-group">
                <label>Write your comment</label>
                <textarea class="form-control" id="txtComment" rows="3"></textarea>
            </div>
            <input type="button" id="sendComment" class="btn btn-primary addBtn" value="Submit">
        </form>
        <div class="col-sm-12 pull-left" id="errorSpace">
            <p id="errorMsgComment"></p>
        </div>

    </div>
    <?php include("footer.html"); ?>
    <?= "<div id='idCar'>".$_SESSION['logged']['idcarrello']."</div>"?>
    <?= "<div id='usName'>".$_SESSION['logged']['username']."</div>"?>
    </body>
</html>


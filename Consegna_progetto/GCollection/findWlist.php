<?php
/*
 * Controllo della presenza in sessione del login dell'utente.
 * */
session_start();
if (!isset($_SESSION["logged"])) {
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
        La seguente pagina permette all'utente di ricercare, tramite l'inserimento dell'username, la wishlist di un determinato
        utente e di spostare gli elementi nel proprio carrello.
        La pagina è raggiungile dall'index tramite il link presente nella navbar.
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
        <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="js/bootstrap.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/stile.css">
        <link rel="stylesheet" href="css/stileSearchWl.css">
        <link rel="icon" href="img/logo.png">
        <script src="js/effects_findWlist.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php include("navbar.html"); ?>
    <div id="containerSearch">
        <div class="row">
            <div class="col-sm-12 pull-left" id="titleSearch">
                <h3>Search your friend's wishlist</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 pull-left usrSpace">
                <input type="text" class="form-control" id="usrnameFind" placeholder="Username">
                <button type="button" class="btn btn-outline-primary" id="btnSearch">Search</button>
            </div>
            <div class="col-sm-12 pull-left usrSpace">
                <p id="errSpace"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 pull-left" id="noResSpace">
                <p id="noRes"></p>
            </div>
        </div>
    </div>
    <div id="containerItems">
        <div id="containerImgSc" class="ui-widget-header">
            <div class="row">
                <div class="col-sm-12 pull-left" id="imgScSpace">
                    <p id="istructions">Drag the items over here to put them in your shop cart!</p>
                    <p id="responseSpace"></p>
                    <img src="./img/shopcart.png" id="imgSc" alt="Target to drop">
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="bt" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Show</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label  class="col-form-label">Size:</label>
                            <select id="taglia">
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label id="nameItem" class="col-form-label infoItem"></label>
                            <label id="priceItem" class="col-form-label infoItem"></label>
                            <label id="colorItem" class="col-form-label infoItem"></label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnConfirm">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <?php include("footer.html"); ?>
    <?= "<div id='idCar'>".$_SESSION['logged']['idcarrello']."</div>"?>
    </body>
</html>
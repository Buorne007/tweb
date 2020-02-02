<?php
    session_start();
    function printError(){
        if (isset($_SESSION["error_login"])) {
            return $_SESSION["error_login"];
        }else{
            return "";
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--
        Cortese Gabriele
        La seguente pagina ha il compito di mostrare la form di login e di signin.
        Si presenta come la pagina iniziale del sito, solo se inserite le credenziali è possibile accedere al resto.
        La pagina è raggiunta prima di tutte le altre e dopo aver cliccato sull'icona di logout della navabar.
        -->
        <title>The collection</title>
        <meta charset="utf-8">
        <meta name="author" content="The Collection">
        <meta property="og:title" content="The Collection">
        <meta property="og:url" content="thecollection.com">
        <meta property="og:description" content="Minimalism, special, unique, gold and fashon">
        <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/stile.css">
        <link rel="stylesheet" href="css/stileLogin.css">
        <link rel="icon" href="img/logo.png">
        <script src="js/effects_login.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Gayathri&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="containerForm">
            <form id="formLogin" action="user/login_script.php" method="post">
                <h1 id="titleForm">LOGIN</h1>
                <input class="in" required type="email" id="emailUsr" name="email" placeholder="E-mail">
                <input class="in" required type="password" id="passwdUsr" name="passwd" placeholder="Password">
                <div id="divSwitch">
                    <a id="anchorLink"><span id="switchSignin">Signin</span></a>
                </div>
                <button class="btnSubmit" id="btnSubmitLogin">
                    LOGIN
                </button>
            </form>
        </div>
        <div id="msgErr">
            <p id="errSpace"><?= printError()?></p>
        </div>
    </body>
</html>
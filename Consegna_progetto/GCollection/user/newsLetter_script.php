<?php
    /*
     * Script per la ricezione della richiesta ajax fatta da index.php per l'iscrizione alla newsletter.
     * Usata la variabile di sessione per evitare il crossorigin.
     * */
    session_start();
    if (isset($_SESSION["logged"])) {
        $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
        $email_protected = $db->quote($_POST["email"]);
        $db->query("INSERT INTO Newsletter(email,active) VALUES ($email_protected,'s')");
        $db = null;
    }
?>
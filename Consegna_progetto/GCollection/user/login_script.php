<?php
/*
     * Script che, dati in ingresso i dati necessari per il login, ne verifica la veridicità interrogando
     * il DB e ritornandone la tupla con i dati (esclusa la passwd).
     * */
    function checkCred($email,$passwd){
        $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
        $email_protected = $db->quote($email); //Controllo sicurezza
        $passwd_protected = md5($passwd); //MD5 quindi controllo implicito
        $rows = $db->query("SELECT * FROM Utente WHERE email = $email_protected AND pwd = '$passwd_protected'");
        $user_array = array();
        $db = null; //Chiusura connessione DB
        if($rows != null) {
            if($rows->rowCount() == 1)
                $user_array = $rows->fetch();
        }
        return $user_array;
    }

    /*
     * Reperimento parametri form login.php, verifica con successivo redirect.
     * Gestione eccezione database offline.
     * */
    $email = $_POST["email"];
    $passwd = $_POST["passwd"];
    $db_problem = false; //Utile per sapere quale stringa di errore restituire alla pagina login.php
    try {
        $res = checkCred($email, $passwd);
    }catch (PDOException $ex) {
        $res = null;
        $db_problem = true;
    }

    session_start();
    if($res!=null){
        $arrUtente = [
            'email' => $res["email"],
            'idcarrello' => $res["idcarrello"],
            'username' => $res["username"],
            'idwlist' => $res["idwlist"]
        ];
        $_SESSION["logged"] = $arrUtente;
        header("location: ../index.php");
    }else{
        if($db_problem)
            $_SESSION["error_login"] = "Database errore occurred, try later.";
        else
            $_SESSION["error_login"] = "Username or password not valid";
        header("location: ../login.php");
    }
?>
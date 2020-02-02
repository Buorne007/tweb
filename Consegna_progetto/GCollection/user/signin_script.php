<?php

/*
 * Controllo parametri passati per POST.
 * Insert nuovo indice in Carrello, Wishlist e in Utente.
 * Creazione array associativo per avere informazioni utente in variaible di sessione.
 * */
function insertNewUser($email, $passwd, $passwdConf, $userName){
    if($passwd != $passwdConf)
        return null;
    else {
        try {
            $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
            $email_protected = $db->quote($email); //Controllo sicurezza
            $userName_protected = $db->quote($userName); //Controllo sicurezza
            $passwd_protected = md5($passwd); //MD5 quindi controllo implicito

            //Controllo esistenza username
            $resSelectUsr = $db->query("SELECT * FROM Utente WHERE username = $userName_protected");
            if($resSelectUsr->rowCount() == 0) {
                $rowsCarrello = $db->query("SELECT * FROM Carrello");
                $numCarrelli = $rowsCarrello->rowCount() + 1;

                $sqlCar = "INSERT INTO Carrello(id) VALUES('$numCarrelli')";
                $sqlWl = "INSERT INTO Wishlist(id) VALUES('$numCarrelli')";
                $sqlUser = "INSERT INTO Utente(email,username,pwd,idcarrello,idwlist) VALUES ($email_protected,$userName_protected,'$passwd_protected','$numCarrelli','$numCarrelli')";

                $stmt = $db->prepare($sqlCar);
                $stmt->execute();
                $stmt = $db->prepare($sqlWl);
                $stmt->execute();
                $stmt = $db->prepare($sqlUser);
                $stmt->execute();
                $db = null; //Chiusura connessione DB

                return $arrUtente = [
                    'email' => $email,
                    'idcarrello' => $numCarrelli,
                    'username' => $userName,
                    'idwlist' => $numCarrelli
                ];
            }else {
                $db = null;
                return null;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}

/*
 * Reperimento parametri form login.php, verifica e inserimento, successivo redirect.
 * Gestione eccezione database offline.
 * */
$email = $_POST["email"];
$passwd = $_POST["passwd"];
$passwdConf = $_POST["passwdConf"];
$userName = $_POST["userName"];
$db_problem = false; //Utile per sapere quale stringa di errore restituire alla pagina login.php
$res = null;
try {
    $res = insertNewUser($email, $passwd,$passwdConf,$userName);
}catch (PDOException $ex) {
    $res = null;
    $db_problem = true;
}
session_start();
if($res!=null){
    $_SESSION["logged"] = $res;
    header("location: ../index.php");
}else{
    if($db_problem)
        $_SESSION["error_login"] = "Database errore occurred, try later.";
    else
        $_SESSION["error_login"] = "Data not valid, change username or check the password.";
    header("location: ../login.php");
}
?>

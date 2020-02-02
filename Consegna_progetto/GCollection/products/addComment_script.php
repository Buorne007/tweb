    <?php
    /*
     * Script per la gestione dell'aggiunta di un commento di uno specifico utente.
     * */
    $data = json_decode($_POST["dataCom"], true); //Ricevimento dati con JSON
    try {
        $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
        $dataNow = date("yy:m:d h:i:sa");
        $testo_protected = $db->quote($data["testo"]);
        $sqlUser = "INSERT INTO Commenti(testo,username,idProdotto,data) VALUES ($testo_protected,'$data[username]','$data[idProdotto]','$dataNow')";
        $stmt = $db->prepare($sqlUser);
        $stmt->execute();
        $db = null; //Chiusura connessione DB
    } catch (PDOException $er) {
        $db = null; //Chiusura connessione DB
        header('HTTP/1.1 500 Internal DB error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }

    ?>
    <?php
    /*
     * Script per la gestione dell'aggiunta di un prodotto nel carrello di uno specifico utente.
     * Prima di inserire:
     *  Controllo se esiste gia il prodotto che si vuole inserire --> se è cosi aumento solo la qta di quello gia presente (Update).
     *                                                                Altrimenti faccio una semplice Insert.
     * */
    $data = json_decode($_POST["dataCar"], true); //Ricevimento dati con JSON
    try {
        $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
        $dataNow = date("d-m-Y H:i:s");
        $rowsProdUsr = $db->query("SELECT * FROM Composti WHERE idCarrello = '$data[idCar]' AND nomeProd = '$data[nomeProd]' AND taglia = '$data[taglia]'");
        if($rowsProdUsr->rowCount() > 0){
            $elem = $rowsProdUsr->fetch();
            $qtaNew = $elem["qta"] + 1;
            $dataOrdPass = $elem["dataOrd"];
            $sqlUser = "UPDATE Composti SET qta = $qtaNew WHERE idCarrello = '$data[idCar]' AND nomeProd = '$data[nomeProd]' AND dataOrd = '$dataOrdPass'";
        }else
            $sqlUser = "INSERT INTO Composti(idCarrello,nomeProd,qta,taglia,dataOrd) VALUES ('$data[idCar]','$data[nomeProd]',1,'$data[taglia]','$dataNow')";
        $stmt = $db->prepare($sqlUser);
        $stmt->execute();
        $db = null; //Chiusura connessione DB
    }catch (PDOException $er){
        $db = null; //Chiusura connessione DB
        $db = null; //Chiusura connessione DB
        header('HTTP/1.1 500 Internal DB error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        //Messaggio di errore stampato da Javascript
    }
    ?>

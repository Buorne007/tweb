    <?php
    /*
     * Script per la gestione dell'aggiunta di un prodotto nella wishlist di uno specifico utente.
     * Prima di inserire:
     *  Controllo se esiste gia il prodotto che si vuole inserire, in caso positivo ignoro la query, altrimenti inserisco.
     * */
    $data = json_decode($_POST["dataWlist"], true); //Ricevimento dati con JSON
    try {
        $db = new PDO("mysql:dbname=shop;host=localhost", "root", "");
        $rowsProdUsr = $db->query("SELECT * FROM Contiene WHERE idWishlist = '$data[idWishlist]' AND nomeProd = '$data[nomeProd]'");
        if ($rowsProdUsr->rowCount() == 0) {
            $sqlUser = "INSERT INTO Contiene(idWishlist,nomeProd) VALUES ('$data[idWishlist]','$data[nomeProd]')";
            $stmt = $db->prepare($sqlUser);
            $stmt->execute();
        }
        $db = null; //Chiusura connessione DB
    } catch (PDOException $er) {
        $db = null; //Chiusura connessione DB
        header('HTTP/1.1 500 Internal DB error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }


    ?>
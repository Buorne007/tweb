<?php include("top.html"); ?>
<?php
/*
 * Ricerca lettera in comune in stessa posizione tra due stringhe personality_type.
 * Ritorniamo true se esiste lettera in comune, false altrimenti.
 * Gestito il problema in caso di passaggio parametri vuoto o nullo.
 * */
function same($type_usr,$type_match){
    for($i = 0; $i < strlen($type_match) && $i < strlen($type_usr); $i++) {
        if (strcmp($type_usr[$i], $type_match[$i]))
             return true;
    }
    return false;
}

//Prendo nome dell'utente in GET
$nome_param = $_GET["name"];
//Tiene traccia se è stato scatenato un errore
$err = false;
$str_err = "";

if($nome_param != null && $nome_param != "") {

    //Lettura da file per trovare tutte le informazioni dell'utente passato in GET
    $lines = file("singles.txt");
    $line_user = null;
    foreach ($lines as $line) {
        $usr = explode(",", $line);
        if (strcmp($usr[0], $nome_param) == 0)
            $line_user = $line;
    }
    //Salvataggio dati anagrafici utente passato in GET
    list($name_usr, $gen_usr, $age_usr, $type_usr, $os_usr, $min_usr, $max_usr) = explode(",", $line_user);

    //Array contenti le righe con dati anagrafici dei matching con l'utente passato in GET
    $res = Array();

    //Comparazione riga per riga (utente per utente) e aggiunta all'array di profili matched
    foreach ($lines as $line_m) {
        list($name_match, $gen_match, $age_match, $type_match, $os_match, $min_match, $max_match) = explode(",", $line_m);
        if (($gen_usr != $gen_match) && ($name_usr != $name_match)) {
            if (($age_match >= $min_usr) && ($age_match <= $max_usr)) {
                if ($os_usr == $os_match) {
                    if (same($type_usr, $type_match))
                        array_push($res, $line_m); //Caricamento dei dati anagrafici del personaggio matched
                }
            }
        }
    }
}else{
    //Creazione flag e boolean di errore
    $err = true;
    $str_err = "Non è stato inserito utente";
}
?>

<?php
//If per la festione della stampa in caso di errore
if($err == false){
    ?>
    <h1>Matches for <?= $nome_param;?></h1>
    <?php
}else {
    ?>
    <h1><?= $str_err;?></h1>
    <?php
}
?>
<?php
//If che mi permette di stampare i vari profili matched solo se il
//numero di profili matched è > 0
if($err == false) {
    if (count($res) > 0)
        printMatch($res);
}
?>
<?php
    //Funzione di stampa div dinamici con gli utenti matched
    function printMatch($res){
        for ($i = 0; $i < count($res); $i++) {
            ?>
            <div class="match">
                <p><img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/4/user.jpg" alt="profile"></p>
                <ul>
                    <?php
                        list($name_res, $gen_res, $age_res, $type_res, $os_res, $min_res, $max_res) = explode(",",$res[$i]);
                    ?>
                    <li><p><?=$name_res;?></p></li>
                    <li><strong>gender:</strong><?=$gen_res;?></li>
                    <li><strong>age:</strong><?=$age_res;?></li>
                    <li><strong>type:</strong><?=$type_res;?></li>
                    <li><strong>OS:</strong><?=$os_res;?></li>
                </ul>
            </div>
            <?php
        }
        ?>
        <?php
    }
?>
<?php include("bottom.html"); ?>

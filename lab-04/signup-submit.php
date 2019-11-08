<?php include("top.html"); ?>
<?php
/*
 * Ogni parametro passato in post viene concatenato con una , e un \n finale.
 * Tale stringa viene scritta su file in modalità APPEND.
 * Tutto funziona a patto che sul file come ultime carattere ci sia un \n
 * */
$params = "";
foreach ($_POST as $param => $value)
    $params = $params.$value.",";
file_put_contents("singles.txt",substr($params,0,-1)."\n",FILE_APPEND);
?>
    <h1>Thank you!</h1>
    <p>Welcome to NerdLuv, <?= $_POST["name"];?>!</p>
    <p>Now <a href="matches.php" >log in to see your matches!</a></p>

<?php include("bottom.html"); ?>

<?php
    /*
     * Fase in cui vengono distrutte le variabili di sessione e avviene l'uscita verso la login.php
     * */
    session_start();
    session_unset();
    session_destroy();
    header("location: ../login.php");
?>
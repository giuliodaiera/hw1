<?php
    //avvia la sessione
    session_start();
    //elimina la sessione
    session_destroy();
    //destinazione
    header("Location: login.php");

?>
<?php

    //avvia la sessione
    session_start();
    //verifica se l'utente è loggato
    if(!isset($_SESSION["_tuttosulcalcio_username"]))
    {
        //Vai al login
        header("Location: login.php");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio');

    if(!isset($_POST['postid'])){
        exit;
    }

    $postid = mysqli_real_escape_string($conn, $_POST['postid']);
    
    $query = "SELECT comments.id AS id, username, text, time, post
    FROM comments LEFT JOIN users ON user = users.id 
    WHERE comments.post = $postid ORDER BY time ASC LIMIT 30";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $returnarray = array();
    while($entry = mysqli_fetch_assoc($res)) {
        // Scorro i risultati ottenuti e creo l'elenco di post
        $time = getTime($entry['time']);
        $returnarray[] = array('id' => $entry['id'], 'postid' => $entry['post'], 'username' => $entry['username'], 
                               'text' => $entry['text'], 'time' => getTime($entry['time']));
    }

    echo json_encode($returnarray);

    exit;

    function getTime($timestamp) {      
        // Calcola il tempo trascorso dalla pubblicazione del post       
        $old = strtotime($timestamp); 
        $diff = time() - $old;           
        $old = date('d/m/y', $old);

        if ($diff /60 <1) {
            return intval($diff%60)." secondi fa";
        } else if (intval($diff/60) == 1)  {
            return "Un minuto fa";  
        } else if ($diff / 60 < 60) {
            return intval($diff/60)." minuti fa";
        } else if (intval($diff / 3600) == 1) {
            return "Un'ora fa";
        } else if ($diff / 3600 <24) {
            return intval($diff/3600) . " ore fa";
        } else if (intval($diff/86400) == 1) {
            return "Ieri";
        } else if ($diff/86400 < 30) {
            return intval($diff/86400) . " giorni fa";
        } else {
            return $old; 
        }
    }

?>
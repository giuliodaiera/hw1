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

    if(!isset($_POST['postid']) || empty($_POST['postid'])){
        echo json_encode(array('ok' => false));
        exit;
    }

    $postid = mysqli_real_escape_string($conn, $_POST['postid']);
    
    $query = "SELECT u.username AS username
        FROM posts AS p LEFT JOIN likes AS l ON p.id = l.post
        LEFT JOIN users AS u ON l.user = u.id
        WHERE p.id = $postid";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if($res){
        $returnarray = array();
        while($entry = mysqli_fetch_assoc($res)) {
            $returnarray[] = array('username' => $entry['username']);
        }
        echo json_encode($returnarray);
    }
    else{
        echo json_encode(array('ok' => false));
    }
        
    exit;
?>
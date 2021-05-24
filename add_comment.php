<?php 
    // avvia la sessione
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
    
    if(!isset($_POST['postid']) ||
        empty($_POST['postid']) ||
       !isset($_POST['text']) ||
       empty($_POST['text'])
    )
    {
        echo json_encode(array('ok' => false));
        exit;
    }
    
    $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio');

    $postid = mysqli_real_escape_string($conn, $_POST['postid']);

    $userid =  $_SESSION['_tuttosulcalcio_userId'];

    $testo = mysqli_real_escape_string($conn, $_POST['text']);

    $query = "INSERT INTO comments(user, post, text) VALUES ($userid, $postid, '".$testo."');";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if($res){
        // inserimento andato a buon fine
        $query = "SELECT ncomments, id FROM posts WHERE id = $postid";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            $returndata = array('ok' => true, 'ncomments' => $entry['ncomments'], 'postid' => $entry['id'], 'text' => $testo );
            
            echo json_encode($returndata);
            
            mysqli_close($conn);

            exit;
        }

    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));
?>
<?php 

    session_start();

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        exit;
    }

    $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio');

    if(!isset($_POST['postid'])){
        exit;
    }

    $postid = mysqli_real_escape_string($conn, $_POST['postid']);
    $userid =  $_SESSION['_tuttosulcalcio_userId'];
    
    $query = "INSERT INTO likes VALUES ($userid, $postid)";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if($res){
        // inserimento andato a buon fine
        $query = "SELECT nlikes, id FROM posts WHERE id = $postid";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            $returndata = array('ok' => true, 'nlikes' => $entry['nlikes'], 'postid' => $entry['id']);
            
            echo json_encode($returndata);
            
            mysqli_close($conn);

            exit;
        }

    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));
?>
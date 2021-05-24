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

    if(!isset($_POST["type"]) ||
        empty($_POST["type"]) ||
        !isset($_POST["text"]) ||
        empty($_POST["text"]))
    {
        errorResponse("il parametro tipo o testo e' obbligatorio");
        exit;
    }

    switch($_POST['type']) {
        case 'picture': picture(); break;
        case 'text': text(); break;
        default: {
            errorResponse("tipo non conosciuto");
            exit;
        };
    }


    function text(){
        if(!empty($_POST['text'])){

            $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio') or die(mysqli_error($conn));

            # Costruisco la query
            $type = mysqli_real_escape_string($conn, $_POST['type']);
            $text = mysqli_real_escape_string($conn, $_POST['text']);
            $userid = $_SESSION['_tuttosulcalcio_userId'];

            $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('type', '$type', 'text', '$text'))";


            if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
                header("Location: social.php");
            }

            mysqli_close($conn);
        } else{
            echo "errore";
        }
        
        errorResponse("errore nella connessione al db");
    }

    function errorResponse($message){
        echo json_encode(array('ok' => false, 'message' => $message));
    }

?>
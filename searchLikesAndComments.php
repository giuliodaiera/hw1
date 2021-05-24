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



?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='./style/search.css'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">  
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i|Open+Sans:400,700" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./scripts/search.js" defer></script>
    </head>
    
    <title>TuttoSulCalcio - Home</title>

    <body>
        <header>
            <nav>
                <div id="logo">
                    TuttoSulCalcio
                </div>
                <div id="links">
                    <a class="button" href = "social.php">Social</a>
                </div>
            </nav>
        </header>

        <div class="container">

            <div class="search-container">
                <input type="text" class="search_bar" id="username_search" placeholder="Cerca per username" name="search" onkeyup="checkUsername()">
                <button class="search-button" id="search_button" onclick="fetchPosts()" disabled><i class="fa fa-search"></i></button>
            </div>

            <div id="posts" class="posts-container"></div>
        </div>
    </body>
</html>
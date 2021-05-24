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
        <link rel='stylesheet' href='./style/social.css'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">  
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i|Open+Sans:400,700" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
        <script src="./scripts/social.js" defer></script>
    </head>
    
    <title>TuttoSulCalcio - Home</title>

    <body>
        <header>
            <nav>
                <div id="logo">
                    TuttoSulCalcio
                </div>
                <div id="links">
                    <a class="button" href = "profile.php">Profile</a>
                    <a class="button" href="searchLikesAndComments.php">Cerca</a>
                    <a class="button" href="logout.php">Logout</a>
                
                </div>

                <div id="menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

            </nav>

          <h1>SocialFootball</h1>
          <div class="overlay"></div>
    
        </header>


            <div class="container">

                <!--posts area-->
                <div id='posts_container' class="container2">
                    <h1>Post</h1>

                </div>

                <a class="button" id="add_post" href="add_post.php">Nuovo post</a>


                <div class="modal">
        
                    <div class="modal_contents">
                        <div class="modal_close-bar">
                            <span id="x_close">x</span>
                        </div>


                        <div class="allContainer" id="allContainer"></div>

                    </div>
                </div>

            </div>

        </div>

    </body>
</html>
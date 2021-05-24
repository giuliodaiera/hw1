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

    <?php 

        $username = $_SESSION["_tuttosulcalcio_username"];
        $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio');
        $query = "SELECT * FROM users WHERE username = '$username' ";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>

    <head>
        <link rel='stylesheet' href='./style/profile.css'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">  
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i|Open+Sans:400,700" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
        <title>TuttoSulCalcio - Profilo: <?php echo $_SESSION["_tuttosulcalcio_username"] ?></title>
    </head>

    <body>
        
        <header>
            <nav>
                <div id="logo">
                    TuttoSulCalcio
                </div>

                <div id="links">
                    <a class="button" href= "social.php">Social</a>
                    <a class="button" href= "logout.php">Logout</a>
                </div>

            </nav>
    
        </header>

        <div class="box">

            <div class="info">
                <h3>TuttoSulCalcio - Profilo Utente</h3>
            </div>

            <section class="area">


                <div class="area1">
                    <h4>Name: <span><?php echo $userinfo['name'] ?></span></h4>
                    <h4>Surname: <span><?php echo $userinfo['surname'] ?></span></h4>
                    <h4>Username: <span><?php echo $userinfo['username'] ?></span></h4>
                    <h4>Email: <span><?php echo $userinfo['email'] ?></span></h4>
                </div>

                <div class="area2">
                    <h4>Post pubblicati: <span class="count"><?php echo $userinfo['nposts'] ?></span> </h4>
                </div>

            </section>

        </div>

    </body>

</html>

<?php mysqli_close($conn); ?>

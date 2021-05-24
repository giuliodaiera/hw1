<?php

    // avviare la sessione
    session_start();
    // verifichiamo l'accesso
    if(isset($_SESSION["_tuttosulcalcio_username"]))
    {
        header("Location: social.php");
        exit;
    }


    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {
        // Se username e password sono stati inviati

        // Connessione al DB
        $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio') or die(mysqli_error($conn));
        
        // Preparazione
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // ID e Username per sessione, password per controllo
        $query = "SELECT id, username, password FROM users
                  WHERE username = '$username'";
        // Esecuzione
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0) {
            // Ritorna una riga se è presente un utente nel db
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password']))
            {                
                $_SESSION['_tuttosulcalcio_username'] = $_POST['username'];
                $_SESSION['_tuttosulcalcio_userId'] = $entry['id'];

                header("Location: social.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }

        // Se l'utente non è stato trovato o la password non ha passato la verifica
        $error = "Username e/o password errati.";
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])) {
        // Se solo uno dei due è impostato
        $error = "Inserisci username e password.";
    }

?>



<html>
    <head>
        <link rel='stylesheet' href='./style/signup.css'>
        <title>TuttoSulCalcio - Accedi</title>
    </head>

    <body>

        <main class="box">

            <div class="info"><h3>TuttoSulCalcio - Accedi</h3></div>

            <section class="area">

                <?php
                    // Verifica la presenza di errori
                    if (isset($error)) {
                        echo "<span class='error'>$error</span>";
                    }

                ?>

                <form name='login' method='post' autocomplete="off">

                    <!-- Mantiene i valori inseriti in caso di ricaricamento della pagina -->
                    <div class="username">
                        <div><label for='username'>Nome utente</label></div>
                        <div><input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></div>
                    </div>

                    <div class="password">
                        <div><label for='password'>Password</label></div>
                        <div><input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>></div>
                    </div>

                    <div class="login">
                        <button type='submit'>Accedi</button>
                    </div>

                    <div class="container_signup">
                        <p>Non hai un account? <a href="signup.php">Iscriviti</a>.</p>
                    </div>

                </form>

            </section>

        </main>

    </body>

</html>
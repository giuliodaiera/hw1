<?php

    // avvia la sessione
    session_start();
    //verifica se l'utente è loggato
    if(isset($_SESSION["_tuttosulcalcio_username"]))
    {
        //Vai al login
        header("Location: social.php");
        exit;
    }

    // inizializzo le variabili
    $name = '';
    $username = '';
    $surname = '';
    $email = '';
    $password = '';
    $errors = array();

    // connetto al database

    $conn = mysqli_connect('localhost', 'root', '', 'tuttosulcalcio') or die(mysqli_error($conn));
    //Registrazione user

    if(isset($_POST['reg_user']))
    {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);


        //validazione del form
        if(empty($name))
        {
            array_push($errors, "Name is required");
        }

        if(empty($surname))
        {
            array_push($errors, "Surname is required");
        }

        if(empty($username))
        {
            array_push($errors, "Username is required");
        }

        if(empty($email))
        {
            array_push($errors, "Email is required");
        }

        if(empty($password))
        {
            array_push($errors, "Password is required");
        }

        if($password !== $confirm_password){
            array_push($errors, "The two passwords do not match");
        }

        //controlliamo il database per vedere se esiste già l'utente
        $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' ";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['username'] === $username) {
                array_push($errors, "Username already exists");
            }
        
            if ($user['email'] === $email) {
                array_push($errors, "email already exists");
            }
        }

        if(count($errors) == 0)
        {
            //criptare la password prima di salvarla nel database
            $password_criptata = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users (name, surname, username, email, password) 
            VALUES ('$name', '$surname', '$username', '$email', '$password_criptata')";

            if(mysqli_query($conn, $query)){
                // memorizziamo una variabile di sessione che ci servirà per memorizzare l'accesso dell'utente
                $_SESSION['_tuttosulcalcio_username'] = $_POST['username'];
                $_SESSION['_tuttosulcalcio_userId'] = mysqli_insert_id($conn);
                // chiduiamo la connessione
                mysqli_close($conn);
                header("Location: social.php");
            } else{
                array_push($errors, "Errore di richiesta al DB");
            }
        }

    }
?> 

<html>

    <head>
        <link rel='stylesheet' href='./style/signup.css'>
        <script src='./scripts/signup.js' defer></script>

        <title>TuttoSulCalcio - Iscriviti</title>
    </head>

    <body>
        <main class=box>
            
            <div class="info"><h3>TuttoSulCalcio - Registrazione</h3></div>

            <section class="area">
                <form name='form_signup' method="post" autocomplete="off">
                
                    <?php if (count($errors) > 0) : ?>
                        <div class="error">
                            <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php  endif ?>


                    <div class="name">
                        <div>
                            <label for='name'>Nome</label></div>
                            <div><input type='text' onkeyup="checkName()" name='name' id="name-field" <?php echo $name; ?> ></div>
                            <span class="span-hide" id="span-name">Nome non valido</span>
                        </div>

                        <div class="surname">
                            <div><label for='surname'>Cognome</label></div>
                            <div><input type='text' onkeyup="checkSurname()" name='surname' id="surname-field"<?php echo $surname; ?> ></div>
                            <span class="span-hide" id="span-surname">Cognome non valido</span>
                        </div>
                    </div>

                    <div class="username">
                        <div><label for='username'>Nome utente</label></div>
                        <div><input type='text' onkeyup="checkUsername()" name='username' id="username-field"<?php echo $username ?>></div>
                        <span class="span-hide" id="span-username">Nome utente non valido</span>
                    </div>

                    <div class="email">
                        <div><label for='email'>Email</label></div>
                        <div><input type='text' onkeyup="checkEmail()" name='email' id="email-field"<?php echo $email; ?>></div>
                        <span class="span-hide" id="span-email">Email non valida</span>
                    </div>

                    <div class="password">
                        <div><label for='password'>Password</label></div>
                        <div><input type='password' onkeyup="checkPassword()" name='password' id="password-field"></div>
                        <span class="span-hide" id="span-password">Password non valida</span>
                    </div>

                    <div class="confirm_password">
                        <div><label for='confirm_password'>Conferma Password</label></div>
                        <div><input type='password' id="confirm_password-field" onkeyup="checkConfirmPassword()" name='confirm_password'></div>
                        <span class="span-hide" id="span-confirm_password">Le password non corrispondono</span>
                    </div>

                    <div class="allow"> 
                        <div><label><input type='checkbox' name='allow' value="1" id='smallBox' onclick="checkAllow()">Acconsento al trattamento dei miei dati personali</label></div>
                        <span class="span-hide" id="span-allow">Accetta la condizione</span>
                    </div>

                    <div class="submit">
                        <button type="submit" class="btn" name="reg_user" id="register" disabled>Registrati</button>
                    </div>
                    
                    <div class="container signin">
                        <p>Hai già un account? <a href="login.php">Accedi</a>.</p>
                    </div>

                </form>
            </section>
        </main>
    </body>

</html> 
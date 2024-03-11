<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');

    function jeSilneHeslo($heslo) {
        return strlen($heslo) >= 6;
    }

    if (isset($_REQUEST['username'])) {
        $uzivatelskeJmeno = stripslashes($_REQUEST['username']);
        $uzivatelskeJmeno = mysqli_real_escape_string($con, $uzivatelskeJmeno);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $heslo = stripslashes($_REQUEST['password']);
        $heslo = mysqli_real_escape_string($con, $heslo);

        if (!jeSilneHeslo($heslo)) {
            echo "<div class='form'>
                  <h3>Heslo musí mít minimálně 6 znaků.</h3><br/>
                  <p class='link'>Klikněte zde pro <a href='registration.php'>registraci</a> znovu.</p>
                  </div>";
        } else {
            $existujiciDotaz = "SELECT * FROM users WHERE username='$uzivatelskeJmeno'";
            $existujiciVysledek = mysqli_query($con, $existujiciDotaz);

            if (mysqli_num_rows($existujiciVysledek) > 0) {
                echo "<div class='form'>
                      <h3>Uživatelské jméno již existuje.</h3><br/>
                      <p class='link'>Klikněte zde pro <a href='registration.php'>registraci</a> znovu.</p>
                      </div>";
            } else {
                $datumVytvoreni = date("Y-m-d H:i:s");
                $dotaz    = "INSERT INTO `users` (username, password, email, create_datetime)
                             VALUES ('$uzivatelskeJmeno', '" . md5($heslo) . "', '$email', '$datumVytvoreni')";
                $vysledek   = mysqli_query($con, $dotaz);

                if ($vysledek) {
                    echo "<div class='form'>
                          <h3>Registrace proběhla úspěšně.</h3><br/>
                          <p class='link'>Klikněte zde pro <a href='login.php'>přihlášení</a></p>
                          </div>";
                } else {
                    echo "<div class='form'>
                          <h3>Chybí povinná pole.</h3><br/>
                          <p class='link'>Klikněte zde pro <a href='registration.php'>registraci</a> znovu.</p>
                          </div>";
                }
            }
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registrace</h1>
        <input type="text" class="login-input" name="username" placeholder="Uživatelské jméno" required />
        <input type="text" class="login-input" name="email" placeholder="E-mail (volitelný)">
        <input type="password" class="login-input" name="password" placeholder="Heslo" required>
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link">Máte již účet? <a href="login.php">Přihlásit se zde</a></p>
    </form>
<?php
    }
?>
</body>
</html>

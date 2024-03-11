<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');
    session_start();

    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);

        $query = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysqli_error());
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = $row['is_admin'];
            header("Location: index.php");
        } else {
            echo "<div class='form'>
                <h3>Špatné uživatelské jméno/heslo.</h3><br/>
                <p class='link'>Klikněte zde pro <a href='login.php'>Přihlášení</a> znovu.</p>
            </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Přihlášení</h1>
        <input type="text" class="login-input" name="username" placeholder="Uživatelské jméno" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Heslo"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link">Nemáte jěště účet? <a href="registration.php">Registrujte se zde</a></p>
    </form>
<?php
    }
?>
</body>
</html>

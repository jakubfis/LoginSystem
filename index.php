<?php
session_start();

// Ověření, zda je uživatel admin
if (isset($_POST['priv_web'])) {
    if ($_SESSION['is_admin'] == 1) {
        header("Location: priv.php");
        exit();
    } else {
        echo '<script>alert("Nemáte dostatečná oprávnění!");</script>';
    }
}

// Dotaz do databáze pro získání citátů
require('db.php');
$query = "SELECT citat, autor FROM citaty";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        * {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: darkgray;
        }
        header {
            height: 75px;
            background-color: #8B0000;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%236f0000' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%23530000' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%23380000' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%231c0000' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23000000' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%231a001a' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23330033' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%234d004d' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%23660066' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%23800080' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-top: 3px solid black;
            border-bottom: 3px solid black;
            
        }
        header img{
            width: 5%;
            height: 90%;
            margin-left: 25px;
        }
        .box {
            background-color: gray;
            width: 75px;
            height: 45px;
            text-align: center;
            display: flex;
            justify-content: center;
            border-radius: 20px;
            border: solid black 2px;
        }
        #logout a {
            color: white;
            text-decoration: none;
            margin: auto;
            display: inline-block;
            width: 100%;
            height: 100%;
            margin-top: 12px;
        }
        #priv:hover, #logout:hover {
            background-color: darkgray;
            cursor: pointer;
        }
        #priv {
            margin-left: auto;
            width: 85px;
        }
        #logout {
            display: flex;
            align-items: center;
            margin-left: 15px;
            margin-right: 5px;
        }
        #priv form {
            color: white;
            display: flex;
            height: 100%;
        }
        #priv form input {
            width: 100%;
            height: 100%;
            background-color: inherit;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0;
            appearance: none;
        }
        
        .background {
            height: 250px;
            overflow: hidden;
            position: relative;
            border-bottom: 2px solid black;
            background-color: black;
        }
        .background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(1px);
            
            
        }
        h1 {
            position: absolute;
            font-size: 50px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-shadow: 1px 0px 1px #aaaaaa, 0px 1px 1px #aaaaaa, 2px 1px 1px #aaaaaa, 1px 2px 1px #aaaaaa, 3px 2px 1px #aaaaaa, 2px 3px 1px #aaaaaa, 4px 3px 1px #aaaaaa, 3px 4px 1px #aaaaaa, 5px 4px 1px #aaaaaa, 4px 5px 1px #aaaaaa, 6px 5px 1px #aaaaaa, 5px 6px 1px #aaaaaa, 7px 6px 1px #aaaaaa, 2px 2px 2px rgba(57, 0, 57, 0);
            color: #000000;
            z-index: 2;
        }
        .main {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            min-height: 55vh;
            background-color: #390039;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='435' height='435' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23730073' stroke-width='1.4'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%23720072'%3E%3Ccircle cx='769' cy='229' r='5'/%3E%3Ccircle cx='539' cy='269' r='5'/%3E%3Ccircle cx='603' cy='493' r='5'/%3E%3Ccircle cx='731' cy='737' r='5'/%3E%3Ccircle cx='520' cy='660' r='5'/%3E%3Ccircle cx='309' cy='538' r='5'/%3E%3Ccircle cx='295' cy='764' r='5'/%3E%3Ccircle cx='40' cy='599' r='5'/%3E%3Ccircle cx='102' cy='382' r='5'/%3E%3Ccircle cx='127' cy='80' r='5'/%3E%3Ccircle cx='370' cy='105' r='5'/%3E%3Ccircle cx='578' cy='42' r='5'/%3E%3Ccircle cx='237' cy='261' r='5'/%3E%3Ccircle cx='390' cy='382' r='5'/%3E%3C/g%3E%3C/svg%3E");            justify-content: center; /* Zarovnání na střed */
            align-items: flex-start;
        }
        .citat {
            width: 30%;
            margin: 10px;
            background-color: white;
            border: 3px solid black;
            box-shadow: 5px;
            border-radius: 20px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="assets/pen-ruler-svgrepo-com.svg" alt="logo">
        <div class="box" id="priv">
            <!-- Přidáváme formulář pro odeslání stisknutí tlačítka -->
            <form method="post">
                <input type="submit" name="priv_web" value="Privátní Web">
            </form>
        </div>
        <div class="box" id="logout"><a href="logout.php" type="button">Odhlášení</a></div>
    </header>
    
    <div class="background"><img src="assets/kniha1.webp" alt="pozadiKod"><h1>Stránka na citáty</h1></div>
    <div class="main">
        <?php
        // Zobrazování citátů z databáze
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="citat">';
            echo '<p><strong>Citat:</strong> ' . $row['citat'] . '</p>';
            echo '<p><strong>Autor: -<i></strong> ' . $row['autor'] . '</p></i>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>



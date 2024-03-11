<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Přidat citát</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(45deg, rgba(139, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 50%, rgba(128, 0, 128, 1) 100%);
        }

        .menu {
            display: flex;
            flex-direction: column;
            margin-top: 50px;
            width: 450px;
            max-height: 550px;
            background-color: gray;
            padding: 20px;
            box-shadow: 0px 0px 10px gray;
            overflow-y: auto;
            background-color: white;
            border: 5px solid darkgray;
            align-items: center;
            text-align: center;
        }

        .menu input {
            margin-top: 5px;
        }

        #autor {
            width: 150px;
        }

        #citat {
            width: 350px;
            height: 50px;
        }

        h2 {
            text-align: center;
        }

        #citat {
            resize: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #BC13FE;
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .back {
            display: flex;
            margin-top: -15px;
            margin-bottom: -35px;
            margin-left: -400px;
            font-size: 50px;
        }

        .back a {
            color: black;
            text-decoration: none;
            margin-right: 5px;
        }

        .back a:hover {
            text-decoration: none;
        }
        .login-button {
            color: #fff;
            background: #BC13FE;
            border: 0;
            outline: 0;
            width: 50%;
            height: 50px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="menu">
        <div class="back"><a href="index.php">←</a></div>
        <h2>Přidat citát</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="citat"><b>Citat:</b></label><br>
            <textarea name="citat" id="citat" required></textarea><br>
            <label for="autor"><b>Autor:</b></label><br>
            <input type="text" name="autor" id="autor" required><br>
            <input type="submit" value="Poslat" class="login-button">
        </form>

        <?php
        session_start();

        // Připojení k databázi
        require('db.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $citat = mysqli_real_escape_string($con, $_POST['citat']);
            $autor = mysqli_real_escape_string($con, $_POST['autor']);

            // Vložení citátu do databáze
            $query = "INSERT INTO citaty (citat, autor, datum) VALUES ('$citat', '$autor', NOW())";

            if (mysqli_query($con, $query)) {
                echo "Citát byl úspěšně přidán do databáze.";
            } else {
                echo "Chyba při přidávání citátu: " . mysqli_error($con);
            }
        }

        // Získání citátů z databáze
        $query_select = "SELECT id, citat, autor FROM citaty";
        $result_select = mysqli_query($con, $query_select);
        ?>

        <h2>Všechny citáty</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Citat</th>
                <th>Autor</th>
                <th>Akce</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result_select)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['citat']}</td>";
                echo "<td>{$row['autor']}</td>";
                echo "<td><button class='delete-btn' onclick='deleteQuote({$row['id']})'>Smazat</button></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <script>
            function deleteQuote(id) {
                if (confirm("Opravdu chcete smazat tento citát?")) {
                    window.location.href = `delete_quote.php?id=${id}`;
                }
            }
        </script>

        <?php
        // Zavření připojení k databázi
        mysqli_close($con);
        ?>
    </div>
</body>

</html>

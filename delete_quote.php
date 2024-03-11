<?php
session_start();

// Připojení k databázi
require('db.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);

    // Odstranění citátu z databáze
    $query = "DELETE FROM citaty WHERE id = '$id'";

    if (mysqli_query($con, $query)) {
        header("Location: priv.php");
    } else {
        echo "Chyba při mazání citátu: " . mysqli_error($con);
    }
} else {
    echo "Neplatný požadavek na smazání citátu.";
}

// Zavření připojení k databázi
mysqli_close($con);
?>

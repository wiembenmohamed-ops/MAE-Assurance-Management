<?php
include 'db-connect.php';

// Vérifier la présence de l'ID dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête de suppression de la base de données
    $sql = "DELETE FROM contrats WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Retour à la liste après une suppression réussie
        header("Location: liste-contrats.php");
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($conn);
    }
} else {
    // Retour à la liste si l'ID n'existe pas
    header("Location: liste-contrats.php");
}
?>
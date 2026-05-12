<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$nom_base_de_donnees = "inasurance-db";

$conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$conn->set_charset("utf8");


?>

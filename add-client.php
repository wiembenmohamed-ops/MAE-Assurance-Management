<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db-connect.php';

$message = "";

// Vérification : vérifier d'abord si le bouton Enregistrer a été cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_save'])) {

    // Récupération sécurisée des données du formulaire
    $nom_complet = mysqli_real_escape_string($conn, $_POST['nom_complet']);
    $cin = mysqli_real_escape_string($conn, $_POST['cin']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);

    // Requête d'insertion dans la base de données
    $sql = "INSERT INTO clients (nom_complet, cin, telephone, adresse)
            VALUES ('$nom_complet', '$cin', '$telephone', '$adresse')";

    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert success'>Client ajouté avec succès !</div>";
    } else {
        $message = "<div class='alert error'>Erreur lors de l'ajout : " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Client</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .form-container { max-width: 500px; margin: 30px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
        input, textarea { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #218838; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #1e7e34; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 15px; text-align: center; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #2980b9; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Nouveau Client</h2>

    <?php echo $message; ?>

    <form action="add-client.php" method="POST">
        <label>Nom Complet</label>
        <input type="text" name="nom_complet" placeholder="Ex: Jean Dupont" required>

        <label>Numéro CIN</label>
        <input type="text" name="cin" placeholder="Ex: 01234567" required>

        <label>Téléphone</label>
        <input type="text" name="telephone" placeholder="Ex: 216XXXXXXXX" required>

        <label>Adresse</label>
        <textarea name="adresse" rows="3" placeholder="Adresse complète..."></textarea>

        <button type="submit" name="btn_save">Enregistrer le client</button>
    </form>

    <a href="dashboard.php" class="back-link">← Retour au Tableau de Bord</a>
</div>

</body>
</html>
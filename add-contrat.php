<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db-connect.php';

// 1. Récupérer la liste des clients pour la liste déroulante
$query_clients = "SELECT id, nom_complet FROM clients ORDER BY nom_complet ASC";
$result_clients = mysqli_query($conn, $query_clients);

$message = "";

// 2. Traitement du formulaire lors de l'envoi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_save'])) {
    $client_id = mysqli_real_escape_string($conn, $_POST['client_id']);
    $type = mysqli_real_escape_string($conn, $_POST['type_assurance']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix_total']);
    $debut = mysqli_real_escape_string($conn, $_POST['date_debut']);
    $fin = mysqli_real_escape_string($conn, $_POST['date_fin']);

    // Requête d'insertion
    $sql = "INSERT INTO contrats (client_id, type_assurance, prix_total, date_debut, date_fin)
            VALUES ('$client_id', '$type', '$prix', '$debut', '$fin')";

    if (mysqli_query($conn, $sql)) {
        $message = "<div style='background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                        Succès : Le contrat a été ajouté avec succès !
                    </div>";
    } else {
        $message = "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                        Erreur : " . mysqli_error($conn) . "
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Contrat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; }
        .form-container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        select, input { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-save { width: 100%; padding: 12px; background-color: #34495e; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .btn-save:hover { background-color: #2c3e50; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #3498db; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Nouveau Contrat</h2>

        <?php echo $message; ?>

        <form action="add-contrat.php" method="POST">
            <label>Sélectionner le Client :</label>
            <select name="client_id" required>
                <option value="">-- Choisir un client --</option>
                <?php while($row = mysqli_fetch_assoc($result_clients)): ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['nom_complet']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Type d'assurance :</label>
            <input type="text" name="type_assurance" placeholder="Ex: Automobile, Habitation" required>

            <label>Prix Total (DT) :</label>
            <input type="number" step="0.001" name="prix_total" placeholder="0.000" required>

            <label>Date Début :</label>
            <input type="date" name="date_debut" required>

            <label>Date Fin :</label>
            <input type="date" name="date_fin" required>

            <button type="submit" name="btn_save" class="btn-save">Enregistrer le contrat</button>
        </form>

        <a href="liste-contrats.php" class="back-link">← Retour à la liste</a>
    </div>

</body>
</html>

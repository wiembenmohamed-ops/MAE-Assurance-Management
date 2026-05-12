<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db-connect.php';

// 1. Récupération de l'ID depuis l'URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Récupérer les données actuelles du contrat
    $sql_contrat = "SELECT * FROM contrats WHERE id = '$id'";
    $result_contrat = mysqli_query($conn, $sql_contrat);
    $contrat = mysqli_fetch_assoc($result_contrat);

    if (!$contrat) {
        die("Contrat non trouvé.");
    }
} else {
    header("Location: liste-contrats.php");
    exit();
}

// 2. Récupérer la liste des clients pour la sélection
$query_clients = "SELECT id, nom_complet FROM clients ORDER BY nom_complet ASC";
$result_clients = mysqli_query($conn, $query_clients);

$message = "";

// 3. Traitement de la mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_update'])) {
    $client_id = mysqli_real_escape_string($conn, $_POST['client_id']);
    $type = mysqli_real_escape_string($conn, $_POST['type_assurance']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix_total']);
    $debut = mysqli_real_escape_string($conn, $_POST['date_debut']);
    $fin = mysqli_real_escape_string($conn, $_POST['date_fin']);

    $sql_update = "UPDATE contrats SET
                   client_id = '$client_id',
                   type_assurance = '$type',
                   prix_total = '$prix',
                   date_debut = '$debut',
                   date_fin = '$fin'
                   WHERE id = '$id'";

    if (mysqli_query($conn, $sql_update)) {
        $message = "<div style='background-color: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                        Le contrat a été mis à jour avec succès !
                    </div>";
        header("Refresh:2; url=liste-contrats.php");
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
    <title>Modifier le Contrat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; }
        .form-container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        select, input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-update { width: 100%; padding: 12px; background-color: #2980b9; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; font-size: 16px; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Modifier le Contrat #<?php echo $id; ?></h2>

        <?php echo $message; ?>

        <form action="" method="POST">
            <label>Client :</label>
            <select name="client_id" required>
                <?php while($row_c = mysqli_fetch_assoc($result_clients)): ?>
                    <option value="<?php echo $row_c['id']; ?>" <?php if($row_c['id'] == $contrat['client_id']) echo 'selected'; ?>>
                        <?php echo $row_c['nom_complet']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Type d'Assurance :</label>
            <input type="text" name="type_assurance" value="<?php echo $contrat['type_assurance']; ?>" required>

            <label>Prix Total (DT) :</label>
            <input type="number" step="0.001" name="prix_total" value="<?php echo $contrat['prix_total']; ?>" required>

            <label>Date de Début :</label>
            <input type="date" name="date_debut" value="<?php echo $contrat['date_debut']; ?>" required>

            <label>Date de Fin :</label>
            <input type="date" name="date_fin" value="<?php echo $contrat['date_fin']; ?>" required>

            <button type="submit" name="btn_update" class="btn-update">Enregistrer les modifications</button>
        </form>

        <a href="liste-contrats.php" class="back-link">Annuler et retourner</a>
    </div>

</body>
</html>

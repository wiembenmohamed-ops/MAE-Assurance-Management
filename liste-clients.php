<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'db-connect.php';

// Récupérer la liste des clients depuis la base de données
$sql = "SELECT * FROM clients ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clients - Assurance</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #2c3e50; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-add { display: inline-block; padding: 10px 15px; background-color: #27ae60; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Liste des Clients</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Complet</th>
                <th>CIN</th>
                <th>Téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom_complet']; ?></td>
                <td><?php echo $row['cin']; ?></td>
                <td><?php echo $row['telephone']; ?></td>
                <td><?php echo $row['adresse']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
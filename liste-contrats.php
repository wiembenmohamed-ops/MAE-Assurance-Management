<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db-connect.php';

// Initialiser la variable de recherche
$recherche = "";

if (isset($_GET['query'])) {
    $recherche = mysqli_real_escape_string($conn, $_GET['query']);
    // Requête avec recherche par type d'assurance ou nom du client
    $sql = "SELECT contrats.*, clients.nom_complet
            FROM contrats
            JOIN clients ON contrats.client_id = clients.id
            WHERE contrats.type_assurance LIKE '%$recherche%'
            OR clients.nom_complet LIKE '%$recherche%'
            ORDER BY contrats.id DESC";
} else {
    // Requête par défaut pour afficher tous les contrats
    $sql = "SELECT contrats.*, clients.nom_complet
            FROM contrats
            JOIN clients ON contrats.client_id = clients.id
            ORDER BY contrats.id DESC";
}

$resultat = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Contrats</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }

        /* تصميم شريط البحث */
        .search-box { margin-bottom: 20px; display: flex; gap: 10px; justify-content: center; }
        .search-box input { padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 5px; }
        .search-box button { padding: 10px 20px; background-color: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .btn-reset { padding: 10px; color: #e74c3c; text-decoration: none; font-size: 0.9em; }

        /* تصميم الجدول */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #2c3e50; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: #f1f1f1; }

        .btn-edit { color: #3498db; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .back-link { display: block; text-align: right; margin-bottom: 10px; color: #3498db; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <a href="dashboard.php" class="back-link">← Retour au Dashboard</a>
    <h2>Liste des Contrats</h2>

    <div class="search-box">
        <form action="liste-contrats.php" method="GET">
            <input type="text" name="query" placeholder="Rechercher par type ou client..." value="<?php echo $recherche; ?>">
            <button type="submit">Rechercher</button>
            <?php if ($recherche != ""): ?>
                <a href="liste-contrats.php" class="btn-reset">Réinitialiser</a>
            <?php endif; ?>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Type</th>
                <th>Prix (DT)</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultat)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom_complet']; ?></td>
                <td><?php echo $row['type_assurance']; ?></td>
                <td><?php echo number_format($row['prix_total'], 3); ?></td>
                <td><?php echo $row['date_debut']; ?></td>
                <td><?php echo $row['date_fin']; ?></td>
                <td>
                    <a href="modifier-contrat.php?id=<?php echo $row['id']; ?>" class="btn-edit">Modifier</a>
                    <a href="supprimer-contrat.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')">Supprimer</a>
                </td>
            </tr>
            <?php endwhile; ?>

            <?php if (mysqli_num_rows($resultat) == 0): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Aucun contrat trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
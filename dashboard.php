<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db-connect.php';

// 1. Récupération des statistiques depuis la base de données
// Nombre de clients
$res_clients = mysqli_query($conn, "SELECT COUNT(*) as total FROM clients");
$count_clients = mysqli_fetch_assoc($res_clients)['total'];

// Nombre de contrats
$res_contrats = mysqli_query($conn, "SELECT COUNT(*) as total FROM contrats");
$count_contrats = mysqli_fetch_assoc($res_contrats)['total'];

// Chiffre d'affaires total
$res_sum = mysqli_query($conn, "SELECT SUM(prix_total) as total_prix FROM contrats");
$row_sum = mysqli_fetch_assoc($res_sum);
$sum_prix = $row_sum['total_prix'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Assurance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 1000px; margin: auto; padding: 20px; }
        h1 { color: #2c3e50; }

        /* --- Code des statistiques --- */
        .stats-container { display: flex; gap: 20px; margin-top: 30px; }
        .stat-card {
            background: white; padding: 25px; border-radius: 8px;
            text-align: center; flex: 1; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-top: 5px solid #2980b9; transition: 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card h3 { font-size: 0.9em; color: #7f8c8d; margin-bottom: 10px; }
        .stat-card p { font-size: 2.2em; font-weight: bold; margin: 0; color: #2c3e50; }

        /* --- Style des boutons d'action --- */
        .actions-container { display: flex; gap: 15px; margin-top: 40px; }
        .action-btn {
            flex: 1; background: white; color: #2980b9; padding: 20px;
            border: 2px solid #2980b9; border-radius: 12px;
            font-weight: bold; text-align: center; transition: 0.3s;
            text-decoration: none; display: block;
        }
        .action-btn:hover { background: #2980b9; color: white; transform: scale(1.02); }

        .logout-link { color: #e74c3c; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>Bienvenue, <?php echo $_SESSION['username']; ?></h1>
    <p>Voici un aperçu de l'activité de votre agence :</p>

    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Clients</h3>
            <p><?php echo $count_clients; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Contrats</h3>
            <p><?php echo $count_contrats; ?></p>
        </div>
        <div class="stat-card">
            <h3>Chiffre d'Affaires</h3>
            <p><?php echo number_format($sum_prix, 2); ?> DT</p>
        </div>
    </div>

    <h2 style="border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-top: 50px;">Actions Rapides</h2>

    <div class="actions-container">
        <a href="add-client.php" class="action-btn">Ajouter un Client</a>
        <a href="add-contrat.php" class="action-btn">Nouveau Contrat</a>
        <a href="liste-contrats.php" class="action-btn">Liste des Contrats</a>
    </div>

    <div style="margin-top: 50px; text-align: center;">
        <a href="logout.php" class="logout-link">Se déconnecter</a>
    </div>
</div>

</body>
</html>
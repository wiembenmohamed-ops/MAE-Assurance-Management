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
$sum_prix = mysqli_fetch_assoc($res_sum)['total_prix'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Locallux</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; }
        h1 { color: #2c3e50; }

        /* --- كود الإحصائيات الجديد --- */
        .stats-container { display: flex; gap: 20px; margin-bottom: 40px; margin-top: 20px; }
        .stat-card {
            background: white; padding: 25px; border-radius: 12px; flex: 1;
            text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-top: 5px solid #2980b9; transition: 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card h3 { font-size: 0.9em; color: #7f8c8d; margin: 0; text-transform: uppercase; }
        .stat-card p { font-size: 2.2em; font-weight: bold; margin: 10px 0 0 0; color: #2c3e50; }

        /* --- تنسيقات الأزرار الخاصة بكِ --- */
        .actions-container { display: flex; gap: 15px; margin-top: 20px; }
        .action-btn {
            flex: 1; background: white; color: #2980b9; padding: 25px;
            border: 2px solid #2980b9; border-radius: 12px; text-decoration: none;
            font-weight: bold; text-align: center; transition: 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .action-btn:hover {
            background: #2980b9; color: white; transform: translateY(-3px);
        }
        h2 { margin-top: 40px; color: #2c3e50; font-size: 1.5em; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Bienvenue, <?php echo $_SESSION['username']; ?> !</h1>
        <p>Voici un aperçu de l'activité de votre agence aujourd'hui :</p>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Clients</h3>
                <p><?php echo $count_clients; ?></p>
            </div>
            <div class="stat-card" style="border-top-color: #27ae60;">
                <h3>Total Contrats</h3>
                <p><?php echo $count_contrats; ?></p>
            </div>
            <div class="stat-card" style="border-top-color: #f1c40f;">
                <h3>Chiffre d'Affaires</h3>
                <p><?php echo number_format($sum_prix, 3); ?> <small style="font-size: 0.5em;">DT</small></p>
            </div>
        </div>

        <h2 style="border-bottom: 2px solid #ddd; padding-bottom: 10px;">Actions Rapides</h2>

        <div class="actions-container">
            <a href="add-client.php" class="action-btn">👤 Nouveau Client</a>
            <a href="add-contrat.php" class="action-btn">📝 Nouveau Contrat</a>
            <a href="liste-contrats.php" class="action-btn">📋 Liste des Contrats</a>
        </div>

        <div style="margin-top: 50px; text-align: center;">
            <a href="logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold;">🚪 Se déconnecter</a>
        </div>
    </div>

</body>
</html>
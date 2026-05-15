<?php
session_start();
include 'db-connect.php';

$error = "";

if (isset($_POST['btn_login'])) {
    // Vérifier l'utilisation des noms de colonnes corrects dans votre base de données
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Requête modifiée pour correspondre aux noms de colonnes : nom_utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = '$user'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Vérification simple du mot de passe
        if ($pass == $row['mot_de_passe']) {
            $_SESSION['username'] = $row['nom_utilisateur'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Gestion d'Assurance</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f4f4; }
        .login-box { background: white; padding: 40px; margin: 100px auto; width: 300px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin-bottom: 10px; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #2c3e50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #34495e; }
        .error-msg { color: #721c24; background-color: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 4px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="btn_login">Se connecter</button>
        </form>
    </div>
</body>
</html>
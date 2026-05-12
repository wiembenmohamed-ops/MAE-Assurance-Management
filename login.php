<?php
session_start();
include 'db-connect.php';

$error = "";

if (isset($_POST['btn_login'])) {
    // تأكد من استخدام أسماء الحقول الصحيحة من قاعدة بياناتك
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // تم تعديل الاستعلام ليطابق أسماء الأعمدة في صورتك: nom_utilisateur و mot_de_pass
    $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = '$user' AND mot_de_pass = '$pass'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['nom_utilisateur'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Gestion d'Assurance</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 380px; }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #218838; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .error-msg { color: #721c24; background-color: #f8d7da; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 14px; border: 1px solid #f5c6cb; }
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
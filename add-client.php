<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db-connect.php';

$message = "";

// التعديل هنا: نتحقق أولاً إذا تم الضغط على زر الحفظ
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_save'])) {

    // الآن نقوم بجلب البيانات بأمان
    $nom_complet = mysqli_real_escape_string($conn, $_POST['nom_complet']);
    $cin = mysqli_real_escape_string($conn, $_POST['cin']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);

    $sql = "INSERT INTO clients (nom_complet, cin, telephone, adresse)
            VALUES ('$nom_complet', '$cin', '$telephone', '$adresse')";

    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert success'>Client ajouté avec succès !</div>";
    } else {
        $message = "<div class='alert error'>Erreur : " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Client</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .form-container { max-width: 500px; margin: 30px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input, textarea { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; }
        button:hover { background-color: #218838; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Nouveau Client</h2>

    <?php echo $message; ?>

    <form action="add-client.php" method="POST">
        <label>Nom Complet</label>
        <input type="text" name="nom_complet" placeholder="Ex: Wiem Ben Mohamed" required>

        <label>Numéro CIN</label>
        <input type="text" name="cin" placeholder="Ex: 01234567" required>

        <label>Téléphone</label>
        <input type="text" name="telephone" placeholder="Ex: 22113344">

        <label>Adresse</label>
        <textarea name="adresse" rows="3" placeholder="Adresse du client..."></textarea>

        <button type="submit" name="btn_save">Enregistrer le Client</button>
    </form>

    <a href="dashboard.php" class="back-link">← Retour au Tableau de Bord</a>
</div>

</body>
</html>

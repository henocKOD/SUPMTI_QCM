<?php
session_start();

// Sécurité : vérifie que l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../script.js" defer></script>
</head>
<body>
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div class="fade-in container">
        <h1>Bienvenue <?= htmlspecialchars($_SESSION['admin']) ?> 👋</h1>

        <div class="button-group">
            <a href="ajouter_question.php" class="button">➕ Ajouter une question</a>
            <a href="gerer_questions.php" class="button">📝 Gérer les questions</a>
            <a href="resultats.php" class="button">📊 Voir les résultats</a>
            <a href="deconnexion.php" class="button red">🚪 Se déconnecter</a>
        </div>
    </div>
</body>
</html>

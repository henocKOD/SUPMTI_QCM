<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base
    $conn = new mysqli("localhost", "root", "", "qcm_db"); // adapte selon ton serveur

    if ($conn->connect_error) {
        die("Erreur connexion : " . $conn->connect_error);
    }

    // Sécurisation des données
    $section = $_POST['section'];
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $bonne_reponse = $_POST['bonne_reponse'];

    $stmt = $conn->prepare("INSERT INTO questions (section, question, option1, option2, option3, option4, bonne_reponse) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $section, $question, $option1, $option2, $option3, $option4, $bonne_reponse);

    if ($stmt->execute()) {
        $message = "✅ Question ajoutée avec succès !";
    } else {
        $message = "❌ Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Question</title>
    <link rel="stylesheet" href="../style.css">
    <script src="../script.js" defer></script>
</head>
<body>
<div id="loader"><div class="spinner"></div></div>

<div class="fade-in container">
    <h1>➕ Ajouter une nouvelle question</h1>

    <?php if ($message): ?>
        <p class="success-message"><?= $message ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>Section :</label><br>
        <select name="section" required>
            <option value="">Choisir une section</option>
            <option value="Langage C">Langage C</option>
            <option value="Programmation Web">Programmation Web</option>
            <option value="Linux">Linux</option>
            <option value="Anglais">Anglais</option>
        </select><br><br>

        <label>Question :</label><br>
        <textarea name="question" rows="3" required></textarea><br><br>

        <label>Option A :</label><br>
        <input type="text" name="option1" required><br><br>

        <label>Option B :</label><br>
        <input type="text" name="option2" required><br><br>

        <label>Option C :</label><br>
        <input type="text" name="option3" required><br><br>

        <label>Option D :</label><br>
        <input type="text" name="option4" required><br><br>

        <label>Bonne réponse (A, B, C ou D) :</label><br>
        <input type="text" name="bonne_reponse" maxlength="1" pattern="[A-Da-d]" required><br><br>

        <input type="submit" value="Enregistrer la question">
    </form>
</div>
</body>
</html>

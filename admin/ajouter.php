<?php
include '../config.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $reponses = $_POST['reponses'];
    $correct = $_POST['correct']; // Index de la bonne réponse

    $stmt = $conn->prepare("INSERT INTO questions (question) VALUES (?)");
    $stmt->execute([$question]);
    $id_question = $conn->lastInsertId();

    foreach ($reponses as $i => $texte) {
        $is_correct = ($i == $correct) ? 1 : 0;
        $req = $conn->prepare("INSERT INTO reponses (id_question, reponse, est_correct) VALUES (?, ?, ?)");
        $req->execute([$id_question, $texte, $is_correct]);
    }

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une question</title>
    <link rel="stylesheet" href="../style.css">

</head>
<body>
    <h2>Ajouter une nouvelle question</h2>
    <form method="post">
        <label>Question :</label><br>
        <textarea name="question" required></textarea><br><br>

        <label>Réponses :</label><br>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <input type="text" name="reponses[]" required>
            <input type="radio" name="correct" value="<?= $i ?>" required> ✅ Correct<br>
        <?php endfor; ?>

        <br>
        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>

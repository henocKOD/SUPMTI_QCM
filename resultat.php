<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si le formulaire a été soumis (redirection depuis qcm.php)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$section_id = $_POST['section_id'];
$niveau_id = $_POST['niveau_id'];
$reponses_utilisateur = $_POST['reponse'] ?? []; // Réponses soumises par l'utilisateur

try {
    // Récupérer toutes les questions du QCM et leurs bonnes réponses
    $stmt_questions = $pdo->prepare("
        SELECT id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse 
        FROM questions 
        WHERE section_id = ? 
        AND niveau_id = ?
    ");
    $stmt_questions->execute([$section_id, $niveau_id]);
    $questions_qcm = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);

    // Calculer le score et préparer les détails des réponses
    $score = 0;
    $total_questions = count($questions_qcm);
    $details_reponses = [];

    foreach ($questions_qcm as $question) {
        $question_id = $question['id'];
        $reponse_utilisateur = $reponses_utilisateur[$question_id] ?? null;
        $bonne_reponse = $question['bonne_reponse'];
        
        // Convertir la bonne réponse en indice (1, 2, 3 ou 4)
        $bonne_reponse_index = null;
        for ($i = 1; $i <= 4; $i++) {
            if ($question['reponse' . $i] === $bonne_reponse) {
                $bonne_reponse_index = (string)$i;
                break;
            }
        }
        
        $est_correcte = ($reponse_utilisateur === $bonne_reponse_index);

        if ($est_correcte) {
            $score++;
        }

        $details_reponses[] = [
            'question' => $question['question'],
            'reponse_utilisateur' => $question['reponse' . $reponse_utilisateur] ?? 'Non répondu',
            'bonne_reponse' => $bonne_reponse,
            'est_correcte' => $est_correcte,
            'options' => [
                $question['reponse1'],
                $question['reponse2'],
                $question['reponse3'],
                $question['reponse4']
            ]
        ];
    }

    $pourcentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;

    // Enregistrer le résultat dans la base de données
    $stmt_save_result = $pdo->prepare("
        INSERT INTO resultats (user_id, section_id, niveau_id, score, date_creation)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt_save_result->execute([$user_id, $section_id, $niveau_id, $pourcentage]);

} catch(PDOException $e) {
    die("Erreur lors du calcul ou de l'enregistrement des résultats : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du QCM - QCM Platform</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="dashboard-nav">
        <div class="nav-brand">QCM Platform</div>
        <div class="nav-user">
            <a href="dashboard.php">Tableau de bord</a>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </nav>

    <main class="resultat-container">
        <div class="resultat-header">
            <h1>Résultat du QCM</h1>
        </div>

        <div class="resultat-content">
            <div class="score-card">
                <h2>Votre score</h2>
                <div class="score-value"><?php echo round($pourcentage); ?>%</div>
                <p><?php echo $score; ?> réponses correctes sur <?php echo $total_questions; ?> questions</p>
            </div>

            <?php if ($pourcentage >= 70): ?>
                <div class="success-message">
                    <h3>Félicitations !</h3>
                    <p>Vous avez réussi ce niveau avec succès.</p>
                </div>
            <?php else: ?>
                <div class="error-message">
                    <h3>Dommage !</h3>
                    <p>Vous n'avez pas atteint le score minimum de 70%.</p>
                </div>
            <?php endif; ?>

            <div class="question-review">
                <h2>Vos réponses</h2>
                <?php foreach ($details_reponses as $detail): ?>
                    <div class="review-item <?php echo $detail['est_correcte'] ? 'correct-answer' : 'incorrect-answer'; ?>">
                        <p class="review-question"><strong>Q:</strong> <?php echo htmlspecialchars($detail['question']); ?></p>
                        <p class="review-user-answer">Votre réponse: <span><?php echo htmlspecialchars($detail['reponse_utilisateur']); ?></span></p>
                        <p class="review-correct-answer">Bonne réponse: <span><?php echo htmlspecialchars($detail['bonne_reponse']); ?></span></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="resultat-actions">
                <a href="section.php?id=<?php echo $section_id; ?>" class="btn-primary">Retour à la section</a>
                <a href="dashboard.php" class="btn-secondary">Retour au tableau de bord</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html>

<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si les paramètres sont fournis
if (!isset($_GET['section']) || !isset($_GET['niveau'])) {
    header('Location: dashboard.php');
    exit();
}

$section_id = $_GET['section'];
$niveau_id = $_GET['niveau']; // C'est l'ID du niveau, pas sa difficulté
$user_id = $_SESSION['user_id'];

try {
    // Récupérer les détails du niveau pour obtenir sa difficulté et son nom
    $stmt_niveau = $pdo->prepare("SELECT * FROM niveaux WHERE id = ? AND section_id = ?");
    $stmt_niveau->execute([$niveau_id, $section_id]);
    $current_niveau_details = $stmt_niveau->fetch();

    if (!$current_niveau_details) {
        header('Location: section.php?id=' . $section_id);
        exit();
    }

    $current_niveau_difficulty = $current_niveau_details['difficulte'];

    // Vérifier si le niveau est débloqué pour cet utilisateur
    $is_unlocked = false;
    if ($current_niveau_difficulty == 1) {
        $is_unlocked = true; // Niveau Débutant (difficulté 1) toujours débloqué
    } else {
        // Pour les niveaux supérieurs, vérifier si le niveau précédent (par difficulté) a été réussi
        $stmt_check_prev = $pdo->prepare("
            SELECT COUNT(*) as count 
            FROM resultats 
            WHERE user_id = ? 
            AND section_id = ? 
            AND niveau_id = (SELECT prev_n.id FROM niveaux prev_n WHERE prev_n.section_id = ? AND prev_n.difficulte = ?) 
            AND score >= 70
        ");
        $stmt_check_prev->execute([$user_id, $section_id, $section_id, $current_niveau_difficulty - 1]);
        $prev_level_result = $stmt_check_prev->fetch();

        if ($prev_level_result['count'] > 0) {
            $is_unlocked = true;
        }
    }

    if (!$is_unlocked) {
        header('Location: section.php?id=' . $section_id);
        exit();
    }

    // Récupérer les questions du niveau
    $stmt = $pdo->prepare("
        SELECT * FROM questions 
        WHERE section_id = ? 
        AND niveau_id = ? 
        ORDER BY RAND() 
        LIMIT 10
    ");
    $stmt->execute([$section_id, $niveau_id]);
    $questions = $stmt->fetchAll();

    if (empty($questions)) {
        die("Aucune question disponible pour ce niveau.");
    }

} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCM - <?php echo htmlspecialchars($current_niveau_details['nom']); ?></title>
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

    <main class="qcm-container">
        <div class="qcm-header">
            <h1>QCM - <?php echo htmlspecialchars($current_niveau_details['nom']); ?></h1>
            <div class="timer" id="timer">Temps restant: <span id="time">10:00</span></div>
        </div>

        <form id="qcmForm" action="resultat.php" method="post">
            <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
            <input type="hidden" name="niveau_id" value="<?php echo $niveau_id; ?>">
            
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-card">
                    <h3>Question <?php echo $index + 1; ?></h3>
                    <p class="question-text"><?php echo htmlspecialchars($question['question']); ?></p>
                    
                    <div class="answers-list">
                        <?php 
                        $reponses = [
                            '1' => $question['reponse1'], 
                            '2' => $question['reponse2'], 
                            '3' => $question['reponse3'], 
                            '4' => $question['reponse4']
                        ];
                        
                        foreach ($reponses as $key => $reponse):
                        ?>
                            <div class="answer-item">
                                <input type="radio" 
                                       name="reponse[<?php echo $question['id']; ?>]" 
                                       id="q<?php echo $question['id']; ?>_r<?php echo $key; ?>" 
                                       value="<?php echo $key; ?>" 
                                       required>
                                <label for="q<?php echo $question['id']; ?>_r<?php echo $key; ?>">
                                    <?php echo htmlspecialchars($reponse); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="qcm-actions">
                <button type="submit" class="btn-primary">Terminer le QCM</button>
            </div>
        </form>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>

    <script>
        let timeLeft = 600; 
        const timerDisplay = document.getElementById('time');
        
        const timer = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                document.getElementById('qcmForm').submit();
            }
        }, 1000);
    </script>
</body>
</html>

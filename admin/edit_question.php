<?php
session_start();
require_once '../db.php';

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Vérifier si l'ID de la question est fourni
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$question_id = $_GET['id'];

// Récupérer les informations de la question
$stmt = $pdo->prepare("
    SELECT q.*, s.id as section_id, s.nom as section_nom
    FROM questions q
    JOIN sections s ON q.section_id = s.id
    WHERE q.id = ?
");
$stmt->execute([$question_id]);
$question = $stmt->fetch();

if (!$question) {
    header('Location: index.php');
    exit;
}

// Récupérer les niveaux de la section
$stmt = $pdo->prepare("SELECT * FROM niveaux WHERE section_id = ? ORDER BY difficulte");
$stmt->execute([$question['section_id']]);
$niveaux = $stmt->fetchAll();

$error = '';
$success = '';

// Traiter le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_text = trim($_POST['question'] ?? '');
    $niveau_id = $_POST['niveau_id'] ?? '';
    $reponse1 = trim($_POST['reponse1'] ?? '');
    $reponse2 = trim($_POST['reponse2'] ?? '');
    $reponse3 = trim($_POST['reponse3'] ?? '');
    $reponse4 = trim($_POST['reponse4'] ?? '');
    $bonne_reponse = $_POST['bonne_reponse'] ?? '';
    $temps_reponse = (int)($_POST['temps_reponse'] ?? 60);

    if (empty($question_text) || empty($niveau_id) || empty($reponse1) || empty($reponse2) || 
        empty($reponse3) || empty($reponse4) || empty($bonne_reponse)) {
        $error = 'Veuillez remplir tous les champs';
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE questions 
                SET niveau_id = ?, question = ?, reponse1 = ?, reponse2 = ?, 
                    reponse3 = ?, reponse4 = ?, bonne_reponse = ?, temps_reponse = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $niveau_id,
                $question_text,
                $reponse1,
                $reponse2,
                $reponse3,
                $reponse4,
                $bonne_reponse,
                $temps_reponse,
                $question_id
            ]);
            
            $success = 'Question modifiée avec succès';
            
            // Mettre à jour les données affichées
            $question['niveau_id'] = $niveau_id;
            $question['question'] = $question_text;
            $question['reponse1'] = $reponse1;
            $question['reponse2'] = $reponse2;
            $question['reponse3'] = $reponse3;
            $question['reponse4'] = $reponse4;
            $question['bonne_reponse'] = $bonne_reponse;
            $question['temps_reponse'] = $temps_reponse;
        } catch (PDOException $e) {
            $error = 'Erreur lors de la modification de la question';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une question - QCM Admin</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="admin-page">
    <nav class="admin-nav">
        <div class="nav-brand">QCM Platform - Admin</div>
        <div class="nav-user">
            <a href="index.php">Dashboard</a>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </nav>
    <main class="admin-container">
        <div class="admin-header">
            <h1>Modifier une question</h1>
        </div>
        <div class="admin-section">
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="post" class="question-form">
                <div class="form-group">
                    <label for="question">Question</label>
                    <textarea id="question" name="question" required><?php echo isset($question) ? htmlspecialchars($question) : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="niveau">Niveau</label>
                    <select id="niveau" name="niveau" required>
                        <option value="">Sélectionner un niveau</option>
                        <?php foreach ($niveaux as $niveau): ?>
                            <option value="<?php echo $niveau['id']; ?>" <?php if (isset($niveau_id) && $niveau_id == $niveau['id']) echo 'selected'; ?>><?php echo htmlspecialchars($niveau['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="temps">Temps de réponse (secondes)</label>
                    <input type="number" id="temps" name="temps" min="10" max="300" value="<?php echo isset($temps) ? htmlspecialchars($temps) : '60'; ?>" required>
                </div>
                <div class="answers-section">
                    <h3>Réponses</h3>
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="answer-input-group">
                            <input type="radio" name="bonne_reponse" value="<?php echo $i; ?>" id="bonne_reponse_<?php echo $i; ?>" <?php if (isset($bonne_reponse) && $bonne_reponse == $i) echo 'checked'; ?> required>
                            <input type="text" name="reponse<?php echo $i; ?>" placeholder="Réponse <?php echo $i; ?>" value="<?php echo isset(${'reponse'.$i}) ? htmlspecialchars(${'reponse'.$i}) : ''; ?>" required>
                            <label for="bonne_reponse_<?php echo $i; ?>">Bonne réponse</label>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Enregistrer</button>
                    <a href="questions.php?section=<?php echo $question['section_id']; ?>" class="btn-back">Retour</a>
                </div>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html> 
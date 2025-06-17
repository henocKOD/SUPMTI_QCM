<?php
session_start();
require_once '../db.php';

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Vérifier si la section est spécifiée
if (!isset($_GET['section'])) {
    header('Location: index.php');
    exit;
}

$section_id = $_GET['section'];

// Récupérer les informations de la section
$stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ?");
$stmt->execute([$section_id]);
$section = $stmt->fetch();

if (!$section) {
    header('Location: index.php');
    exit;
}

// Récupérer les niveaux de la section
$stmt = $pdo->prepare("SELECT * FROM niveaux WHERE section_id = ? ORDER BY difficulte");
$stmt->execute([$section_id]);
$niveaux = $stmt->fetchAll();

// Récupérer les questions de la section
$stmt = $pdo->prepare("
    SELECT q.*, n.nom as niveau_nom
    FROM questions q
    JOIN niveaux n ON q.niveau_id = n.id
    WHERE q.section_id = ?
    ORDER BY n.difficulte, q.id
");
$stmt->execute([$section_id]);
$questions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions - QCM Admin</title>
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
            <h1>Gestion des questions</h1>
            <h2><?php echo htmlspecialchars($section['nom']); ?></h2>
        </div>
        <div class="questions-filters">
            <form method="get" action="" style="display: flex; gap: 1rem; align-items: center;">
                <input type="hidden" name="section" value="<?php echo $section['id']; ?>">
                <select name="niveau" class="filter-select" onchange="this.form.submit()">
                    <option value="">Tous les niveaux</option>
                    <?php foreach ($niveaux as $niveau): ?>
                        <option value="<?php echo $niveau['id']; ?>" <?php if (isset($_GET['niveau']) && $_GET['niveau'] == $niveau['id']) echo 'selected'; ?>><?php echo htmlspecialchars($niveau['nom']); ?></option>
                    <?php endforeach; ?>
                </select>
                <a href="add_question.php?section=<?php echo $section['id']; ?>" class="btn-primary">Ajouter une question</a>
            </form>
        </div>
        <div class="questions-list">
            <?php foreach ($questions as $question): ?>
                <div class="question-card">
                    <div class="question-header">
                        <h3><?php echo htmlspecialchars($question['question']); ?></h3>
                        <span class="niveau-badge">Niveau : <?php echo htmlspecialchars($question['niveau_nom']); ?></span>
                    </div>
                    <div class="answers-list">
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="answer-item <?php echo $question['bonne_reponse'] == $question['reponse'.$i] ? 'correct' : ''; ?>">
                                <span class="answer-letter"><?php echo chr(64 + $i); ?></span>
                                <span class="answer-text"><?php echo htmlspecialchars($question['reponse'.$i]); ?></span>
                                <?php if ($question['bonne_reponse'] == $question['reponse'.$i]): ?>
                                    <span class="correct-badge">Bonne réponse</span>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="question-actions">
                        <a href="edit_question.php?id=<?php echo $question['id']; ?>" class="btn-primary">Modifier</a>
                        <form method="post" action="delete_question.php" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
                            <button type="submit" class="btn-danger" onclick="return confirm('Supprimer cette question ?');">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html> 
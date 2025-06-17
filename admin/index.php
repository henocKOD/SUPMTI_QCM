<?php
session_start();
require_once '../db.php';

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les statistiques
$stmt = $pdo->query("
    SELECT 
        (SELECT COUNT(*) FROM users) as total_users,
        (SELECT COUNT(*) FROM questions) as total_questions,
        (SELECT COUNT(*) FROM sessions_qcm) as total_sessions,
        (SELECT AVG(score) FROM sessions_qcm) as average_score
");
$stats = $stmt->fetch();

// Récupérer les sections
$stmt = $pdo->query("SELECT * FROM sections ORDER BY nom");
$sections = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - QCM Platform</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="admin-page">
    <nav class="admin-nav">
        <div class="nav-brand">QCM Platform - Admin</div>
        <div class="nav-user">
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </nav>
    <main class="admin-container">
        <div class="admin-header">
            <h1>Bienvenue !</h1>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Utilisateurs</h3>
                    <p><?php echo $stats['total_users']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Questions</h3>
                    <p><?php echo $stats['total_questions']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Sessions</h3>
                    <p><?php echo $stats['total_sessions']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Score moyen</h3>
                    <p><?php echo round($stats['average_score'], 1); ?>%</p>
                </div>
            </div>
        </div>
        <div class="admin-content">
            <div class="admin-section">
                <h2>Sections</h2>
                <div class="sections-list">
                    <?php foreach ($sections as $section): ?>
                        <div class="section-item">
                            <div class="section-info">
                                <h3><?php echo htmlspecialchars($section['nom']); ?></h3>
                                <p><?php echo htmlspecialchars($section['description']); ?></p>
                            </div>
                            <div class="section-actions">
                                <a href="questions.php?section=<?php echo $section['id']; ?>" class="btn-primary">Gérer</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="admin-section">
                <h2>Actions rapides</h2>
                <div class="quick-actions">
                    <a href="add_question.php" class="btn-primary">Ajouter une question</a>
                    <a href="../index.php" class="btn-primary">Voir le site</a>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html>

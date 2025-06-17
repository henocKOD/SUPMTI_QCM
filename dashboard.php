<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Récupérer les informations de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Récupérer les statistiques de l'utilisateur
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(DISTINCT r.id) as total_qcm_completes,
            COUNT(DISTINCT r.section_id) as sections_completes,
            AVG(r.score) as moyenne_generale,
            MAX(r.score) as meilleur_score,
            COUNT(DISTINCT CASE WHEN r.score >= 70 THEN r.niveau_id END) as niveaux_reussis
        FROM resultats r
        WHERE r.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $stats = $stmt->fetch();

    // Récupérer les sections disponibles
    $stmt = $pdo->prepare("SELECT * FROM sections");
    $stmt->execute();
    $sections = $stmt->fetchAll();

    // Récupérer les 5 derniers résultats
    $stmt = $pdo->prepare("
        SELECT r.*, s.nom as section_nom, n.nom as niveau_nom, n.difficulte
        FROM resultats r
        JOIN sections s ON r.section_id = s.id
        JOIN niveaux n ON r.niveau_id = n.id
        WHERE r.user_id = ?
        ORDER BY r.date_creation DESC
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $derniers_resultats = $stmt->fetchAll();

    // Calculer la progression par section
    $progression_sections = [];
    foreach ($sections as $section) {
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(DISTINCT n.id) as total_niveaux,
                COUNT(DISTINCT CASE WHEN r.score >= 70 THEN r.niveau_id END) as niveaux_reussis
            FROM niveaux n
            LEFT JOIN resultats r ON r.niveau_id = n.id AND r.user_id = ? AND r.section_id = ?
            WHERE n.section_id = ?
        ");
        $stmt->execute([$user_id, $section['id'], $section['id']]);
        $prog = $stmt->fetch();
        
        $progression_sections[$section['id']] = [
            'nom' => $section['nom'],
            'total_niveaux' => $prog['total_niveaux'],
            'niveaux_reussis' => $prog['niveaux_reussis'],
            'pourcentage' => $prog['total_niveaux'] > 0 ? 
                round(($prog['niveaux_reussis'] / $prog['total_niveaux']) * 100) : 0
        ];
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
    <title>Tableau de bord - QCM Platform</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="dashboard-nav">
        <div class="nav-brand">QCM Platform</div>
        <div class="nav-user">
            <span>Bienvenue, <?php echo htmlspecialchars($user['username']); ?></span>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </nav>

    <main class="dashboard-container">
        <div class="dashboard-header">
            <h1>Tableau de bord</h1>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>QCM Complétés</h3>
                <div class="stat-value"><?php echo $stats['total_qcm_completes']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Sections Complétées</h3>
                <div class="stat-value"><?php echo $stats['sections_completes']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Moyenne Générale</h3>
                <div class="stat-value"><?php echo round($stats['moyenne_generale']); ?>%</div>
            </div>
            <div class="stat-card">
                <h3>Meilleur Score</h3>
                <div class="stat-value"><?php echo round($stats['meilleur_score']); ?>%</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-section">
                <h2>Progression par Section</h2>
                <div class="progression-list">
                    <?php foreach ($progression_sections as $section): ?>
                        <div class="progression-item">
                            <div class="progression-header">
                                <h3><?php echo htmlspecialchars($section['nom']); ?></h3>
                                <span class="progression-percentage"><?php echo $section['pourcentage']; ?>%</span>
                            </div>
                            <div class="progression-bar">
                                <div class="progression-fill" style="width: <?php echo $section['pourcentage']; ?>%"></div>
                            </div>
                            <div class="progression-details">
                                <?php echo $section['niveaux_reussis']; ?> / <?php echo $section['total_niveaux']; ?> niveaux complétés
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dashboard-section">
                <h2>Derniers Résultats</h2>
                <div class="recent-results">
                    <?php if (empty($derniers_resultats)): ?>
                        <p class="no-results">Aucun QCM complété pour le moment.</p>
                    <?php else: ?>
                        <?php foreach ($derniers_resultats as $resultat): ?>
                            <div class="result-item">
                                <div class="result-header">
                                    <h3><?php echo htmlspecialchars($resultat['section_nom']); ?> - <?php echo htmlspecialchars($resultat['niveau_nom']); ?></h3>
                                    <span class="result-date"><?php echo date('d/m/Y', strtotime($resultat['date_creation'])); ?></span>
                                </div>
                                <div class="result-score <?php echo $resultat['score'] >= 70 ? 'success' : 'error'; ?>">
                                    <?php echo round($resultat['score']); ?>%
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="dashboard-actions">
            <a href="choisir_section.php" class="btn-primary">Commencer un QCM</a>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html> 
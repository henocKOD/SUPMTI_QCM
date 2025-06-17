<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si l'ID de la section est fourni
if (!isset($_GET['section_id'])) {
    header('Location: dashboard.php');
    exit();
}

$section_id = $_GET['section_id'];
$user_id = $_SESSION['user_id'];

try {
    // DEBUG: Début de la récupération des informations de section
    // echo "DEBUG: Récupération section ID: " . htmlspecialchars($section_id) . "<br>";
    $stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ?");
    $stmt->execute([$section_id]);
    $section = $stmt->fetch();

    if (!$section) {
        // DEBUG: Section introuvable
        // echo "DEBUG: Section introuvable. Redirection.<br>";
        header('Location: dashboard.php');
        exit();
    }

    // DEBUG: Début de la récupération des niveaux
    // echo "DEBUG: Récupération niveaux pour section ID: " . htmlspecialchars($section_id) . "<br>";
    $stmt_niveaux = $pdo->prepare("SELECT * FROM niveaux WHERE section_id = ? ORDER BY difficulte ASC");
    $stmt_niveaux->execute([$section_id]);
    $niveaux = $stmt_niveaux->fetchAll();

    // DEBUG: Nombre de niveaux récupérés
    // echo "DEBUG: Nombre de niveaux trouvés: " . count($niveaux) . "<br>";

    // Déterminer le statut 'unlocked' pour chaque niveau en PHP
    foreach ($niveaux as $key => $niveau) {
        // DEBUG: Traitement du niveau: " . htmlspecialchars($niveau['nom']) . " (Difficulté: " . htmlspecialchars($niveau['difficulte']) . ")<br>";
        
        if ($niveau['difficulte'] == 1) {
            // Le niveau Débutant (difficulté 1) est toujours débloqué
            $niveaux[$key]['unlocked'] = true;
            // echo "DEBUG: Niveau Débutant débloqué.<br>";
        } else {
            // Pour les niveaux supérieurs, vérifier si le niveau précédent a été réussi
            $prev_difficulty = $niveau['difficulte'] - 1;
            
            // Récupérer l'ID du niveau précédent (par difficulté et section)
            // echo "DEBUG: Recherche ID niveau précédent. Section ID: " . htmlspecialchars($section_id) . ", Difficulté précédente: " . htmlspecialchars($prev_difficulty) . "<br>";
            $stmt_prev_niveau_id = $pdo->prepare("SELECT id FROM niveaux WHERE section_id = ? AND difficulte = ?");
            $stmt_prev_niveau_id->execute([$section_id, $prev_difficulty]);
            $prev_niveau_details = $stmt_prev_niveau_id->fetch();

            if ($prev_niveau_details) {
                $prev_niveau_id = $prev_niveau_details['id'];
                // echo "DEBUG: ID niveau précédent trouvé: " . htmlspecialchars($prev_niveau_id) . "<br>";

                // Vérifier le résultat du niveau précédent
                // echo "DEBUG: Vérification résultat niveau précédent. User ID: " . htmlspecialchars($user_id) . ", Section ID: " . htmlspecialchars($section_id) . ", Niveau précédent ID: " . htmlspecialchars($prev_niveau_id) . "<br>";
                $stmt_check_prev_result = $pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM resultats 
                    WHERE user_id = ? 
                    AND section_id = ? 
                    AND niveau_id = ? 
                    AND score >= 70
                ");
                $stmt_check_prev_result->execute([$user_id, $section_id, $prev_niveau_id]);
                $prev_level_result = $stmt_check_prev_result->fetch();

                $niveaux[$key]['unlocked'] = ($prev_level_result['count'] > 0);
                // echo "DEBUG: Résultat précédent (count): " . htmlspecialchars($prev_level_result['count']) . ", Niveau débloqué: " . ($niveaux[$key]['unlocked'] ? 'Oui' : 'Non') . "<br>";

            } else {
                $niveaux[$key]['unlocked'] = false; // Pas de niveau précédent trouvé ou erreur
                // echo "DEBUG: Niveau précédent non trouvé. Niveau verrouillé.<br>";
            }
        }
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
    <title><?php echo htmlspecialchars($section['nom']); ?> - QCM Platform</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .section-main {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background: none;
        }
        .section-title-card {
            background: #fff;
            border: 2px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(44,62,80,0.06);
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            padding: 2.2rem 2.5rem 1.5rem 2.5rem;
            border-radius: 0;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .section-title-card h1 {
            font-size: 2.7rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-dark);
        }
        .section-title-card p {
            color: var(--text-light);
            margin-top: 1rem;
            font-size: 1.1rem;
        }
        .levels-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            width: 100%;
            max-width: 1000px;
        }
        .level-card {
            background: #fff;
            border: 2px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(44,62,80,0.06);
            min-width: 210px;
            max-width: 260px;
            flex: 1 1 210px;
            padding: 2rem 1.2rem 1.5rem 1.2rem;
            text-align: center;
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.2s, border 0.2s;
        }
        .level-card.locked {
            opacity: 0.6;
        }
        .level-card h3 {
            margin-bottom: 0.7rem;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .level-card .locked-message {
            color: #6c7a89;
            margin-top: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 1rem;
        }
        .level-card .locked-message i {
            font-size: 1.5rem;
            margin-bottom: 0.2rem;
        }
        .level-card .btn-primary {
            margin-top: 1.2rem;
            width: 100%;
        }
        @media (max-width: 900px) {
            .levels-grid {
                gap: 1.2rem;
            }
            .section-title-card {
                padding: 1.2rem 0.7rem 1rem 0.7rem;
            }
        }
        @media (max-width: 600px) {
            .levels-grid {
                flex-direction: column;
                align-items: center;
                gap: 0.7rem;
            }
            .level-card {
                min-width: 0;
                width: 100%;
                max-width: 95vw;
            }
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav">
        <div class="nav-brand">QCM Platform</div>
        <div class="nav-user">
            <a href="dashboard.php">Tableau de bord</a>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </nav>

    <main class="section-main">
        <div class="section-title-card">
            <h1><?php echo htmlspecialchars($section['nom']); ?></h1>
            <?php if (!empty($section['description'])): ?>
                <p><?php echo htmlspecialchars($section['description']); ?></p>
            <?php endif; ?>
        </div>

        <div class="levels-grid">
            <?php foreach ($niveaux as $niveau): ?>
                <div class="level-card<?php echo $niveau['unlocked'] ? '' : ' locked'; ?>">
                    <h3><?php echo htmlspecialchars($niveau['nom']); ?></h3>
                    <?php if ($niveau['unlocked']): ?>
                        <a href="qcm.php?section=<?php echo $section['id']; ?>&niveau=<?php echo $niveau['id']; ?>" class="btn-primary">Commencer</a>
                    <?php else: ?>
                        <div class="locked-message">
                            <i class="fas fa-lock"></i>
                            Niveau verrouillé
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html> 
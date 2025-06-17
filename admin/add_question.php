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

$error = '';
$success = '';

// Traiter le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $niveau_id = $_POST['niveau_id'] ?? '';
    $reponse1 = trim($_POST['reponse1'] ?? '');
    $reponse2 = trim($_POST['reponse2'] ?? '');
    $reponse3 = trim($_POST['reponse3'] ?? '');
    $reponse4 = trim($_POST['reponse4'] ?? '');
    $bonne_reponse = $_POST['bonne_reponse'] ?? '';
    $temps_reponse = (int)($_POST['temps_reponse'] ?? 60);

    if (empty($question) || empty($niveau_id) || empty($reponse1) || empty($reponse2) || 
        empty($reponse3) || empty($reponse4) || empty($bonne_reponse)) {
        $error = 'Veuillez remplir tous les champs';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO questions (section_id, niveau_id, question, reponse1, reponse2, reponse3, reponse4, bonne_reponse, temps_reponse)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $section_id,
                $niveau_id,
                $question,
                $reponse1,
                $reponse2,
                $reponse3,
                $reponse4,
                $bonne_reponse,
                $temps_reponse
            ]);
            
            $success = 'Question ajoutée avec succès';
            
            // Réinitialiser les champs
            $question = $reponse1 = $reponse2 = $reponse3 = $reponse4 = '';
            $niveau_id = '';
            $bonne_reponse = '';
            $temps_reponse = 60;
        } catch (PDOException $e) {
            $error = 'Erreur lors de l\'ajout de la question';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une question - QCM Admin</title>
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
            <h1>Ajouter une question</h1>
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
                    <select id="niveau" name="niveau_id" required>
                        <option value="">Sélectionner un niveau</option>
                        <?php foreach ($niveaux as $niveau): ?>
                            <option value="<?php echo $niveau['id']; ?>" <?php if (isset($niveau_id) && $niveau_id == $niveau['id']) echo 'selected'; ?>><?php echo htmlspecialchars($niveau['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="temps">Temps de réponse (secondes)</label>
                    <input type="number" id="temps" name="temps_reponse" min="10" max="300" value="<?php echo isset($temps_reponse) ? htmlspecialchars($temps_reponse) : '60'; ?>" required>
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
                    <button type="submit" class="btn-primary">Ajouter</button>
                    <a href="questions.php?section=<?php echo $section_id; ?>" class="btn-back">Retour</a>
                </div>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html> 
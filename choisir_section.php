<?php
// choisir_section.php
session_start();
require_once 'db.php'; // Inclure le fichier de connexion à la base de données

$sections = [];
try {
    $stmt = $pdo->query("SELECT id, nom, description FROM sections ORDER BY nom");
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérer l'erreur si nécessaire
    error_log("Erreur lors de la récupération des sections: " . $e->getMessage());
    // Vous pouvez définir un message d'erreur à afficher à l'utilisateur ici
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Choix du QCM</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: url('assets/bg-code-pattern.png') center/cover no-repeat;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
      text-align: center;
    }

    h1 {
      font-size: 2em;
      color: #333;
      margin-bottom: 1em;
    }

    .section-button {
      background-color: #4CAF50;
      color: white;
      padding: 15px 30px;
      margin: 10px;
      border: none;
      border-radius: 8px;
      font-size: 1.2em;
      cursor: pointer;
      transition: transform 0.2s, background-color 0.3s;
    }

    .section-button:hover {
      background-color: #45a049;
      transform: scale(1.05);
    }
  </style>
</head>
<body class="section-page">
  <div class="section-container">
    <h1>Choisissez une section de QCM</h1>

    <form action="section.php" method="get" class="sections-grid">
      <?php if (!empty($sections)): ?>
          <?php foreach ($sections as $section): ?>
              <button class="section-card" type="submit" name="section_id" value="<?php echo htmlspecialchars($section['id']); ?>">
                <h3><?php echo htmlspecialchars($section['nom']); ?></h3>
                <p><?php echo htmlspecialchars($section['description']); ?></p>
              </button>
          <?php endforeach; ?>
      <?php else: ?>
          <p>Aucune section disponible pour le moment.</p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>

<?php
session_start();
require_once 'db.php';

// Récupérer les sections
$stmt = $pdo->query("SELECT * FROM sections ORDER BY nom");
$sections = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCM Platform</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .hero {
            text-align: center;
            padding: 4rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #f5f5dc;
            opacity: 0.95;
            z-index: 1;
        }
        .hero::after {
            content: '<!DOCTYPE html>\A<html>\A  <head>\A    <title>QCM</title>\A  </head>\A  <body>\A    <h1>Welcome</h1>\A  </body>\A</html>';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
            color: rgba(0, 0, 0, 0.1);
            white-space: pre;
            padding: 2rem;
            z-index: 0;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #34495e;
        }
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        .cta-buttons a {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
        }
        .features {
            padding: 4rem 2rem;
            background-color: #f5f5dc;
            position: relative;
            overflow: hidden;
        }
        .features::after {
            content: 'function init() {\A  const app = new QCM();\A  app.start();\A}';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.5;
            color: rgba(0, 0, 0, 0.1);
            white-space: pre;
            padding: 2rem;
            z-index: 0;
        }
        .features-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            background-color: #fff;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .feature-card h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        .feature-card p {
            color: #34495e;
        }
    </style>
</head>
<body>
    <nav class="main-nav">
        <div class="nav-brand">SUPMTI_QCM Platform</div>
        <div class="nav-links">
            <a href="login.php" class="btn-login">Connexion__</a>
            <a href="register.php" class="btn-register">Inscription</a>
        </div>
    </nav>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Bienvenue sur QCM Platform</h1>
                <p>Testez vos connaissances en programmation avec nos QCM interactifs</p>
                <div class="cta-buttons">
                    <a href="register.php" class="btn-primary">Commencer</a>
                    <a href="login.php" class="btn-secondary">Se connecter</a>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="features-grid">
                <div class="feature-card">
                    <h3>QCM Interactifs</h3>
                    <p>Des questions variées pour tester vos connaissances en programmation</p>
                </div>
                <div class="feature-card">
                    <h3>Suivi de Progression</h3>
                    <p>Suivez votre évolution et identifiez vos points à améliorer</p>
                </div>
                <div class="feature-card">
                    <h3>Résultats Détaillés</h3>
                    <p>Analysez vos performances avec des statistiques précises</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> QCM Platform. Tous droits réservés.</p>
    </footer>
</body>
</html>

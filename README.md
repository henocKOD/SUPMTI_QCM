# QCM Platform

Une plateforme de quiz et QCM moderne développée en PHP avec une interface utilisateur intuitive et un système d'administration complet.

## 🚀 Fonctionnalités

### Pour les utilisateurs
- **Inscription et connexion** sécurisée
- **Sections thématiques** : PHP, JavaScript, Linux, C, Anglais
- **Niveaux de difficulté** : Débutant, Intermédiaire, Avancé
- **Système de progression** : Déblocage des niveaux selon les performances
- **QCM interactifs** avec chronomètre
- **Résultats détaillés** avec correction des réponses
- **Tableau de bord** avec statistiques personnelles
- **Historique des résultats**

### Pour les administrateurs
- **Gestion complète des questions** (ajout, modification, suppression)
- **Gestion des sections et niveaux**
- **Statistiques globales** des utilisateurs
- **Interface d'administration** intuitive
- **Système de rôles** (utilisateur/admin)

## 🛠️ Technologies utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL 5.7+
- **Frontend** : HTML5, CSS3, JavaScript
- **Serveur web** : Apache/Nginx
- **Framework CSS** : Custom CSS avec design moderne

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)
- Extension PHP PDO
- Extension PHP MySQL

## 🚀 Installation

### 1. Cloner le repository
```bash
git clone https://github.com/votre-username/qcm-platform.git
cd qcm-platform
```

### 2. Configuration de la base de données
1. Créez une base de données MySQL :
```sql
CREATE DATABASE qcm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Importez le schéma de la base de données :
```bash
mysql -u votre_utilisateur -p qcm < database.sql
```

3. Importez les données de base :
```bash
mysql -u votre_utilisateur -p qcm < questions_php.sql
mysql -u votre_utilisateur -p qcm < questions_javascript.sql
mysql -u votre_utilisateur -p qcm < questions_linux.sql
mysql -u votre_utilisateur -p qcm < questions_c.sql
mysql -u votre_utilisateur -p qcm < questions_anglais.sql
```

### 3. Configuration de la connexion
Modifiez le fichier `db.php` avec vos paramètres de connexion :
```php
<?php
$host = 'localhost';
$dbname = 'qcm';
$username = 'votre_utilisateur';
$password = 'votre_mot_de_passe';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
```

### 4. Configuration du serveur web
Assurez-vous que votre serveur web pointe vers le répertoire du projet et que les permissions sont correctement configurées.

### 5. Création d'un compte administrateur
1. Inscrivez-vous normalement via l'interface
2. Connectez-vous à votre base de données et modifiez le rôle :
```sql
UPDATE utilisateurs SET role = 'admin' WHERE username = 'votre_nom_utilisateur';
```

## 📁 Structure du projet

```
qcm-platform/
├── admin/                 # Interface d'administration
│   ├── index.php         # Dashboard admin
│   ├── questions.php     # Gestion des questions
│   ├── add_question.php  # Ajouter une question
│   ├── edit_question.php # Modifier une question
│   └── delete_question.php # Supprimer une question
├── database.sql          # Schéma de la base de données
├── questions_*.sql       # Données des questions par section
├── db.php               # Configuration de la base de données
├── index.php            # Page d'accueil
├── login.php            # Page de connexion
├── register.php         # Page d'inscription
├── dashboard.php        # Tableau de bord utilisateur
├── qcm.php             # Interface QCM
├── resultat.php        # Affichage des résultats
├── style.css           # Styles CSS
└── README.md           # Ce fichier
```

## 🎯 Utilisation

### Pour les utilisateurs
1. Accédez à la page d'accueil
2. Créez un compte ou connectez-vous
3. Choisissez une section et un niveau
4. Répondez aux questions du QCM
5. Consultez vos résultats et votre progression

### Pour les administrateurs
1. Connectez-vous avec un compte administrateur
2. Accédez au dashboard d'administration
3. Gérez les questions, sections et niveaux
4. Consultez les statistiques globales

## 🔧 Configuration avancée

### Personnalisation des thèmes
Modifiez le fichier `style.css` pour personnaliser l'apparence de la plateforme.

### Ajout de nouvelles sections
1. Ajoutez une nouvelle section dans la base de données
2. Créez les niveaux correspondants
3. Ajoutez les questions dans un fichier SQL
4. Importez les données

### Sécurité
- Changez les mots de passe par défaut
- Configurez HTTPS en production
- Régularisez les sauvegardes de la base de données
- Surveillez les logs d'erreur

## 🐛 Dépannage

### Problèmes courants

**Erreur de connexion à la base de données**
- Vérifiez les paramètres dans `db.php`
- Assurez-vous que MySQL est démarré
- Vérifiez les permissions utilisateur

**Pages blanches**
- Activez l'affichage des erreurs PHP
- Vérifiez les logs d'erreur du serveur
- Contrôlez les permissions des fichiers

**Problèmes de session**
- Vérifiez la configuration PHP des sessions
- Assurez-vous que le répertoire de session est accessible

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👥 Auteurs

- **Votre nom** - *Développement initial* - [VotreGitHub](https://github.com/votre-username)

## 🙏 Remerciements

- Merci à tous les contributeurs
- Inspiré par les meilleures pratiques de développement web
- Utilise des technologies open source

## 📞 Support

Si vous rencontrez des problèmes ou avez des questions :

1. Consultez la section [Dépannage](#-dépannage)
2. Ouvrez une [issue](https://github.com/votre-username/qcm-platform/issues)
3. Contactez-nous via [email](mailto:votre-email@example.com)

---

**Note** : Ce projet est en développement actif. Les fonctionnalités peuvent évoluer au fil du temps. 
<?php
// Configuration de la base de données
// Copiez ce fichier vers db.php et modifiez les paramètres selon votre configuration

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
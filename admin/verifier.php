<?php
session_start();

// Identifiants fixes pour l'exemple
$admin_username = "admin";
$admin_password = "admin123"; // tu peux changer bien sûr

// Récupération des données du formulaire
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Vérification
if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php"); // ou admin/index.php si tu veux
    exit();
} else {
    // Redirection vers la page de login avec un message d'erreur
    header("Location: login.php?erreur=Identifiants incorrects");
    exit();
}

<?php
$host = 'localhost';
$dbname = 'qcm_db';
$username = 'root';
$password = ''; // Mets ton mot de passe MySQL ici s’il y en a un

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

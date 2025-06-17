<?php
session_start();
require_once '../db.php';

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

// Vérifier si l'ID de la question est fourni
if (!isset($_POST['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID de question manquant']);
    exit;
}

$question_id = $_POST['id'];

try {
    // Récupérer la section_id avant la suppression pour la redirection
    $stmt = $pdo->prepare("SELECT section_id FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $question = $stmt->fetch();

    if (!$question) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Question non trouvée']);
        exit;
    }

    // Supprimer la question
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
} 
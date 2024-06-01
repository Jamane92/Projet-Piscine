<?php
session_start();
include 'includes/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour ajouter des favoris']);
    exit();
}

// Récupérer les données du formulaire
$user_id = $_SESSION['user_id'];
$property_id = $_GET['property_id'];
$active = $_GET['active'];

// Connexion à la base de données
$conn = getDbConnection();

if ($active == '1') {
    // Ajouter l'annonce aux favoris de l'utilisateur
    $stmt = $conn->prepare("INSERT INTO favorites (user_id, property_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $user_id, $property_id);
    $stmt->execute();
    echo json_encode(['success' => true, 'action' => 'added']);
} else {
    // Supprimer l'annonce des favoris de l'utilisateur
    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND property_id = ?");
    $stmt->bind_param('ii', $user_id, $property_id);
    $stmt->execute();
    echo json_encode(['success' => true,'action' => 'removed']);
}
?>

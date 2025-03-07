<?php
// src/clients/delete_client.php
require_once '../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list_clients.php");
    exit;
}

$id = $_GET['id'];

// Supprimer le client de la base
$stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
$stmt->execute([$id]);

// Redirection après suppression
header("Location: list_clients.php");
exit;
?>

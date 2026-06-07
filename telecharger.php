<?php
session_start();
require_once 'bd.php';

header('Content-Type: application/json');

$patron_id = (int) ($_POST['patron_id'] ?? 0);
if ($patron_id <= 0) {
    echo json_encode(['ok' => false]);
    exit();
}

// Ajouter la colonne si elle n'existe pas encore
try {
    $pdo->exec("ALTER TABLE patrons ADD COLUMN nb_telechargements INT DEFAULT 0");
} catch (Exception $e) { /* colonne déjà présente */ }

$stmt = $pdo->prepare("UPDATE patrons SET nb_telechargements = nb_telechargements + 1 WHERE id = ?");
$stmt->execute([$patron_id]);

$stmt = $pdo->prepare("SELECT nb_telechargements FROM patrons WHERE id = ?");
$stmt->execute([$patron_id]);
$row = $stmt->fetch();

echo json_encode(['ok' => true, 'nb' => (int)$row['nb_telechargements']]);

<?php
session_start();
require_once 'bd.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['erreur' => 'non_connecte']);
    exit();
}
$patron_id = (int) ($_POST['patron_id'] ?? 0);
if ($patron_id <= 0) {
    echo json_encode(['erreur' => 'patron_invalide']);
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT 1 FROM likes WHERE user_id = ? AND patron_id = ?");
$stmt->execute([$user_id, $patron_id]);
$deja_like = $stmt->fetch();
if ($deja_like) {
    $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND patron_id = ?");
    $stmt->execute([$user_id, $patron_id]);
    $action = 'unlike';
} else {
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, patron_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $patron_id]);
    $action = 'like';
}
$stmt = $pdo->prepare("SELECT COUNT(*) AS nb_likes FROM likes WHERE patron_id = ?");
$stmt->execute([$patron_id]);
$nb_likes = $stmt->fetch()['nb_likes'];
echo json_encode(['action' => $action, 'nb_likes' => $nb_likes]);

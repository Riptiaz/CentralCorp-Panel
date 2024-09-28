<?php
session_start();
$configFilePath = '../conn.php';
if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}
require_once '../connexion_bdd.php';
if (!isset($_SESSION['user_token']) || !isset($_SESSION['user_email'])) {
    header('Location: account/connexion');
    exit();
}
$email = $_SESSION['user_email'];
$token = $_SESSION['user_token'];

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND token = :token");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':token', $token);
$stmt->execute();
$utilisateur = $stmt->fetch();

if (!$utilisateur) {
    header('Location: ../account/connexion');
    exit();
}
$tables = ['ignored_folders', 'options', 'roles', 'users', 'whitelist'];
$exportData = [];

foreach ($tables as $table) {
    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $exportData[$table] = $rows;
}
$jsonData = json_encode($exportData, JSON_PRETTY_PRINT);

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="database_export.json"');

echo $jsonData;
?>
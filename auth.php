<?php
$configFilePath = 'conn.php';
if (!file_exists($configFilePath)) {
    header('Location: setdb');
    exit();
}
require_once 'connexion_bdd.php';
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
    header('Location: account/connexion');
    exit();
}
?>
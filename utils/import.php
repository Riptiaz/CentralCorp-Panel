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
if ($_FILES['json_file']['error'] === UPLOAD_ERR_OK) {
    $tempFileName = $_FILES['json_file']['tmp_name'];
    $jsonFile = file_get_contents($tempFileName);
    $importData = json_decode($jsonFile, true);
    foreach ($importData as $table => $rows) {
        $pdo->exec("TRUNCATE TABLE $table");

        foreach ($rows as $row) {
            $columns = implode(',', array_keys($row));
            $values = "'" . implode("','", $row) . "'";
            $pdo->exec("INSERT INTO $table ($columns) VALUES ($values)");
        }
    }
    if (file_exists($tempFileName)) {
        unlink($tempFileName);
    } else {
        echo 'Le fichier temporaire n\'existe pas.';
    }
    header('Location: ../settings');
} else {
    echo 'Error uploading file.';
}
?>

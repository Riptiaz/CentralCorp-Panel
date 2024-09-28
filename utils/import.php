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
        if ($table === 'users' || $table === 'roles') {
            continue;
        }
        $stmt = $pdo->prepare("SHOW TABLES LIKE :table");
        $stmt->bindParam(':table', $table);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $pdo->exec("TRUNCATE TABLE $table");

            foreach ($rows as $row) {
                if ($table === 'options') {
                    unset($row['changelog_version']);
                    unset($row['changelog_message']);
                    unset($row['loader_forge_version']);
                    unset($row['loader_forge_version']);
                    unset($row['alert_activation']);
                    unset($row['alert_scroll']);
                    unset($row['alert_msg']);
                    unset($row['video_activation']);
                    unset($row['video_url']);
                    unset($row['email_verified']);
                    unset($row['server_img']);
                }
                $existingColumns = [];
                $columnsStmt = $pdo->prepare("SHOW COLUMNS FROM $table");
                $columnsStmt->execute();
                $columnsData = $columnsStmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($row as $column => $value) {
                    if (in_array($column, $columnsData)) {
                        $existingColumns[$column] = $value;
                    }
                }

                if (!empty($existingColumns)) {
                    $columns = implode(',', array_keys($existingColumns));
                    $values = "'" . implode("','", $existingColumns) . "'";
                    $pdo->exec("INSERT INTO $table ($columns) VALUES ($values)");
                }
            }
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
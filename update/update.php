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

function getCurrentVersion() {
    return trim(file_get_contents('version.txt'));
}

function getLatestVersion() {
    $url = 'https://raw.githubusercontent.com/Riptiaz/CentralCorp-Panel/dev/update/version.txt';
    return trim(file_get_contents($url));
}

function isNewVersionAvailable($currentVersion, $latestVersion) {
    return version_compare($currentVersion, $latestVersion, '<');
}

function updateFiles() {
    $zipFile = 'update.zip';
    $url = 'https://github.com/Riptiaz/CentralCorp-Panel/archive/refs/heads/dev.zip';

    file_put_contents($zipFile, fopen($url, 'r'));

    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo('.');
        $zip->close();
        unlink($zipFile);
        return true;
    } else {
        return false;
    }
}

function updateDatabase($pdo) {
    $sqlFilePath = './utils/panel.sql';
    if (!file_exists($sqlFilePath)) {
        echo "Fichier panel.sql introuvable.<br>";
        return;
    }
    $sqlContent = file_get_contents($sqlFilePath);

    $matches = [];
    preg_match_all('/`(\w+)` (\w+\([\d,]+\)|\w+)/', $sqlContent, $matches);
    $newColumns = array_combine($matches[1], $matches[2]);

    $existingColumns = [];
    $result = $pdo->query("SHOW COLUMNS FROM votre_table");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $existingColumns[$row['Field']] = $row['Type'];
    }

    foreach ($newColumns as $column => $type) {
        if (!array_key_exists($column, $existingColumns)) {
            $alterQuery = "ALTER TABLE votre_table ADD COLUMN $column $type";
            if ($pdo->exec($alterQuery) !== false) {
                echo "Colonne '$column' ajoutée avec succès.<br>";
            } else {
                echo "Erreur lors de l'ajout de la colonne '$column'.<br>";
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_button'])) {
    $currentVersion = getCurrentVersion();
    $latestVersion = getLatestVersion();

    echo "Version actuelle : $currentVersion<br>";
    echo "Dernière version : $latestVersion<br>";

    if (isNewVersionAvailable($currentVersion, $latestVersion)) {
        echo "Nouvelle version disponible. Mise à jour en cours...<br>";

        if (updateFiles()) {
            echo "Fichiers mis à jour avec succès.<br>";

            updateDatabase($pdo);

            file_put_contents('version.txt', $latestVersion);
            echo "Mise à jour terminée avec succès à la version $latestVersion.<br>";
        } else {
            echo "Échec de la mise à jour des fichiers.<br>";
        }
    } else {
        echo "Votre application est déjà à jour.<br>";
    }
} else {
    echo "Requête invalide.<br>";
}
?>

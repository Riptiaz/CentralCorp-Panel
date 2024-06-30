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
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "Cache-Control: no-cache, no-store, must-revalidate\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    return trim(file_get_contents($url, false, $context));
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
        $extractPath = './temp-update';
        mkdir($extractPath);

        $zip->extractTo($extractPath);
        $zip->close();
        unlink($zipFile);

        $innerFolder = $extractPath . '/CentralCorp-Panel-dev';
        if (is_dir($innerFolder)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($innerFolder, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($files as $file) {
                $destination = str_replace($innerFolder, '..', $file);

                if ($file->isDir()) {
                    mkdir($destination);
                } else {
                    rename($file, $destination);
                }
            }

            // Suppression des fichiers extraits
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($innerFolder, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }

            rmdir($innerFolder);
        }
        rmdir($extractPath);

        return true;
    } else {
        return false;
    }
}

function updateDatabase($pdo) {
    $sqlFilePath = '../utils/panel.sql';
    if (!file_exists($sqlFilePath)) {
        echo "Fichier panel.sql introuvable.<br>";
        return;
    }
    $sqlContent = file_get_contents($sqlFilePath);

    // Diviser le contenu du fichier SQL en segments basés sur chaque table
    $tableSegments = explode('CREATE TABLE', $sqlContent);
    array_shift($tableSegments); // Supprimer la première entrée qui est avant le premier 'CREATE TABLE'

    foreach ($tableSegments as $segment) {
        // Récupérer le nom de la table
        preg_match('/`(\w+)`/', $segment, $tableMatch);
        $tableName = $tableMatch[1];
        echo "Mise à jour de la table : $tableName<br>";

        // Extraire les colonnes de la table
        $matches = [];
        preg_match_all('/`(\w+)` (.+?),/', $segment, $matches);
        $newColumns = array_combine($matches[1], $matches[2]);

        // Récupérer les colonnes existantes de la table
        $existingColumns = [];
        $result = $pdo->query("SHOW COLUMNS FROM $tableName");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $existingColumns[$row['Field']] = $row['Type'];
        }

        // Comparer et ajouter les nouvelles colonnes
        foreach ($newColumns as $column => $type) {
            if (!array_key_exists($column, $existingColumns)) {
                $alterQuery = "ALTER TABLE $tableName ADD COLUMN $column $type";
                if ($pdo->exec($alterQuery) !== false) {
                    echo "Colonne '$column' ajoutée avec succès à la table '$tableName'.<br>";
                } else {
                    echo "Erreur lors de l'ajout de la colonne '$column' à la table '$tableName'.<br>";
                }
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
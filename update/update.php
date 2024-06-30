<?php
session_start();
$configFilePath = '../conn.php';
if (!file_exists($configFilePath)) {
    echo json_encode(['success' => false, 'message' => 'Fichier de configuration introuvable.']);
    exit();
}
require_once '../connexion_bdd.php';
if (!isset($_SESSION['user_token']) || !isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'Accès refusé. Veuillez vous connecter.']);
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
        return ['success' => false, 'message' => "Fichier panel.sql introuvable."];
    }
    $sqlContent = file_get_contents($sqlFilePath);

    // Diviser le contenu du fichier SQL en segments basés sur chaque table
    $tableSegments = explode('CREATE TABLE', $sqlContent);
    array_shift($tableSegments); // Supprimer la première entrée qui est avant le premier 'CREATE TABLE'

    foreach ($tableSegments as $segment) {
        // Récupérer le nom de la table
        preg_match('/`(\w+)`/', $segment, $tableMatch);
        $tableName = $tableMatch[1];

        // Extraire les colonnes de la table
        $matches = [];
        preg_match_all('/`(\w+)` (\w+\([\d,]+\)|\w+(\(\d+\))?)/', $segment, $matches);
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
                if ($pdo->exec($alterQuery) === false) {
                    return ['success' => false, 'message' => "Erreur lors de l'ajout de la colonne '$column' à la table '$tableName'."];
                }
            }
        }
    }
    return ['success' => true, 'message' => "Base de données mise à jour avec succès."];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_button'])) {
    $currentVersion = getCurrentVersion();
    $latestVersion = getLatestVersion();

    if (isNewVersionAvailable($currentVersion, $latestVersion)) {
        if (updateFiles()) {
            $dbUpdateResult = updateDatabase($pdo);
            if ($dbUpdateResult['success']) {
                file_put_contents('version.txt', $latestVersion);
                echo json_encode(['success' => true, 'message' => "Mise à jour terminée avec succès à la version $latestVersion."]);
            } else {
                echo json_encode($dbUpdateResult);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour des fichiers.']);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'Aucune mise à jour disponible.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête non valide.']);
}
?>
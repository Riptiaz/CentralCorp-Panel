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
    $tableSegments = explode('CREATE TABLE', $sqlContent);
    array_shift($tableSegments); // Supprimer la première partie qui est vide avant le premier 'CREATE TABLE'
    $newTables = [];

    // Récupérer les tables existantes
    $existingTables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    $transactionActive = false;

    try {
        // Démarrer la transaction
        $pdo->beginTransaction();
        $transactionActive = true;

        // 1. Création des nouvelles tables
        foreach ($tableSegments as $segment) {
            $segment = 'CREATE TABLE ' . $segment; // Ajouter 'CREATE TABLE' car il a été supprimé par explode
            preg_match('/`(\w+)`/', $segment, $tableMatch);
            if (isset($tableMatch[1])) {
                $tableName = $tableMatch[1];
                $newTables[] = $tableName;

                // Vérifier si la table existe déjà
                if (!in_array($tableName, $existingTables)) {
                    echo "Création de la table : $tableName\n"; // Debug : affiche la table en cours de création
                    if ($pdo->exec($segment) === false) {
                        throw new Exception("Erreur lors de la création de la table '$tableName'.");
                    }
                }
            } else {
                echo "Impossible d'extraire le nom de la table pour le segment suivant : \n$segment\n";
            }
        }

        // 2. Ajout des nouvelles colonnes dans les tables existantes
        foreach ($tableSegments as $segment) {
            preg_match('/`(\w+)`/', $segment, $tableMatch);
            $tableName = $tableMatch[1];

            // Récupérer les colonnes existantes dans la table
            $result = $pdo->query("SHOW COLUMNS FROM `$tableName`");
            $existingColumns = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $existingColumns[$row['Field']] = $row['Type'];
            }

            // Récupérer les colonnes définies dans panel.sql
            preg_match_all('/`(\w+)` (\w+\([\d,]+\)|\w+(\(\d+\))?)/', $segment, $matches);
            $newColumns = array_combine($matches[1], $matches[2]);

            // Ajouter les nouvelles colonnes
            foreach ($newColumns as $column => $type) {
                if (!array_key_exists($column, $existingColumns)) {
                    $alterQuery = "ALTER TABLE `$tableName` ADD COLUMN `$column` $type";
                    echo "Ajout de la colonne : $column à la table $tableName\n"; // Debug : affiche la colonne en cours d'ajout
                    if ($pdo->exec($alterQuery) === false) {
                        throw new Exception("Erreur lors de l'ajout de la colonne '$column' à la table '$tableName'.");
                    }
                }
            }
        }

        // 3. Suppression des anciennes colonnes
        foreach ($newTables as $tableName) {
            // Récupérer les colonnes définies dans panel.sql pour cette table
            $segment = array_values(array_filter($tableSegments, function ($segment) use ($tableName) {
                return strpos($segment, "`$tableName`") !== false;
            }))[0];

            preg_match_all('/`(\w+)` (\w+\([\d,]+\)|\w+(\(\d+\))?)/', $segment, $matches);
            $newColumns = array_combine($matches[1], $matches[2]);

            // Récupérer les colonnes existantes dans la base de données
            $existingColumns = $pdo->query("SHOW COLUMNS FROM `$tableName`")->fetchAll(PDO::FETCH_COLUMN);

            foreach ($existingColumns as $existingColumn) {
                // Supprimer uniquement les colonnes qui ne sont pas dans la nouvelle définition
                if (!array_key_exists($existingColumn, $newColumns)) {
                    if ($existingColumn != 'id') { // Ne pas supprimer la colonne 'id'
                        echo "Suppression de la colonne : $existingColumn de la table $tableName\n"; // Debug : affiche la colonne en cours de suppression
                        if ($pdo->exec("ALTER TABLE `$tableName` DROP COLUMN `$existingColumn`") === false) {
                            throw new Exception("Erreur lors de la suppression de la colonne '$existingColumn' dans la table '$tableName'.");
                        }
                    }
                }
            }
        }

        // Commit seulement après que tout se soit bien passé
        $pdo->commit();
        return ['success' => true, 'message' => "Base de données mise à jour avec succès."];

    } catch (Exception $e) {
        // Rollback seulement si la transaction a été démarrée
        if ($transactionActive) {
            $pdo->rollBack();
        }
        return ['success' => false, 'message' => $e->getMessage()];
    }
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
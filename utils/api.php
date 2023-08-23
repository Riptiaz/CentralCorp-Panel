<?php
$configFilePath = '../config.php';

if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}
// Connexion à la base de données et autres configurations...
require_once '../connexion_bdd.php';
// Récupérer les paramètres de la base de données
$sql = "SELECT * FROM options";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$options = $stmt->fetch(PDO::FETCH_ASSOC);

// Formater les paramètres en tant que tableau associatif
$data = [
    "maintenance" => (bool) $options["maintenance"],
    "maintenance_message" => $options["maintenance_message"],
    "game_version" => $options["minecraft_version"],
    "client_id" => "",
    "verify" => (bool) $options["file_verification"],
    "modde" => (bool) $options["mods_enabled"],
    "java" => (bool) $options["embedded_java"],
    "dataDirectory" => $options["game_folder_name"],
    "status" => [
        "nameServer" => $options["server_name"],
        "ip" => $options["server_ip"],
        "port" => (int) $options["server_port"]
    ],
    "loader" => [
        "type" => $options["loader_type"],
        "build" => $options["loader_build_version"],
        "enable" => (bool) $options["loader_activation"]
    ],
    "changelog_version" => $options["changelog_version"],
    "changelog_new" => $options["changelog_message"],
    "online" => "true",
    "server_img" => "https://conflictura.site/storage/img/logo2.png",
    "ignored" => ["crash-reports", "logs", "resourcepacks", "resources", "saves", "shaderpacks", "options.txt", "optionsof.txt"],
    "game_args" => [],
    "money" => (bool) $options["money"],
    "role" => (bool) $options["role"],
    
];

// Envoyer la réponse JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>

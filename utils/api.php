<?php
session_start();
$configFilePath = '../conn.php';

if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}

require_once '../connexion_bdd.php';

$domain = $_SERVER['HTTP_HOST'];
$baseURL = 'https://' . $domain;

$sql = "SELECT * FROM options";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$options = $stmt->fetch(PDO::FETCH_ASSOC);

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
        "build" => ($options["loader_type"] === 'forge') ? $options["loader_forge_version"] : $options["loader_build_version"],
        "enable" => (bool) $options["loader_activation"]
    ],
    "changelog_version" => $options["changelog_version"],
    "changelog_new" => $options["changelog_message"],
    "online" => "true",
    "game_args" => [],
    "money" => (bool) $options["money"],
    "role" => (bool) $options["role"],
    "splash" => $options["splash"],
    "splash_author" => $options["splash_author"],
    "azauth" => $options["azuriom"],
    "rpc_activation" => (bool) $options["rpc_activation"],
    "rpc_id" => $options["rpc_id"],
    "rpc_details" => $options["rpc_details"],
    "rpc_state" => $options["rpc_state"],
    "rpc_large_text" => $options["rpc_large_text"],
    "rpc_small_text" => $options["rpc_small_text"],
    "rpc_button1" => $options["rpc_button1"],
    "rpc_button1_url" => $options["rpc_button1_url"],
    "rpc_button2" => $options["rpc_button2"],
    "rpc_button2_url" => $options["rpc_button2_url"],
    "whitelist_activate" => (bool) $options["whitelist_activation"],      
];

if (!empty($options["server_img"])) {
    $data["server_img"] = cleanImageUrl($options["server_img"], $baseURL);
} else {
    $data["server_img"] = "";
}

$sqlRoles = "SELECT * FROM roles";
$stmtRoles = $pdo->query($sqlRoles);

$rolesData = [];

while ($rowRole = $stmtRoles->fetch(PDO::FETCH_ASSOC)) {
    $roleId = $rowRole['id'];
    $roleName = $rowRole['role_name'];
    $roleBackground = (!empty($rowRole['role_background'])) ? cleanImageUrl($rowRole['role_background'], $baseURL) : "";
    $rolesData["role" . $roleId] = [
        "name" => $roleName,
        "background" => $roleBackground
    ];
}

$data["role_data"] = $rolesData;

$sqlIgnored = "SELECT folder_name FROM ignored_folders";
$stmtIgnored = $pdo->query($sqlIgnored);

$ignoredFolders = [];

while ($rowIgnored = $stmtIgnored->fetch(PDO::FETCH_ASSOC)) {
    $ignoredFolders[] = $rowIgnored['folder_name'];
}

$data["ignored"] = $ignoredFolders;

$sqlWhitelist = "SELECT users FROM whitelist";
$stmtWhitelist = $pdo->query($sqlWhitelist);

$whitelistUsers = [];

while ($rowWhitelist = $stmtWhitelist->fetch(PDO::FETCH_ASSOC)) {
    $whitelistUsers[] = $rowWhitelist['users'];
}

$data["whitelist"] = $whitelistUsers;

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>

<?php
function cleanImageUrl($imagePath, $baseURL) {
    $cleanPath = ltrim($imagePath, './');
    return $baseURL . '/' . $cleanPath;
}
?>
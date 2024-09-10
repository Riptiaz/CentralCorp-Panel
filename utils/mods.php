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

$sql = "SELECT * FROM mods";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$modsData = [];

while ($mods = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $modsId = $mods['id'];
    $modsName = $mods['name'];
    $modsDescription = $mods['description'];
    $modsFile = $mods['file'];
    $modsIcon = (!empty($mods['icon'])) ? cleanImageUrl($mods['icon'], $baseURL) : "";
    $modsData["mods" . $modsId] = [
        "file" => $modsFile,
        "name" => $modsName,
        "description" => $modsDescription,
        "icon" => $modsIcon
    ];
}

header('Content-Type: application/json');
echo json_encode($modsData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>

<?php
function cleanImageUrl($imagePath, $baseURL) {
    $cleanPath = ltrim($imagePath, './');
    return $baseURL . '/' . $cleanPath;
}
?>
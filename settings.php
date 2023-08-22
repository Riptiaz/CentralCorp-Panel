<?php
session_start();
$configFilePath = 'config.php';

if (!file_exists($configFilePath)) {
    header('Location: setdb');
    exit();
}
// Traitement du bouton déconnexion
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: account/connexion');
    exit();
}

require_once 'connexion_bdd.php';

// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: account/connexion');
    exit();
}
// Traiter les soumissions de formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit_maintenance"])) {
        $maintenance = isset($_POST["maintenance"]) ? 1 : 0;
        $sql = "UPDATE options SET maintenance = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$maintenance]);
    } elseif (isset($_POST["submit_maintenance_message"])) {
        $maintenance_message = $_POST["maintenance_message"];
        $sql = "UPDATE options SET maintenance_message = :maintenance_message"; // Utilisation d'un named placeholder
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':maintenance_message', $maintenance_message, PDO::PARAM_STR); // Liaison de la valeur
        $stmt->execute();
    } elseif (isset($_POST["submit_mods"])) {
        $mods = isset($_POST["mods_enabled"]) ? 1 : 0;
        $sql = "UPDATE options SET mods_enabled = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$mods]);    
    } elseif (isset($_POST["submit_file_verification"])) {
        $file_verification = isset($_POST["file_verification"]) ? 1 : 0;
        $sql = "UPDATE options SET file_verification = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$file_verification]);
    } elseif (isset($_POST["submit_embedded_java"])) {
        $embedded_java = isset($_POST["embedded_java"]) ? 1 : 0;
        $sql = "UPDATE options SET embedded_java = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$embedded_java]);
    } elseif (isset($_POST["submit_minecraft_version"])) {
        $game_folder_name = $_POST["minecraft_version"];
        $sql = "UPDATE options SET minecraft_version = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$game_folder_name]);
    } elseif (isset($_POST["submit_game_folder_name"])) {
        $game_folder_name = $_POST["game_folder_name"];
        $sql = "UPDATE options SET game_folder_name = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$game_folder_name]);
    } elseif (isset($_POST["submit_server_info"])) {
            $server_name = $_POST["server_name"];
            $server_ip = $_POST["server_ip"];
            $server_port = $_POST["server_port"];
            
            $sql = "UPDATE options SET server_name = ?, server_ip = ?, server_port = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$server_name, $server_ip, $server_port]);
        
    } elseif (isset($_POST["submit_loader_settings"])) {
            $loader_type = $_POST["loader_type"];
            $loader_build_version = $_POST["loader_build_version"];
            $loader_activation = isset($_POST["loader_activation"]) ? 1 : 0;
            
            $sql = "UPDATE options SET loader_type = ?, loader_build_version = ?, loader_activation = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$loader_type, $loader_build_version, $loader_activation]);
        
    } elseif (isset($_POST["submit_changelog_version"])) {
        $changelog_version = $_POST["changelog_version"];
        $sql = "UPDATE options SET changelog_version = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$changelog_version]);
    } elseif (isset($_POST["submit_changelog_message"])) {
        $changelog_message = str_replace("\n", '<br>', $_POST["changelog_message"]);
        $sql = "UPDATE options SET changelog_message = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$changelog_message]);
    } elseif (isset($_POST["submit_role"])) {
        $role = isset($_POST["role"]) ? 1 : 0;
        $sql = "UPDATE options SET role = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$role]);
    } elseif (isset($_POST["submit_money"])) {
        $money = isset($_POST["money"]) ? 1 : 0;
        $sql = "UPDATE options SET money = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$money]);
    }
    


}
// Charger les options depuis la base de données
$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Paramètres du launcher</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Paramètres du launcher</h1>
    
    <form method="post">
        <input type="hidden" name="logout" value="1"> <!-- Champ caché pour indiquer la déconnexion -->
        <input type="submit" value="Déconnexion">
    </form>

</div>
</body>
<form method="post" action="settings">
    <label>Maintenance :</label>
    <input type="checkbox" name="maintenance" <?php if ($row["maintenance"] == 1) echo "checked"; ?>>
    <input type="submit" name="submit_maintenance" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Message de Maintenance :</label>
    <input type="text" name="maintenance_message" value="<?php echo $row["maintenance_message"]; ?>">
    <input type="submit" name="submit_maintenance_message" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Version de Minecraft :</label>
    <input type="text" name="minecraft_version" value="<?php echo $row["minecraft_version"]; ?>">
    <input type="submit" name="submit_minecraft_version" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Mods :</label>
    <input type="checkbox" name="mods_enabled" <?php if ($row["mods_enabled"] == 1) echo "checked"; ?>>
    <input type="submit" name="submit_mods" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Vérification des Fichiers :</label>
    <input type="checkbox" name="file_verification" <?php if ($row["file_verification"] == 1) echo "checked"; ?>>
    <input type="submit" name="submit_file_verification" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Version Préembarquée de Java :</label>
    <input type="checkbox" name="embedded_java" <?php if ($row["embedded_java"] == 1) echo "checked"; ?>>
    <input type="submit" name="submit_embedded_java" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Affichage du rôle :</label>
    <input type="checkbox" name="role" <?php if ($row["role"] == 1) echo "checked"; ?>>
    <input type="submit" name="submit_role" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Affichage des points :</label>
    <input type="checkbox" name="money" <?php if ($row["money"] == 1) echo "checked"; ?>>
    <input type="submit" name="submit_money" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Nom du Dossier du Répertoire du Jeu :</label>
    <input type="text" name="game_folder_name" value="<?php echo $row["game_folder_name"]; ?>">
    <input type="submit" name="submit_game_folder_name" value="Enregistrer">
</form>

<form method="post" action="settings">
    <label>Nom du Serveur :</label>
    <input type="text" name="server_name" value="<?php echo $row["server_name"]; ?>"><br>
    
    <label>IP du Serveur :</label>
    <input type="text" name="server_ip" value="<?php echo $row["server_ip"]; ?>"><br>
    
    <label>Port du Serveur :</label>
    <input type="text" name="server_port" value="<?php echo $row["server_port"]; ?>">
    
    <input type="submit" name="submit_server_info" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Type de Loader :</label>
    <select name="loader_type">
        <option value="forge" <?php if ($row["loader_type"] == "forge") echo "selected"; ?>>Forge</option>
        <option value="fabric" <?php if ($row["loader_type"] == "fabric") echo "selected"; ?>>Fabric</option>
        <option value="legacyfabric" <?php if ($row["loader_type"] == "legacyfabric") echo "selected"; ?>>LegacyFabric</option>
        <option value="neoForge" <?php if ($row["loader_type"] == "neoForge") echo "selected"; ?>>NeoForge</option>
        <option value="quilt" <?php if ($row["loader_type"] == "quilt") echo "selected"; ?>>Quilt</option>
    </select><br>
    
    <label>Version de Build :</label>
    <input type="text" name="loader_build_version" value="<?php echo $row["loader_build_version"]; ?>"><br>
    
    <label>Activation :</label>
    <input type="checkbox" name="loader_activation" <?php if ($row["loader_activation"] == 1) echo "checked"; ?>>  
    
    <input type="submit" name="submit_loader_settings" value="Enregistrer">
</form>

<form method="post" action="settings">
    <label>Numéro de Mise à Jour du Changelog :</label>
    <input type="text" name="changelog_version" value="<?php echo $row["changelog_version"]; ?>">
    <input type="submit" name="submit_changelog_version" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Message du Changelog :</label><br>
    <textarea name="changelog_message" rows="4" cols="50"><?php echo str_replace('<br>', "\n", $row["changelog_message"]); ?></textarea>
    <input type="submit" name="submit_changelog_message" value="Enregistrer">
</form>
<div class="footer">Créé avec ❤️ par Riptiaz</div>
</body>
</html>

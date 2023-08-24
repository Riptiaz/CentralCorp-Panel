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
    if (isset($_POST["submit_toggle_dark_mode"])) {
        if (isset($_SESSION["dark_mode"])) {
            unset($_SESSION["dark_mode"]);
        } else {
            $_SESSION["dark_mode"] = true;
        }
        header("Location: settings");
        exit();
    } elseif (isset($_POST["submit_maintenance"])) {
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
    } elseif (isset($_POST["submit_azuriom"])) {
        $azuriom = $_POST["azuriom"];
        $sql = "UPDATE options SET azuriom = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$azuriom]);
    }elseif (isset($_POST["submit_ftp_url"])) {
        $ftp_url = $_POST["ftp_url"];
        $sql = "UPDATE options SET ftp_url = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ftp_url]);
    }elseif (isset($_POST["submit_mods"])) {
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
        
    }elseif (isset($_POST["submit_rpc_settings"])) {
        $rpc_id = $_POST["rpc_id"];
        $rpc_details = $_POST["rpc_details"];
        $rpc_state = $_POST["rpc_state"];
        $rpc_large_text = $_POST["rpc_large_text"];
        $rpc_small_text = $_POST["rpc_small_text"];
        $rpc_activation = isset($_POST["rpc_activation"]) ? 1 : 0;
        $rpc_button1 = $_POST["rpc_button1"];
        $rpc_button1_url = $_POST["rpc_button1_url"];
        $rpc_button2 = $_POST["rpc_button2"];
        $rpc_button2_url = $_POST["rpc_button2_url"];
        
        $sql = "UPDATE options SET rpc_id = ?, rpc_details = ?, rpc_state = ?, rpc_large_text = ?, rpc_small_text = ?, rpc_activation = ?, rpc_button1 = ?, rpc_button1_url = ?, rpc_button2 = ?, rpc_button2_url = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rpc_id, $rpc_details, $rpc_state, $rpc_large_text, $rpc_small_text, $rpc_activation, $rpc_button1, $rpc_button1_url, $rpc_button2, $rpc_button2_url]);
    
    }elseif (isset($_POST["submit_changelog_version"])) {
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
    } elseif (isset($_POST["submit_server_img"])) {
        $server_img = $_POST["server_img"];
        $sql = "UPDATE options SET server_img = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$server_img]);
    } elseif (isset($_POST["submit_splash_info"])) {
        $splash = $_POST["splash"];
        $splash_author = $_POST["splash_author"];
        
        $sql = "UPDATE options SET splash = ?, splash_author = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$splash, $splash_author]);
    
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
<?php
if (isset($_SESSION["dark_mode"])) {
    echo '<link rel="stylesheet" href="css/style-dark.css">';
}
?>
</head>
<body>
  <div class="container">
    <h1>Paramètres du launcher</h1>
    <div class="top-bar">
    <form method="post">
        <input type="hidden" name="logout" value="1"> <!-- Champ caché pour indiquer la déconnexion -->
        <input type="submit" value="Déconnexion">
    </form>
    <form method="post">
          <label>
            <input type="checkbox" name="toggle_dark_mode" <?php if (isset($_SESSION["dark_mode"])) echo "checked"; ?>>
            <span>Mode sombre</span>
          </label>
          <span> <!-- Espace pour le style du texte -->
          </span>
          <input type="submit" name="submit_toggle_dark_mode" value="Enregistrer">
</div>
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
    <label>URL du site Azuriom:</label>
    <input type="text" name="azuriom" value="<?php echo $row["azuriom"]; ?>">
    <input type="submit" name="submit_azuriom" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>URL du FTP:</label>
    <input type="text" name="ftp_url" value="<?php echo $row["ftp_url"]; ?>">
    <input type="submit" name="submit_ftp_url" value="Enregistrer">
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
    <label>Image du statut de serveur:</label>
    <input type="text" name="server_img" value="<?php echo $row["server_img"]; ?>">
    <input type="submit" name="submit_server_img" value="Enregistrer">
</form>
<form method="post" action="settings">
    <label>Message splash:</label>
    <input type="text" name="splash" value="<?php echo $row["splash"]; ?>"><br>
    
    <label>Auteur du splash:</label>
    <input type="text" name="splash_author" value="<?php echo $row["splash_author"]; ?>"><br>

    <input type="submit" name="submit_splash_info" value="Enregistrer">
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
    <label>ID Client pour le RPC</label>
    <input type="text" name="rpc_id" value="<?php echo $row["rpc_id"]; ?>"><br>

    <label>Message de détails</label>
    <input type="text" name="rpc_details" value="<?php echo $row["rpc_details"]; ?>"><br>

    <label>Message de l'état</label>
    <input type="text" name="rpc_state" value="<?php echo $row["rpc_state"]; ?>"><br>

    <label>Message pour la grande image</label>
    <input type="text" name="rpc_large_text" value="<?php echo $row["rpc_large_text"]; ?>"><br>

    <label>Message pour la petite image</label>
    <input type="text" name="rpc_small_text" value="<?php echo $row["rpc_small_text"]; ?>"><br>

    <label>Nom du 1er bouton</label>
    <input type="text" name="rpc_button1" value="<?php echo $row["rpc_button1"]; ?>"><br>

    <label>URL du 1er bouton</label>
    <input type="text" name="rpc_button1_url" value="<?php echo $row["rpc_button1_url"]; ?>"><br>

    <label>Nom du 2ème bouton</label>
    <input type="text" name="rpc_button2" value="<?php echo $row["rpc_button2"]; ?>"><br>

    <label>URL du 2ème bouton</label>
    <input type="text" name="rpc_button2_url" value="<?php echo $row["rpc_button2_url"]; ?>"><br>
    
    <label>Activation du RPC :</label>
    <input type="checkbox" name="rpc_activation" <?php if ($row["rpc_activation"] == 1) echo "checked"; ?>>  
    
    <input type="submit" name="submit_rpc_settings" value="Enregistrer">
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

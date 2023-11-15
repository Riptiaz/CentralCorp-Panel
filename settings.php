<?php
session_start();
$configFilePath = 'config.php';
require_once 'connexion_bdd.php';
if (!file_exists($configFilePath)) {
    header('Location: setdb');
    exit();
}
require('auth.php');
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: account/connexion');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit_roles_settings"])) {
        $roles = array();
    
        for ($i = 1; $i <= 8; $i++) {
            $roleName = $_POST["role" . $i . "_name"];
            $backgroundUrl = $_POST["role" . $i . "_background"];
    
            if (!empty($roleName)) {

                $sql = "INSERT INTO roles (id, role_name, role_background) VALUES (:id, :role_name, :role_background)
                        ON DUPLICATE KEY UPDATE role_name = :role_name, role_background = :role_background";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $i);
                $stmt->bindParam(':role_name', $roleName);
                $stmt->bindParam(':role_background', $backgroundUrl);
                $stmt->execute();
            }
        }
    }elseif (isset($_POST["submit_maintenance"])) {
        $maintenance = isset($_POST["maintenance"]) ? 1 : 0;
        $sql = "UPDATE options SET maintenance = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$maintenance]);
        $maintenance_message = $_POST["maintenance_message"];
        $sql = "UPDATE options SET maintenance_message = :maintenance_message";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':maintenance_message', $maintenance_message, PDO::PARAM_STR);
        $stmt->execute();
    } elseif (isset($_POST["submit_server_info"])) {
            $server_img = $_POST["server_img"];
            $sql = "UPDATE options SET server_img = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$server_img]);
            
            $server_name = $_POST["server_name"];
            $server_ip = $_POST["server_ip"];
            $server_port = $_POST["server_port"];
            
            $sql = "UPDATE options SET server_name = ?, server_ip = ?, server_port = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$server_name, $server_ip, $server_port]);
        
    } elseif (isset($_POST["submit_loader_settings"])) {
        
            $game_folder_name = $_POST["minecraft_version"];
            $sql = "UPDATE options SET minecraft_version = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$game_folder_name]);
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
    
    }elseif (isset($_POST["submit_changelog"])) {
        $changelog_version = $_POST["changelog_version"];
        $changelog_message = str_replace("\n", '<br>', $_POST["changelog_message"]);

        $sql = "UPDATE options SET changelog_version = ?, changelog_message = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$changelog_version, $changelog_message]);
    } elseif (isset($_POST["submit_splash_info"])) {
        $splash = $_POST["splash"];
        $splash_author = $_POST["splash_author"];
        
        $sql = "UPDATE options SET splash = ?, splash_author = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$splash, $splash_author]);
    
    }elseif (isset($_POST["submit_ignored_folder_data"])) {
        $ignored_folder = $_POST["ignored_folder"];
        
        $folderArray = explode(',', $ignored_folder);
        
        $folderArray = array_map('trim', $folderArray);
        
        $ignored_folder = implode(',', $folderArray);
        
        $sqlDelete = "DELETE FROM ignored_folders";
        $pdo->exec($sqlDelete);
        
        $sqlInsert = "INSERT INTO ignored_folders (folder_name) VALUES (:folder_name)";
        $stmt = $pdo->prepare($sqlInsert);
        
        foreach ($folderArray as $folder) {
            $stmt->bindParam(':folder_name', $folder);
            $stmt->execute();
        }
    }elseif (isset($_POST["submit_whitelist"])) {
        $whitelist = isset($_POST["whitelist_activation"]) ? 1 : 0;
        $sql = "UPDATE options SET whitelist_activation = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$whitelist]);

        $whitelistUsers = $_POST["whitelist_users"];
        $usernamesArray = explode(',', $whitelistUsers);
        $usernamesArray = array_map('trim', $usernamesArray);

        $sqlDelete = "DELETE FROM whitelist";
        $pdo->exec($sqlDelete);

        $sqlInsert = "INSERT INTO whitelist (users) VALUES (:users)";
        $stmt = $pdo->prepare($sqlInsert);

        foreach ($usernamesArray as $username) {
            $stmt->bindParam(':users', $username);
            $stmt->execute();
        }
    }elseif (isset($_POST["submit_general_settings"])) {
        
            $role = isset($_POST["role"]) ? 1 : 0;
            $sql = "UPDATE options SET role = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$role]);
      
            $money = isset($_POST["money"]) ? 1 : 0;
            $sql = "UPDATE options SET money = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$money]);
          
            $game_folder_name = $_POST["game_folder_name"];
            $sql = "UPDATE options SET game_folder_name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$game_folder_name]);
           
            $azuriom = $_POST["azuriom"];
            $sql = "UPDATE options SET azuriom = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$azuriom]);
          
            $mods = isset($_POST["mods_enabled"]) ? 1 : 0;
            $sql = "UPDATE options SET mods_enabled = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$mods]);    
          
            $file_verification = isset($_POST["file_verification"]) ? 1 : 0;
            $sql = "UPDATE options SET file_verification = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$file_verification]);
            
            $embedded_java = isset($_POST["embedded_java"]) ? 1 : 0;
            $sql = "UPDATE options SET embedded_java = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$embedded_java]);
            
}
}
$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand ml-2">Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" >
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Général</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#server-info-settings">Serveur</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#loader-settings">Loader</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#rpc-settings">Discord RPC</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#splash-settings">Splash</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#changelog-settings">Changelog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#maintenance-settings">Maintenance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#whitelist-settings">Whitelist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#ignored-folders-settings">Dossiers Ignorés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#roles-settings">Fond d'écran par rôle</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0 ml-auto" method="post" action="">
            <button class="btn btn-outline-light" type="submit" name="logout">Déconnexion</button>
            <a class="btn btn-outline-light" name="export" href="./utils/export">Exporter</a>
        </form>
        <form id="importForm" class="form-inline my-2 my-lg-0 ml-auto" method="post" action="utils/import.php" enctype="multipart/form-data">
    <label class="btn btn-outline-light">
        Importer
        <input type="file" id="jsonFileInput" name="json_file" style="display:none;" accept=".json" required>
    </label>
</form>

<script>
    document.getElementById('jsonFileInput').addEventListener('change', function() {
        document.getElementById('importForm').submit();
    });
</script>
        </div>
    </nav>
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="settings#general-settings">
                <div id="general-settings">
                    <h2>Général</h2>
                    <div class="form-group">
                        <label for="azuriom">URL du site Azuriom :</label>
                        <input type="text" class="form-control" id="azuriom" name="azuriom" value="<?php echo $row["azuriom"]; ?>">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Mods :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="mods_enabled" <?php if ($row["mods_enabled"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Vérification des Fichiers :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="file_verification" <?php if ($row["file_verification"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Version Préembarquée de Java :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="embedded_java" <?php if ($row["embedded_java"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Affichage du rôle :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="role" <?php if ($row["role"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Affichage des points :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="money" <?php if ($row["money"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="game_folder_name">Nom du Dossier du Répertoire du Jeu :</label>
                    <input type="text" class="form-control" id="game_folder_name" name="game_folder_name" value="<?php echo $row["game_folder_name"]; ?>">
                </div>

                <input type="submit" class="btn btn-primary mt-3" name="submit_general_settings" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="settings#server-info-settings">
                <div id="server-info-settings">
                    <h2>Paramètres du Serveur</h2>
                    <div class="form-group">
                        <label for="server_name">Nom du Serveur :</label>
                        <input type="text" class="form-control" id="server_name" name="server_name" value="<?php echo $row["server_name"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="server_ip">IP du Serveur :</label>
                        <input type="text" class="form-control" id="server_ip" name="server_ip" value="<?php echo $row["server_ip"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="server_port">Port du Serveur :</label>
                        <input type="text" class="form-control" id="server_port" name="server_port" value="<?php echo $row["server_port"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="server_img">Image du statut de serveur:</label>
                        <input type="text" class="form-control" id="server_img" name="server_img" value="<?php echo $row["server_img"]; ?>">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-3" name="submit_server_info" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="settings#splash-settings">
                <div id="splash-settings">
                    <h2>Paramètres du Splash</h2>
                    <div class="form-group">
                        <label for="splash">Message Splash :</label>
                        <input type="text" class="form-control" id="splash" name="splash" value="<?php echo $row["splash"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="splash_author">Auteur du Splash :</label>
                        <input type="text" class="form-control" id="splash_author" name="splash_author" value="<?php echo $row["splash_author"]; ?>">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-3" name="submit_splash_info" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div id="loader-settings">
                    <h2>Paramètres du Loader et de Minecraft</h2>
                    <form method="post" action="settings#loader-settings">
                        <div class="form-group">
                            <label for="minecraft_version">Version de Minecraft :</label>
                            <input type="text" class="form-control" name="minecraft_version" value="<?php echo $row["minecraft_version"]; ?>">
                        <div class="form-group">
                            <label for="loader-type">Type de Loader :</label>
                            <select class="form-control" id="loader-type" name="loader_type">
                                <option value="forge" <?php if ($row["loader_type"] == "forge") echo "selected"; ?>>Forge</option>
                                <option value="fabric" <?php if ($row["loader_type"] == "fabric") echo "selected"; ?>>Fabric</option>
                                <option value="legacyfabric" <?php if ($row["loader_type"] == "legacyfabric") echo "selected"; ?>>LegacyFabric</option>
                                <option value="neoForge" <?php if ($row["loader_type"] == "neoForge") echo "selected"; ?>>NeoForge</option>
                                <option value="quilt" <?php if ($row["loader_type"] == "quilt") echo "selected"; ?>>Quilt</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="loader-build-version">Version de Build du loader :</label>
                            <input type="text" class="form-control" id="loader-build-version" name="loader_build_version" value="<?php echo $row["loader_build_version"]; ?>">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="loader-activation" name="loader_activation" <?php if ($row["loader_activation"] == 1) echo "checked"; ?>>
                            <label class="form-check-label" for="loader-activation">Activer</label>
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" name="submit_loader_settings" value="Enregistrer">
                    </form>
                </div>

<div id="rpc-settings" class="mt-5">
    <h2>Paramètres du RPC</h2>
    <form method="post" action="settings#rpc-settings">
        <?php
        $rpcFields = array(
            "rpc_id" => "ID Client pour le RPC",
            "rpc_details" => "Message de détails",
            "rpc_state" => "Message de l'état",
            "rpc_large_text" => "Message pour la grande image",
            "rpc_small_text" => "Message pour la petite image",
            "rpc_button1" => "Nom du 1er bouton",
            "rpc_button1_url" => "URL du 1er bouton",
            "rpc_button2" => "Nom du 2ème bouton",
            "rpc_button2_url" => "URL du 2ème bouton",
        );

        foreach ($rpcFields as $fieldName => $fieldLabel) {
            ?>
            <div class="form-group">
                <label for="<?php echo $fieldName; ?>"><?php echo $fieldLabel; ?>:</label>
                <input type="text" class="form-control" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" value="<?php echo $row[$fieldName]; ?>">
            </div>
            <?php
        }
        ?>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="rpc-activation" name="rpc_activation" <?php if ($row["rpc_activation"] == 1) echo "checked"; ?>>
            <label class="form-check-label" for="rpc-activation">Activer</label>
        </div>
        <input type="submit" class="btn btn-primary mt-3" name="submit_rpc_settings" value="Enregistrer">
    </form>
</div>

                <div id="changelog-settings" class="mt-5">
    <h2>Paramètres du Changelog</h2>
    <form method="post" action="settings#changelog-settings">
        <div class="form-group">
            <label for="changelog-version">Numéro de Mise à Jour du Changelog :</label>
            <input type="text" class="form-control" id="changelog-version" name="changelog_version" value="<?php echo $row["changelog_version"]; ?>">
        </div>
        <div class="form-group">
            <label for="changelog-message">Message du Changelog :</label>
            <textarea class="form-control" id="changelog-message" name="changelog_message" rows="4" cols="50"><?php echo str_replace('<br>', "\n", $row["changelog_message"]); ?></textarea>
        </div>
        <input type="submit" class="btn btn-primary mt-3" name="submit_changelog" value="Enregistrer">
    </form>
</div>

<div id="maintenance-settings" class="mt-5">
    <h2>Paramètres de Maintenance</h2>
            <form method="post" action="settings#maintenance-settings">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="maintenance" name="maintenance" <?php if ($row["maintenance"] == 1) echo "checked"; ?>>
                        <label class="form-check-label" for="maintenance">Maintenance</label>
                    </div>
                    <div class="form-group">
                        <label for="maintenance_message">Message de Maintenance :</label>
                        <input type="text" class="form-control" id="maintenance_message" name="maintenance_message" value="<?php echo $row["maintenance_message"]; ?>">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-3 mt-3" name="submit_maintenance" value="Enregistrer">
            </form>
        </div>
    </div>

                <div id="whitelist-settings" class="mt-5">
    <h2>Paramètres de la Whitelist</h2>
    <form method="post" action="settings#whitelist-settings">
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="whitelist-activation" name="whitelist_activation" <?php if ($row["whitelist_activation"] == 1) echo "checked"; ?>>
            <label class="form-check-label" for="whitelist-activation">Activer</label>
        </div>
        <div class="form-group">
            <label for="whitelist-users">Noms d'utilisateurs (séparés par des virgules) :</label>
            <input type="text" class="form-control" id="whitelist-users" name="whitelist_users" value="<?php
                $sql = "SELECT users FROM whitelist"; 
                $stmt = $pdo->query($sql);

                $userNames = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $userNames[] = $row["users"];
                }
                echo implode(', ', $userNames);
            ?>">
        </div>
        <input type="submit" class="btn btn-primary mt-3 mt-3" name="submit_whitelist" value="Enregistrer">
    </form>
</div>



                <div id="ignored-folders-settings" class="mt-5">
                    <h2>Paramètres des Dossiers Ignorés</h2>
                    <form method="post" action="settings#ignored-folders-settings">
                        <div class="form-group">
                            <label for="ignored-folder">Dossiers ignorés (séparés par des virgules) :</label>
                            <input type="text" class="form-control" id="ignored-folder" name="ignored_folder" value="<?php
                                $sql = "SELECT folder_name FROM ignored_folders"; 
                                $stmt = $pdo->query($sql);
                                $folders = array();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $folders[] = $row["folder_name"];
                                }
                                echo implode(', ', $folders);
                            ?>">
                        </div>
                        <input type="submit" class="btn btn-primary mt-3 mt-3" name="submit_ignored_folder_data" value="Enregistrer">
                    </form>
                </div>

                <div id="roles-settings" class="mt-5">
                    <h2>Paramètres des Rôles</h2>
                    <form method="post" action="settings#roles-settings">
                        <?php
                        $sql = "SELECT * FROM roles";
                        $stmt = $pdo->query($sql);

                        $roleData = array();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $roleData[$row['id']] = $row;
                        }
                        for ($i = 1; $i <= 8; $i++) {
                            $roleName = "";
                            $backgroundUrl = "";
                            if (isset($roleData[$i])) {
                                $roleName = $roleData[$i]['role_name'];
                                $backgroundUrl = $roleData[$i]['role_background'];
                            }

                            echo '<div class="form-group">';
                            echo '<label for="role' . $i . '_name">Nom du rôle ' . $i . ':</label>';
                            echo '<input type="text" class="form-control" id="role' . $i . '_name" name="role' . $i . '_name" value="' . $roleName . '">';

                            echo '<label for="role' . $i . '_background">URL de l\'image de fond du rôle ' . $i . ':</label>';
                            echo '<input type="text" class="form-control" id="role' . $i . '_background" name="role' . $i . '_background" value="' . $backgroundUrl . '">';
                            echo '</div>';
                        }
                        ?>
                        <input type="submit" class="btn btn-primary mt-3" name="submit_roles_settings" value="Enregistrer">
                    </form>
                </div>
            </div>
        </div>
    </div>
                        
    <div class="footer mt-5">Créé avec ❤️ par Riptiaz | discord.gg/VCmNXHvf77</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

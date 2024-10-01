<?php
require_once './utils/logs.php';
session_start();
$configFilePath = './conn.php';
if (!file_exists($configFilePath)) {
    header('Location: setdb');
    exit();
}
$file = 'reset_password.php';

if (file_exists($file)) {
    echo "<h2>Attention !</h2>";
    echo "<p>Le fichier <strong>reset_password.php</strong> existe à la racine.</p>";
    echo "<p>Pour accéder au panel, veuillez le supprimer.</p>";
    
    echo '<form method="POST">';
    echo '<button type="submit" name="delete_file" style="margin-right: 10px;">Supprimer le fichier</button>';
    echo '</form>';

    if (isset($_POST['delete_file'])) {
        if (unlink($file)) {
            echo "<p>Le fichier a été supprimé avec succès. Vous pouvez maintenant accéder au panel.</p>";
            header("Location: settings");
        } else {
            echo "<p>Erreur lors de la suppression du fichier.</p>";
        }
    }
    exit();
}
require_once './connexion_bdd.php';
require('./auth.php');
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: account/connexion');
    exit();
}
$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit_roles_settings"])) {
        for ($i = 1; $i <= 8; $i++) {
            $roleName = $_POST["role" . $i . "_name"] ?? '';

            $sql = "SELECT role_background FROM roles WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $i);
            $stmt->execute();
            $currentBackground = $stmt->fetchColumn();

            $backgroundUrl = uploadRoleImage($i, $currentBackground);

            if (!empty($roleName)) {
                $sql = "INSERT INTO roles (id, role_name, role_background) VALUES (:id, :role_name, :role_background)
                        ON DUPLICATE KEY UPDATE role_name = :role_name, role_background = :role_background";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $i);
                $stmt->bindParam(':role_name', $roleName);
                $stmt->bindParam(':role_background', $backgroundUrl);
                $stmt->execute();

                $action = "Modification du rôle $roleName avec l'image de fond $backgroundUrl";
                logAction($_SESSION['user_email'], $action);
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

        $action = "Modification du mode maintenance avec message : $maintenance_message";
        logAction($_SESSION['user_email'], $action);

    } elseif (isset($_POST["submit_server_info"])) {
        $server_name = $_POST["server_name"];
        $server_ip = $_POST["server_ip"];
        $server_port = $_POST["server_port"];

        $current_img = isset($row['server_img']) ? $row['server_img'] : null;
        $server_img = uploadServerImage($current_img);

        $sql = "UPDATE options SET server_name = ?, server_ip = ?, server_port = ?, server_img = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$server_name, $server_ip, $server_port, $server_img]);

        $action = "Modification des informations du serveur : $server_name, $server_ip:$server_port";
        logAction($_SESSION['user_email'], $action);

    }elseif (isset($_POST["submit_loader_settings"])) {
        
            $game_folder_name = $_POST["minecraft_version"];
            $sql = "UPDATE options SET minecraft_version = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$game_folder_name]);
            $loader_type = $_POST["loader_type"];
            $loader_build_version = $_POST["loader_build_version"];
            $loader_forge_version = $_POST["loader_forge_version"];
            $loader_activation = isset($_POST["loader_activation"]) ? 1 : 0;
            
            $sql = "UPDATE options SET loader_type = ?, loader_build_version = ?, loader_forge_version = ?, loader_activation = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$loader_type, $loader_build_version, $loader_forge_version, $loader_activation]);

            $action = "Modification des paramètres de chargement : $loader_type, version $loader_build_version, activation $loader_activation";
            logAction($_SESSION['user_email'], $action);
        
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

        $action = "Modification des paramètres RPC : ID $rpc_id, détails $rpc_details, état $rpc_state, texte large $rpc_large_text, texte petit $rpc_small_text, activation $rpc_activation, bouton 1 $rpc_button1, URL bouton 1 $rpc_button1_url, bouton 2 $rpc_button2, URL bouton 2 $rpc_button2_url";
        logAction($_SESSION['user_email'], $action);
    
    }elseif (isset($_POST["submit_splash_info"])) {
        $splash = $_POST["splash"];
        $splash_author = $_POST["splash_author"];
        
        $sql = "UPDATE options SET splash = ?, splash_author = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$splash, $splash_author]);

        $action = "Modification de l'écran de chargement : $splash, auteur $splash_author";
        logAction($_SESSION['user_email'], $action);
    
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

        $action = "Mise à jour des dossiers ignorés : $ignored_folder";
        logAction($_SESSION['user_email'], $action);

    }elseif (isset($_POST["submit_whitelist"])) {
        $whitelist = isset($_POST["whitelist_activation"]) ? 1 : 0;
        $sql = "UPDATE options SET whitelist_activation = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$whitelist]);
        $whitelistUsers = $_POST["whitelist_users"];
        $usernamesArray = explode(',', $whitelistUsers);
        $usernamesArray = array_map('trim', $usernamesArray);
    
        $sqlDeleteUsers = "DELETE FROM whitelist";
        $pdo->exec($sqlDeleteUsers);
    
        $sqlInsertUsers = "INSERT INTO whitelist (users) VALUES (:users)";
        $stmtUsers = $pdo->prepare($sqlInsertUsers);
    
        foreach ($usernamesArray as $username) {
            $stmtUsers->bindParam(':users', $username);
            $stmtUsers->execute();
        }
        $whitelistRoles = $_POST["whitelist_roles"];
        $rolesArray = explode(',', $whitelistRoles);
        $rolesArray = array_map('trim', $rolesArray);
    
        $sqlDeleteRoles = "DELETE FROM whitelist_roles";
        $pdo->exec($sqlDeleteRoles);
    
        $sqlInsertRoles = "INSERT INTO whitelist_roles (role) VALUES (:role)";
        $stmtRoles = $pdo->prepare($sqlInsertRoles);
    
        foreach ($rolesArray as $role) {
            $stmtRoles->bindParam(':role', $role);
            $stmtRoles->execute();
        }
        $action = "Mise à jour de la liste blanche : activation $whitelist, utilisateurs $whitelistUsers, rôles $whitelistRoles";
        logAction($_SESSION['user_email'], $action);
    }
    elseif (isset($_POST["submit_general_settings"])) {
        
            $role = isset($_POST["role"]) ? 1 : 0;
            $sql = "UPDATE options SET role = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$role]);
      
            $money = isset($_POST["money"]) ? 1 : 0;
            $sql = "UPDATE options SET money = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$money]);

            $email_verified = isset($_POST["email_verified"]) ? 1 : 0;
            $sql = "UPDATE options SET email_verified = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email_verified]);
          
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

            $action = "Modification des paramètres généraux : rôle $role, argent $money, dossier de jeu $game_folder_name, Azuriom $azuriom, mods activés $mods, vérification des fichiers $file_verification, Java intégré $embedded_java";
            logAction($_SESSION['user_email'], $action);
}elseif (isset($_POST["add_optional"])) {
    $index = $_POST["add_optional"];
    $modFile = $_POST["file"];
    $modName = $_POST["name"];
    $modDescription = $_POST["description"];
    $modIcon = $_POST["icon"];
    $modRecommended = isset($_POST["recommended"]) ? 1 : 0;
    
    $sql = "INSERT INTO mods (file, name, description, icon, optional, recommended) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$modFile, $modName, $modDescription, $modIcon, 1, $modRecommended]);

    $action = "Ajout du mod optionnel : " . $modName;
    logAction($_SESSION['user_email'], $action);
} elseif (isset($_POST["update_optional"])) {
    $modId = $_POST["mod_id"];
    $modName = $_POST["optional_name"];
    $modDescription = $_POST["optional_description"];

    $sql = "SELECT icon FROM mods WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $modId);
    $stmt->execute();
    $currentImage = $stmt->fetchColumn();

    $modIcon = uploadModImage($modId, $currentImage);

    $modRecommended = isset($_POST["optional_recommended"]) ? 1 : 0;

    $sql = "UPDATE mods SET name = ?, description = ?, icon = ?, recommended = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$modName, $modDescription, $modIcon, $modRecommended, $modId]);

    $action = "Modification du mod optionnel : $modName";
    logAction($_SESSION['user_email'], $action);
} elseif (isset($_POST["delete_optional"])) {
    $modId = $_POST["mod_id"];

    $sql = "DELETE FROM mods WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$modId]);

    $action = "Suppression d'un mod optionnel";
    logAction($_SESSION['user_email'], $action);
}elseif (isset($_POST["submit_alert_settings"])) {
    $alert_activation = isset($_POST["alert_activation"]) ? 1 : 0;
    $alert_scroll = isset($_POST["alert_scroll"]) ? 1 : 0;
    $alert_msg = $_POST["alert_msg"];

    $sql = "UPDATE options SET alert_activation = ?, alert_scroll = ?, alert_msg = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$alert_activation, $alert_scroll, $alert_msg]);

    $action = "Modification des paramètres d'alerte : activation $alert_activation, scroll $alert_scroll, message $alert_msg";
    logAction($_SESSION['user_email'], $action);
}elseif (isset($_POST["submit_video_settings"])) {
    $video_activation = isset($_POST["video_activation"]) ? 1 : 0;
    $video_url = $_POST["video_url"];

    $sql = "UPDATE options SET video_activation = ?, video_url = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$video_activation, $video_url]);

    $action = "Modification des paramètres vidéos : activation $video_activation, url $video_url";
    logAction($_SESSION['user_email'], $action);
}
}
$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
function uploadServerImage($currentImage)
{
    if (empty($_FILES['server_img']['tmp_name']) || $_FILES['server_img']['error'] !== UPLOAD_ERR_OK) {
        return $currentImage;
    }

    $uploadDir = './uploads/';
    $uploadedFile = $_FILES['server_img']['tmp_name'];
    $fileName = $_FILES['server_img']['name'];
    $fileType = $_FILES['server_img']['type'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedTypes)) {
        die("Erreur : Seuls les fichiers JPEG, PNG et GIF sont autorisés.");
    }

    $uniqueFileName = uniqid() . '_' . $fileName;

    if (move_uploaded_file($uploadedFile, $uploadDir . $uniqueFileName)) {
        return $uploadDir . $uniqueFileName;
    } else {
        die("Erreur lors du déplacement du fichier téléchargé.");
    }
}
function uploadRoleImage($roleIndex, $currentBackground) {
    if (isset($_FILES["role" . $roleIndex . "_background"]) && $_FILES["role" . $roleIndex . "_background"]["error"] == 0) {
        $targetDirectory = "uploads";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
        $targetFile = $targetDirectory . basename($_FILES["role" . $roleIndex . "_background"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (getimagesize($_FILES["role" . $roleIndex . "_background"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["role" . $roleIndex . "_background"]["tmp_name"], $targetFile)) {
                return $targetFile;
            }
        }
    }
    return $currentBackground;
}
function uploadModImage($modId, $currentImage)
{
    if (isset($_FILES["optional_image"]) && $_FILES["optional_image"]["error"] == UPLOAD_ERR_OK) {
        $targetDirectory = "uploads/";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $fileName = $_FILES["optional_image"]["name"];
        $targetFile = $targetDirectory . basename($fileName);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (getimagesize($_FILES["optional_image"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["optional_image"]["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                die("Erreur lors du déplacement du fichier téléchargé.");
            }
        } else {
            die("Le fichier téléchargé n'est pas une image valide.");
        }
    }
    return $currentImage;
}

$modsDir = './data/files/mods';
$modsData = [];
$jarFiles = glob($modsDir . '/*.jar');
foreach ($jarFiles as $index => $jarFile) {
    $modsData[$index] = [
        'file' => $jarFile,
        'name' => basename($jarFile),
        'description' => '',
        'icon' => '',
        'optional' => 0,
    ];
}

$sql = "SELECT * FROM mods WHERE optional = 1";
$optionalModsStmt = $pdo->query($sql);
$optionalMods = $optionalModsStmt->fetchAll(PDO::FETCH_ASSOC);

function getCurrentVersion() {
    return trim(file_get_contents('update/version.txt'));
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

$currentVersion = getCurrentVersion();
$latestVersion = getLatestVersion();
$isNewVersionAvailable = isNewVersionAvailable($currentVersion, $latestVersion);

?>
<?php
require_once './ui/header.php';
?>
<style>
 .scroll-to-top {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      z-index: 10;
    }
  </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if ($isNewVersionAvailable): ?>
<script>
Swal.fire({
    title: 'Mise à jour disponible',
    text: 'Voulez-vous mettre à jour maintenant?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Oui, mettre à jour!',
    cancelButtonText: 'Non, annuler',
    html: '<div id="updateMessage"></div>', // Ajout de la div ici
}).then((result) => {
    if (result.isConfirmed) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update/update.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    // Mettre à jour le message dans la div
                    document.getElementById('updateMessage').innerText = response.message;

                    if (response.success) {
                        // Afficher le message de succès
                        Swal.fire({
                            title: 'Mise à jour réussie',
                            text: 'La base de données a été mise à jour avec succès.',
                            icon: 'success',
                            confirmButtonText: 'Fermer'
                        });
                        // Ajustez les boutons de l'alerte précédente
                        document.getElementById('confirmUpdateButton').style.display = 'none';
                        document.getElementById('cancelUpdateButton').innerText = 'Ok';
                    } else {
                        // Afficher le message d'erreur
                        Swal.fire({
                            title: 'Erreur',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Fermer'
                        });
                    }
                } catch (error) {
                    console.error("Erreur lors de l'analyse de la réponse JSON : ", error);
                    Swal.fire({
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de la mise à jour.',
                        icon: 'error',
                        confirmButtonText: 'Fermer'
                    });
                }
            }
        };
        xhr.send('update_button=1');
    }
});
</script>
<?php endif; ?>
   <a href="#" class="scroll-to-top bg-gray-900 hover:bg-blue-600 text-white py-2 px-4 rounded-full shadow-lg transition duration-300 ease-in-out">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block align-middle" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
  </a>
<?php require_once './function/main.php';?>
<?php require_once './function/serveur.php';?>
<?php require_once './function/splash.php';?>
<?php require_once './function/loader.php';?>           
<?php require_once './function/rpc.php';?>           
<?php require_once './function/maintenance.php';?>
<?php require_once './function/whitelist.php';?>  
<?php require_once './function/roles.php';?>
<?php require_once './function/ignore.php';?>
<?php require_once './function/mods.php';?>
<?php require_once './function/alert.php';?>
<?php require_once './function/video.php';?>
<?php require_once './ui/footer.php';
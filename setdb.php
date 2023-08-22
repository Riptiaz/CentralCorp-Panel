
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Configuration de la base de données</title>
    <link rel="stylesheet" href="css/setdb.css">
</head>
<body>
<h1 id="config-title">Configuration de la base de données</h1>
<?php
$configFilePath = 'config.php';

if (!file_exists($configFilePath)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $host = $_POST['host'];
        $dbname = $_POST['dbname'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Testez la connexion à la base de données
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $configContent = <<<EOT
<?php

\$databaseConfig = [
    'host' => '$host',
    'dbname' => '$dbname',
    'username' => '$username',
    'password' => '$password',
];

?>
EOT;
            file_put_contents($configFilePath, $configContent);
            $sqlFile = 'utils/panel.sql';
            $sqlCommands = file_get_contents($sqlFile);
            $pdo->exec($sqlCommands);
            header('Location: account/register');
            exit();
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    } else {
        // Afficher le formulaire
        echo '<form class="form-container" method="post">';
        echo 'Hôte: <input type="text" name="host"><br>';
        echo 'Nom de la base de données: <input type="text" name="dbname"><br>';
        echo 'Nom d utilisateur: <input type="text" name="username"><br>';
        echo 'Mot de passe: <input type="password" name="password"><br>';
        echo '<input type="submit" value="Enregistrer">';
        echo '</form>';
        exit;
    }
} elseif (file_exists($configFilePath)) {
    header('Location: account/connexion');
    exit();
}
?>
</body>
</html>

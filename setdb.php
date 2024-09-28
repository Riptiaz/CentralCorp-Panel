<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configuration de la base de données</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
<div class="container mx-auto mt-20 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <h1 id="config-title" class="text-3xl font-bold mb-6 text-center">Configuration de la base de données</h1>

    <?php
    $configFilePath = './conn.php';

    if (!file_exists($configFilePath)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $host = $_POST['host'];
            $dbname = $_POST['dbname'];
            $username = $_POST['username'];
            $password = $_POST['password'];

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
                echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">';
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
                echo '</div>';
            }
        } else {
            echo '<form class="form-container" method="post">';
            echo '<div class="mb-4">';
            echo '<label for="host" class="block text-gray-400 text-sm font-medium mb-2">Hôte:</label>';
            echo '<input type="text" placeholder="Exemple: 127.0.0.1:3306" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" name="host" required>';
            echo '</div>';
            echo '<div class="mb-4">';
            echo '<label for="dbname"  class="block text-gray-400 text-sm font-medium mb-2">Nom de la base de données:</label>';
            echo '<input type="text" placeholder="mon_nom_de_base_donné" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" name="dbname" required>';
            echo '</div>';
            echo '<div class="mb-4">';
            echo '<label for="username" class="block text-gray-400 text-sm font-medium mb-2">Nom d\'utilisateur:</label>';
            echo '<input type="text" placeholder="launcher" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" name="username" required>';
            echo '</div>';
            echo '<div class="mb-4">';
            echo '<label for="password" class="block text-gray-400 text-sm font-medium mb-2">Mot de passe:</label>';
            echo '<div class="relative">';
            echo '<input type="password" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" name="password">';
            echo '<i class="bi bi-lock-fill absolute right-10 top-2.5 text-gray-400"></i>';
            echo '<i id="togglePassword" class="bi bi-eye-fill absolute right-3 top-2.5 cursor-pointer text-gray-400"></i>';
            echo '</div>';
            echo '</div>';
            echo '<button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 mt-3">Enregistrer</button>';
            echo '</form>';
            exit;
        }
    } elseif (file_exists($configFilePath)) {
        header('Location: account/connexion');
        exit();
    }
    ?>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('input[name="password"]');

    togglePassword.addEventListener('click', function(e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye-fill');
        this.classList.toggle('bi-eye-slash-fill');
    });
</script>
</body>
</html>

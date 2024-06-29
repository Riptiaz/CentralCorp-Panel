<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-800 text-white">
    <nav class="bg-gray-900 p-4 static w-full z-10 top-0 shadow">
        <div class="container mx-auto flex flex-wrap items-center justify-between">
            <a class="text-xl font-bold" href="#">Panel</a>
            <button class="text-white 2xl:hidden" id="nav-toggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="w-full 2xl:flex 2xl:items-center 2xl:w-auto hidden 2xl:block" id="nav-content">
                <ul class="2xl:flex 2xl:justify-between text-sm">
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#">Général</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#server-info-settings">Serveur</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#loader-settings">Loader</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#rpc-settings">Discord RPC</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#splash-settings">Splash</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#changelog-settings">Changelog</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#maintenance-settings">Maintenance</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#whitelist-settings">Whitelist</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#ignored-folders-settings">Dossiers Ignorés</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="#roles-settings">Fond d'écran par rôle</a>
                    </li>
                </ul>
                <div class="flex items-center space-x-4 mt-4 2xl:mt-0">
                    <form class="flex items-center" method="post" action="">
                        <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit" name="logout">Déconnexion</button>
                    </form>
                    <a class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="./utils/export">Exporter</a>
                    <form id="importForm" method="post" action="utils/import.php" enctype="multipart/form-data">
                        <label class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                            Importer
                            <input type="file" id="jsonFileInput" name="json_file" class="hidden" accept=".json" required>
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <script>
        document.getElementById('jsonFileInput').addEventListener('change', function() {
            document.getElementById('importForm').submit();
        });
        document.getElementById('nav-toggle').addEventListener('click', function() {
            var navContent = document.getElementById('nav-content');
            navContent.classList.toggle('hidden');
        });
    </script>

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
                        <button id="updateButton" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update</button>
                </div>
            </div>
        </div>
    </nav>
    <div id="updateOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>
    <div id="updatePopup" class="fixed inset-0 bg-gray-700 p-4 rounded shadow-lg w-1/3 mx-auto mt-20 hidden">
    <div class="flex flex-col items-center justify-center h-full">
        <div class="text-center">
            <h2 class="text-xl font-bold mb-4">Mise à jour du système</h2>
            <p id="updateMessage" class="mb-4">Voulez-vous vraiment mettre à jour le système ?</p>
            <div class="flex justify-center">
                <button id="confirmUpdateButton" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Oui</button>
                <button id="cancelUpdateButton" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Non</button>
            </div>
        </div>
    </div>
</div>
    <script>
        document.getElementById('jsonFileInput').addEventListener('change', function() {
            document.getElementById('importForm').submit();
        });

        document.getElementById('nav-toggle').addEventListener('click', function() {
            var navContent = document.getElementById('nav-content');
            navContent.classList.toggle('hidden');
        });

        document.getElementById('updateButton').addEventListener('click', function() {
        document.getElementById('updateOverlay').classList.remove('hidden');
        document.getElementById('updatePopup').classList.remove('hidden');
        });

        document.getElementById('cancelUpdateButton').addEventListener('click', function() {
        document.getElementById('updateOverlay').classList.add('hidden');
        document.getElementById('updatePopup').classList.add('hidden');
        });

        document.getElementById('confirmUpdateButton').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update/update.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('updateMessage').innerText = response.message;
            if (response.success) {
                document.getElementById('confirmUpdateButton').style.display = 'none';
            }
            }
        };
        xhr.send('update_button=1');
        });

    </script>
</body>
</html>
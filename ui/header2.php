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
            <a class="text-xl font-bold" href="../../settings#">Panel</a>
            <button class="text-white 2xl:hidden" id="nav-toggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="w-full 2xl:flex 2xl:items-center 2xl:w-auto hidden 2xl:block" id="nav-content">
                <ul class="flex flex-wrap items-center text-sm space-x-4">
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="../../settings#">Général</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="../../settings#server-info-settings">Serveur</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="../../settings#loader-settings">Loader</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="../../settings#mods-settings">Mods optionnels</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="../../settings#maintenance-settings">Maintenance</a>
                    </li>
                    <li class="nav-item">
                        <a class="block 2xl:inline-block px-4 py-2" href="../../settings#whitelist-settings">Whitelist</a>
                    </li>
                </ul>
                <div class="flex items-center space-x-4 ml-auto mt-4 2xl:mt-0 relative">
                    <div class="relative inline-block text-left">
                        <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-700" id="menu-button-other" aria-expanded="true" aria-haspopup="true">
                            Autres
                            <svg class="-mr-1 h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="other-dropdown" class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-other" tabindex="-1">
                            <div class="py-1" role="none">
                                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1" href="../../settings#video-settings">Vidéo communautaire</a>
                                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1" href="../../settings#alert-settings">Alerte</a>
                                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1" href="../../settings#ignored-folders-settings">Dossiers ignorés</a>
                                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-2" href="../../settings#roles-settings">Fond d'écran par rôle</a>
                                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-5" href="../../settings#rpc-settings">Discord RPC</a>
                                <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-6" href="../../settings#splash-settings">Splash</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative inline-block text-left">
                        <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700" id="menu-button-settings" aria-expanded="true" aria-haspopup="true">
                            Paramètres Panel
                            <svg class="-mr-1 h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="settings-panel-dropdown" class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-settings" tabindex="-1">
                            <div class="py-1" role="none">
                                <form id="importForm" method="post" action="../../utils/import.php" enctype="multipart/form-data">
                                    <label class="block px-4 py-2 hover:bg-gray-100 text-gray-700 cursor-pointer" role="menuitem" tabindex="-1" id="menu-item-0">
                                        Importer
                                        <input type="file" id="jsonFileInput" name="json_file" class="hidden" accept=".json" required>
                                    </label>
                                </form>
                                <a href="../../utils/export" class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1">Exporter</a>
                                <button id="updateButton" class="block w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-2">Mettre à jour</button>
                                <a href="../../file" class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-3">Gestionnaire de fichiers</a>
                                <a href="../../account/new/register" class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-4">Ajouter un utilisateur</a>
                                <a href="../../logs/view" class="block px-4 py-2 text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-5">Logs</a>
                            </div>
                        </div>
                    </div>

                    <form class="flex items-center" method="post" action="">
                        <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit" name="logout">Déconnexion</button>
                    </form>
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
            xhr.open('POST', '../../update/update.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('updateMessage').innerText = response.message;
                    if (response.success) {
                        document.getElementById('confirmUpdateButton').style.display = 'none';
                        document.getElementById('cancelUpdateButton').innerText = 'Ok';
                    }
                }
            };
            xhr.send('update_button=1');
        });

        document.getElementById('menu-button-other').addEventListener('click', function() {
            var dropdown = document.getElementById('other-dropdown');
            dropdown.classList.toggle('hidden');
        });

        document.getElementById('menu-button-settings').addEventListener('click', function() {
            var dropdown = document.getElementById('settings-panel-dropdown');
            dropdown.classList.toggle('hidden');
        });

        window.addEventListener('click', function(e) {
            var otherButton = document.getElementById('menu-button-other');
            var otherDropdown = document.getElementById('other-dropdown');
            if (!otherButton.contains(e.target) && !otherDropdown.contains(e.target)) {
                otherDropdown.classList.add('hidden');
            }

            var settingsButton = document.getElementById('menu-button-settings');
            var settingsDropdown = document.getElementById('settings-panel-dropdown');
            if (!settingsButton.contains(e.target) && !settingsDropdown.contains(e.target)) {
                settingsDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
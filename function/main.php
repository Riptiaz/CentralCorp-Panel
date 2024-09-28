<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <form method="post" action="settings#general-settings">
                <div id="general-settings">
                    <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Général</h2>
                    <div class="mb-6">
                        <label for="azuriom" class="block text-sm font-medium text-gray-400 mb-2">URL du site Azuriom
                            :</label>
                        <input type="text"
                            class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="https://monsite.com" id="azuriom" name="azuriom"
                            value="<?php echo $row['azuriom']; ?>">
                        <div class="mt-4 flex items-center">
                            <button id="test-url"
                                class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Tester
                                l'URL</button>
                            <p id="url-result" class="ml-4 text-sm text-gray-400"></p>
                        </div>
                    </div>
                </div>

                <script>
                document.getElementById('test-url').addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = document.getElementById('azuriom').value + '/api/rss';
                    fetch(url)
                        .then(response => {
                            if (response.ok) {
                                document.getElementById('url-result').textContent = 'URL valide';
                                document.getElementById('url-result').classList.add('text-green-500');
                                document.getElementById('url-result').classList.remove('text-red-500');
                            } else {
                                throw new Error('Non valide');
                            }
                        })
                        .catch(error => {
                            document.getElementById('url-result').textContent = 'URL non valide';
                            document.getElementById('url-result').classList.add('text-red-500');
                            document.getElementById('url-result').classList.remove('text-green-500');
                        });
                });
                </script>



                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Mods :</label>
                    <div class="flex items-center">
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                            id="mods_enabled" name="mods_enabled"
                            <?php if ($row['mods_enabled'] == 1) echo 'checked'; ?>>
                        <label for="mods_enabled" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Vérification des Fichiers :</label>
                    <div class="flex items-center">
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                            id="file_verification" name="file_verification"
                            <?php if ($row['file_verification'] == 1) echo 'checked'; ?>>
                        <label for="file_verification" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Version Préembarquée de Java :</label>
                    <div class="flex items-center">
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                            id="embedded_java" name="embedded_java"
                            <?php if ($row['embedded_java'] == 1) echo 'checked'; ?>>
                        <label for="embedded_java" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Exiger une email vérifiée :</label>
                    <div class="flex items-center">
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="email_verified"
                            name="email_verified" <?php if ($row['email_verified'] == 1) echo 'checked'; ?>>
                        <label for="email_verified" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Affichage du rôle :</label>
                    <div class="flex items-center">
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="role"
                            name="role" <?php if ($row['role'] == 1) echo 'checked'; ?>>
                        <label for="role" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Affichage des points :</label>
                    <div class="flex items-center">
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="money"
                            name="money" <?php if ($row['money'] == 1) echo 'checked'; ?>>
                        <label for="money" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>

                <div class="mb-6 mt-6">
                    <label for="game_folder_name" class="block text-sm font-medium text-gray-400 mb-2">Nom du Dossier du
                        Répertoire du Jeu :</label>
                    <input type="text"
                        class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500"
                        id="game_folder_name" name="game_folder_name" value="<?php echo $row['game_folder_name']; ?>">
                </div>

                

                <button type="submit" name="submit_general_settings"
                    class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
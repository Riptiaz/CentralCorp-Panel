<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="ignored-folders-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres des Dossiers Ignorés</h2>
            <form method="post" action="settings#ignored-folders-settings">
                <div class="mb-6">
                    
                    <label for="ignored-folder" class="block text-sm font-medium text-gray-400 mb-2">Dossiers ignorés (séparés par des virgules) :</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="ignored-folder" name="ignored_folder" value="<?php
                                $sql = "SELECT folder_name FROM ignored_folders"; 
                                $stmt = $pdo->query($sql);
                                $folders = array();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $folders[] = $row["folder_name"];
                                }
                                echo implode(', ', $folders);
                            ?>">
                </div>
                <button type="submit" name="submit_ignored_folder_data" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
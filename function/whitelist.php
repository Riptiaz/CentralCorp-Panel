

    <div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="whitelist-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres de la Whitelist</h2>
            <form method="post" action="settings#whitelist-settings">
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="whitelist-activation" name="whitelist_activation" <?php if ($row["whitelist_activation"] == 1) echo "checked"; ?>>
                        <label for="whitelist-activation" class="ml-2 block text-sm text-gray-400">Activer</label>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="whitelist-users" class="block text-sm font-medium text-gray-400 mb-2">Noms d'utilisateurs (séparés par des virgules) :</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="whitelist-users" name="whitelist_users" value="<?php
                $sql = "SELECT users FROM whitelist"; 
                $stmt = $pdo->query($sql);

                $userNames = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $userNames[] = $row["users"];
                }
                echo implode(', ', $userNames);
            ?>">
                </div>
                <button type="submit" name="submit_whitelist" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

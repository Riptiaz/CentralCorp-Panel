<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="loader-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres du Loader et de Minecraft</h2>
            <form method="post" action="settings#loader-settings">
                <div class="mb-6">
                    <label for="minecraft_version" class="block text-sm font-medium text-gray-400 mb-2">Version de Minecraft :</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="minecraft_version" name="minecraft_version" value="<?php echo $row['minecraft_version']; ?>">
                </div>
                <div class="mb-6">
                    <label for="loader-type" class="block text-sm font-medium text-gray-400 mb-2">Type de Loader :</label>
                    <select class="form-select mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="loader-type" name="loader_type">
                        <option value="forge" <?php if ($row['loader_type'] == 'forge') echo 'selected'; ?>>Forge</option>
                        <option value="fabric" <?php if ($row['loader_type'] == 'fabric') echo 'selected'; ?>>Fabric</option>
                        <option value="legacyfabric" <?php if ($row['loader_type'] == 'legacyfabric') echo 'selected'; ?>>LegacyFabric</option>
                        <option value="neoForge" <?php if ($row['loader_type'] == 'neoForge') echo 'selected'; ?>>NeoForge</option>
                        <option value="quilt" <?php if ($row['loader_type'] == 'quilt') echo 'selected'; ?>>Quilt</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="loader-build-version" class="block text-sm font-medium text-gray-400 mb-2">Version de Build du loader :</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="loader-build-version" name="loader_build_version" value="<?php echo $row['loader_build_version']; ?>">
                </div>
                <div class="flex items-center mb-6">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="loader-activation" name="loader_activation" <?php if ($row['loader_activation'] == 1) echo 'checked'; ?>>
                    <label for="loader-activation" class="ml-2 block text-sm text-gray-400">Activer</label>
                </div>
                <button type="submit" name="submit_loader_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

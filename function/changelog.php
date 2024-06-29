<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="changelog-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres du Changelog</h2>
            <form method="post" action="settings#changelog-settings">
                <div class="mb-6">
                    <label for="changelog-version" class="block text-sm font-medium text-gray-400 mb-2">Numéro de Mise à Jour du Changelog :</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="changelog-version" name="changelog_version" value="<?php echo $row['changelog_version']; ?>">
                </div>
                <div class="mb-6">
                    <label for="changelog-message" class="block text-sm font-medium text-gray-400 mb-2">Message du Changelog :</label>
                    <textarea class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="changelog-message" name="changelog_message" rows="4" cols="50"><?php echo str_replace('<br>', "\n", $row['changelog_message']); ?></textarea>
                </div>
                <button type="submit" name="submit_changelog" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

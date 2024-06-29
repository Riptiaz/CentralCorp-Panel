<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="maintenance-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres de Maintenance</h2>
            <form method="post" action="settings#maintenance-settings">
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="maintenance" name="maintenance" <?php if ($row["maintenance"] == 1) echo "checked"; ?>>
                        <label for="maintenance" class="ml-2 block text-sm text-gray-400">Maintenance</label>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="maintenance_message" class="block text-sm font-medium text-gray-400 mb-2">Message de Maintenance :</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="maintenance_message" name="maintenance_message" value="<?php echo $row['maintenance_message']; ?>">
                </div>
                <button type="submit" name="submit_maintenance" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

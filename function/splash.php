<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <form method="post" action="settings#splash-settings">
                <div id="splash-settings">
                    <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres du Splash</h2>
                    <div class="mb-6">
                        <label for="splash" class="block text-sm font-medium text-gray-400 mb-2">Message Splash :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="splash" name="splash" value="<?php echo $row['splash']; ?>">
                    </div>
                    <div class="mb-6">
                        <label for="splash_author" class="block text-sm font-medium text-gray-400 mb-2">Auteur du Splash :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="splash_author" name="splash_author" value="<?php echo $row['splash_author']; ?>">
                    </div>
                </div>
                <button type="submit" name="submit_splash_info" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

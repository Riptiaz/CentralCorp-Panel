<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <form method="post" action="settings.php#alert-settings">
                <div id="alert-settings">
                    <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres de l'Alerte</h2>
                    
                    <!-- Debug Information -->
                    <div class="mb-6 bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-xl font-bold mb-2 text-red-500">Debug Information :</h3>
                        <pre class="text-sm text-gray-300"><?php echo 'Contenu de $row : '; print_r($row); ?></pre>
                        <?php if (isset($_POST)): ?>
                        <pre class="text-sm text-gray-300"><?php echo 'Contenu de $_POST : '; print_r($_POST); ?></pre>
                        <?php endif; ?>
                    </div>
                    <!-- End of Debug Information -->
                    
                    <div class="mb-6">
                        <label for="alert_msg" class="block text-sm font-medium text-gray-400 mb-2">Message de l'Alerte :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="alert_msg" name="alert_msg" value="<?php echo $row['alert_msg']; ?>">
                    </div>
                    <div class="mb-6">
                        <label for="alert_activation" class="block text-sm font-medium text-gray-400 mb-2">Activer l'Alerte :</label>
                        <input type="checkbox" id="alert_activation" name="alert_activation" value="1" <?php echo $row['alert_activation'] ? 'checked' : ''; ?>>
                    </div>
                </div>
                <button type="submit" name="submit_alert_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

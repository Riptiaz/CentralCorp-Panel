<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <form method="post" action="settings.php#video-settings">
                <div id="video-settings">
                    <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres de la vidéo communautaire</h2>
                    <div class="mb-6">
                        <label for="video_url" class="block text-sm font-medium text-gray-400 mb-2">URL de la vidéo communautaire :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="video_url" name="video_url" value="<?php echo $row['video_url']; ?>">
                    </div>
                    <div class="mb-6">
                        <label for="video_activation" class="block text-sm font-medium text-gray-400 mb-2">Activer la vidéo :</label>
                        <input type="checkbox" id="video_activation" name="video_activation" value="1" <?php if ($row["video_activation"] == 1) echo "checked"; ?>>
                    </div>
                </div>
                <button type="submit" name="submit_video_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

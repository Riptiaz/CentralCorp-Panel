<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <form method="post" action="settings#server-info-settings" enctype="multipart/form-data">
                <div id="server-info-settings">
                    <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres du Serveur</h2>
                    <div class="mb-6">
                        <label for="server_name" class="block text-sm font-medium text-gray-400 mb-2">Nom du Serveur :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="server_name" name="server_name" value="<?php echo $row['server_name']; ?>">
                    </div>
                    <div class="mb-6">
                        <label for="server_ip" class="block text-sm font-medium text-gray-400 mb-2">IP du Serveur :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="server_ip" name="server_ip" value="<?php echo $row['server_ip']; ?>">
                    </div>
                    <div class="mb-6">
                        <label for="server_port" class="block text-sm font-medium text-gray-400 mb-2">Port du Serveur :</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="server_port" name="server_port" value="<?php echo $row['server_port']; ?>">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Image du statut de serveur :</label>
                        <?php if (!empty($row['server_img'])): ?>
                            <div class="flex items-center mb-2">
                                <img src="<?php echo $row['server_img']; ?>" class="rounded-lg mr-4 h-16 w-16 object-cover" alt="Image du serveur">
                            </div>
                        <?php endif; ?>
                        <input type="file" id="new_server_img" name="server_img" accept="image/*" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <button type="submit" name="submit_server_info" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
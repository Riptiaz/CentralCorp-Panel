<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="rpc-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres du RPC</h2>
            <form method="post" action="settings#rpc-settings">
                <?php
                    $rpcFields = array(
                        "rpc_id" => "ID Client pour le RPC",
                        "rpc_details" => "Message de détails",
                        "rpc_state" => "Message de l'état",
                        "rpc_large_text" => "Message pour la grande image",
                        "rpc_small_text" => "Message pour la petite image",
                        "rpc_button1" => "Nom du 1er bouton",
                        "rpc_button1_url" => "URL du 1er bouton",
                        "rpc_button2" => "Nom du 2ème bouton",
                        "rpc_button2_url" => "URL du 2ème bouton",
                    );

                    foreach ($rpcFields as $fieldName => $fieldLabel) {
                ?>
                <div class="mb-6">
                    <label for="<?php echo $fieldName; ?>" class="block text-sm font-medium text-gray-400 mb-2"><?php echo $fieldLabel; ?>:</label>
                    <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" value="<?php echo $row[$fieldName]; ?>">
                </div>
                <?php
                    }
                ?>
                <div class="flex items-center mb-6">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" id="rpc-activation" name="rpc_activation" <?php if ($row["rpc_activation"] == 1) echo "checked"; ?>>
                    <label for="rpc-activation" class="ml-2 block text-sm text-gray-400">Activer</label>
                </div>
                <button type="submit" name="submit_rpc_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

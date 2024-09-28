<script>
    function toggleOptionalOptions() {
        const optionalCheckbox = document.getElementById('optional_checkbox');
        const modSections = document.querySelectorAll('.mod-settings');

        modSections.forEach(section => {
            if (optionalCheckbox.checked) {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        });
    }

    function showModSettings() {
        const selectedMod = document.getElementById('mod_select').value;
        const modSections = document.querySelectorAll('.mod-settings');

        modSections.forEach(section => {
            section.classList.add('hidden');
        });

        if (selectedMod) {
            document.getElementById(`mod${selectedMod}_settings`).classList.remove('hidden');
        }
    }
</script>

<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="mods-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres des Mods</h2>

            <div class="mods-available">
                <h3 class="text-2xl font-semibold mb-4">Mods Disponibles</h3>
                <ul class="space-y-4">
                    <?php foreach ($modsData as $index => $mod): ?>
                        <?php if (!in_array($mod['file'], array_column($optionalMods, 'file'))): ?>
                            <li class="flex items-center space-x-4">
                                <form method="post" action="settings.php#mods-settings" class="flex items-center space-x-2" enctype="multipart/form-data">
                                    <input type="hidden" name="file" value="<?php echo htmlspecialchars($mod['file']); ?>">
                                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($mod['name']); ?>">
                                    <input type="hidden" name="description" value="<?php echo htmlspecialchars($mod['description']); ?>">
                                    <input type="hidden" name="icon" value="<?php echo htmlspecialchars($mod['icon']); ?>">
                                    <span><?php echo htmlspecialchars($mod['name']); ?></span>
                                    <button type="submit" name="add_optional" value="<?php echo $index; ?>" class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded-md">Ajouter</button>
                                </form>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="mods-optional mt-6">
                <h3 class="text-2xl font-semibold mb-4">Mods Optionnels</h3>
                <ul class="space-y-4">
                    <?php foreach ($optionalMods as $mod): ?>
                        <li class="border border-gray-700 p-4 rounded-lg">
                            <form method="post" action="settings.php#mods-settings" class="space-y-4" enctype="multipart/form-data">
                                <input type="hidden" name="mod_id" value="<?php echo $mod['id']; ?>">
                                <div>
                                    <label class="block text-gray-300">Fichier du mod</label>
                                    <input type="text" value="<?php echo htmlspecialchars($mod['file']); ?>" class="w-full p-2 bg-gray-800 border border-gray-600 rounded-md" readonly>
                                </div>
                                <div>
                                    <label class="block text-gray-300">Nom du Mod</label>
                                    <input type="text" name="optional_name" value="<?php echo htmlspecialchars($mod['name']); ?>" class="w-full p-2 bg-gray-800 border border-gray-600 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-gray-300">Description</label>
                                    <textarea name="optional_description" class="w-full p-2 bg-gray-800 border border-gray-600 rounded-md"><?php echo htmlspecialchars($mod['description']); ?></textarea>
                                </div>
                                <div>
                                    <label class="block text-gray-300">Image Actuelle</label>
                                    <img src="<?php echo htmlspecialchars($mod['icon']); ?>" alt="Image Actuelle" class="rounded-lg mr-4 h-16 w-16 object-cover">
                                </div>
                                <div>
                                    <label class="block text-gray-300">Nouvelle Image</label>
                                    <input type="file" name="optional_image" accept="image/jpeg,image/png,image/gif" class="w-full p-2 bg-gray-800 border border-gray-600 rounded-md">
                                </div>
                                <div>
                                    <label class="block text-gray-300">Recommandé</label>
                                    <input type="checkbox" name="optional_recommended" value="1" <?php echo $mod['recommended'] ? 'checked' : ''; ?>>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" name="update_optional" value="<?php echo $mod['id']; ?>" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded-md">Modifier</button>
                                    <button type="submit" name="delete_optional" value="<?php echo $mod['id']; ?>" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-md">Supprimer</button>
                                </div>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

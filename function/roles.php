<script>
    function showRoleSettings() {
        const selectedRole = document.getElementById('role_select').value;
        const roleSections = document.querySelectorAll('.role-settings');
        
        roleSections.forEach(section => {
            section.classList.add('hidden');
        });
        
        if (selectedRole) {
            document.getElementById(`role${selectedRole}_settings`).classList.remove('hidden');
        }
    }
</script>

<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="roles-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres des Rôles</h2>
            <form method="post" action="settings.php#roles-settings" enctype="multipart/form-data">
                <?php
                $sql = "SELECT * FROM roles";
                $stmt = $pdo->query($sql);

                $roleData = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $roleData[$row['id']] = $row;
                }
                ?>

                <label for="role_select" class="block text-sm font-medium text-gray-400 mb-2">Sélectionner un rôle :</label>
                <select id="role_select" name="role_select" class="form-select mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="showRoleSettings()">
                    <option value="">-- Sélectionner un rôle --</option>
                    <?php for ($i = 1; $i <= 8; $i++) { ?>
                        <option value="<?php echo $i; ?>">Rôle <?php echo $i; ?></option>
                    <?php } ?>
                </select>

                <?php
                for ($i = 1; $i <= 8; $i++) {
                    $roleName = "";
                    $backgroundUrl = "";
                    if (isset($roleData[$i])) {
                        $roleName = $roleData[$i]['role_name'];
                        $backgroundUrl = $roleData[$i]['role_background'];
                    }
                ?>
                    <div id="role<?php echo $i; ?>_settings" class="role-settings hidden mt-6">
                        <label for="role<?php echo $i; ?>_name" class="block text-sm font-medium text-gray-400 mb-2">Nom du rôle <?php echo $i; ?>:</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="role<?php echo $i; ?>_name" name="role<?php echo $i; ?>_name" value="<?php echo htmlspecialchars($roleName); ?>">

                        <?php if (!empty($backgroundUrl)): ?>
                            <div class="flex items-center mt-4 mb-2">
                                <img src="<?php echo $backgroundUrl; ?>" class="rounded-lg mr-4 h-16 w-16 object-cover" alt="Image de fond du rôle <?php echo $i; ?>">
                            </div>
                        <?php endif; ?>

                        <label for="new_role<?php echo $i; ?>_background" class="block text-sm font-medium text-gray-400 mt-2 mb-2">Choisir une nouvelle image de fond pour le rôle <?php echo $i; ?>:</label>
                        <input type="file" id="new_role<?php echo $i; ?>_background" name="role<?php echo $i; ?>_background" accept="image/*" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                <?php } ?>

                <button type="submit" name="submit_roles_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="roles-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres des Rôles</h2>
            <form method="post" action="settings#roles-settings">
                <?php
                $sql = "SELECT * FROM roles";
                $stmt = $pdo->query($sql);

                $roleData = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $roleData[$row['id']] = $row;
                }

                for ($i = 1; $i <= 8; $i++) {
                    $roleName = "";
                    $backgroundUrl = "";
                    if (isset($roleData[$i])) {
                        $roleName = $roleData[$i]['role_name'];
                        $backgroundUrl = $roleData[$i]['role_background'];
                    }
                    ?>
                    <div class="mb-6">
                        <label for="role<?php echo $i; ?>_name" class="block text-sm font-medium text-gray-400 mb-2">Nom du rôle <?php echo $i; ?>:</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="role<?php echo $i; ?>_name" name="role<?php echo $i; ?>_name" value="<?php echo htmlspecialchars($roleName); ?>">

                        <label for="role<?php echo $i; ?>_background" class="block text-sm font-medium text-gray-400 mt-4 mb-2">URL de l'image de fond du rôle <?php echo $i; ?>:</label>
                        <input type="text" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2 focus:ring-indigo-500 focus:border-indigo-500" id="role<?php echo $i; ?>_background" name="role<?php echo $i; ?>_background" value="<?php echo htmlspecialchars($backgroundUrl); ?>">
                    </div>
                <?php } ?>

                <button type="submit" name="submit_roles_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

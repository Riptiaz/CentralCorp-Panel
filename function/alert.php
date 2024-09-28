<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <form method="post" action="settings.php#alert-settings" onsubmit="return submitForm()">
                <div id="alert-settings">
                    <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Paramètres de l'Alerte</h2>
                    <div class="mb-6">
                        <label for="alert_msg" class="block text-sm font-medium text-gray-400 mb-2">Message de l'Alerte :</label>
                        <div id="editor-container" class="form-input mt-1 block w-full rounded-lg border-gray-600 bg-gray-700 text-gray-200 p-2"></div>
                        <input type="hidden" id="alert_msg" name="alert_msg" value="">
                    </div>
                    <div class="mb-6">
                        <label for="alert_activation" class="block text-sm font-medium text-gray-400 mb-2">Activer l'Alerte :</label>
                        <input type="checkbox" id="alert_activation" name="alert_activation" value="1" <?php if ($row["alert_activation"] == 1) echo "checked"; ?>>
                    </div>
                    <div class="mb-6">
                        <label for="alert_scroll" class="block text-sm font-medium text-gray-400 mb-2">Activer le défilement :</label>
                        <input type="checkbox" id="alert_scroll" name="alert_scroll" value="1" <?php if ($row["alert_scroll"] == 1) echo "checked"; ?>>
                    </div>
                </div>
                <button type="submit" name="submit_alert_settings" class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }], 
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ]
        }
    });

    quill.root.innerHTML = `<?php echo addslashes($row['alert_msg']); ?>`;

    function submitForm() {
        document.getElementById('alert_msg').value = quill.root.innerHTML;
        return true;
    }
</script>

<?php
// purge_logs.php

$logsFilePath = 'logs.json';

if (file_exists($logsFilePath)) {
   
    unlink($logsFilePath);
    // Ou vider son contenu si vous souhaitez conserver le fichier
    // file_put_contents($logsFilePath, '');

    
    header('Location: view.php');
    exit();
}
?>

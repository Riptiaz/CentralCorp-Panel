<?php

$logsFilePath = 'logs.json';

if (file_exists($logsFilePath)) {
   
    unlink($logsFilePath);

    
    header('Location: view.php');
    exit();
}
?>

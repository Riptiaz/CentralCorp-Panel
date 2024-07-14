<?php


function logAction($user, $action) {
    $logEntry = [
        'user' => $user,
        'timestamp' => date('Y-m-d H:i:s'),
        'action' => $action,
    ];

    $logsFilePath = './logs/logs.json';
    $logJson = json_encode($logEntry, JSON_UNESCAPED_UNICODE);

    
    if (!file_exists(dirname($logsFilePath))) {
        mkdir(dirname($logsFilePath), 0755, true);
    }

    
    file_put_contents($logsFilePath, $logJson . PHP_EOL, FILE_APPEND);
}
?>

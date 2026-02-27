<?php

function log_event($message) {
    $log_path = dirname(__DIR__) . '/logs/cms.log';

    if (!is_dir(dirname($log_path))) {
        mkdir(dirname($log_path), 0755, true);
    }

    file_put_contents($log_path, date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

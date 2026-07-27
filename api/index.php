<?php

$appStorage = '/tmp/storage';

$dirs = [
    "$appStorage/framework/views",
    "$appStorage/framework/cache/data",
    "$appStorage/framework/sessions",
    "$appStorage/logs"
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

putenv("VIEW_COMPILED_PATH=$appStorage/framework/views");
putenv("LOG_CHANNEL=stderr");

require __DIR__ . '/../public/index.php';

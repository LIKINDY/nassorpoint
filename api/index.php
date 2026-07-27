<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h1 style='color:red;'>CRITICAL ERROR: vendor/autoload.php is missing! Vercel did not run 'composer install'.</h1>";
    exit;
}

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

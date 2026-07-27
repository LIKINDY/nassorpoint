<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$iter = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($iter, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$strings = [];

foreach ($files as $file) {
    $content = file_get_contents($file[0]);
    // Match __("string") or __('string')
    if (preg_match_all("/__\(\s*['\"](.*?)['\"]\s*\)/", $content, $matches)) {
        foreach ($matches[1] as $match) {
            $strings[$match] = $match;
        }
    }
}

// Function to merge and save
function updateJsonLang($path, $newStrings, $isSwahili) {
    $current = [];
    if (file_exists($path)) {
        $current = json_decode(file_get_contents($path), true) ?: [];
    }
    
    foreach ($newStrings as $key) {
        if (!isset($current[$key])) {
            $current[$key] = $isSwahili ? "[SW] " . $key : $key;
        }
    }
    
    file_put_contents($path, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

updateJsonLang(__DIR__ . '/lang/en.json', array_keys($strings), false);
updateJsonLang(__DIR__ . '/lang/sw.json', array_keys($strings), true);

echo "Languages updated.\n";

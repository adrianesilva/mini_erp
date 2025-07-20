<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $path;

if (file_exists($file) && !is_dir($file)) {
    return false; 
}


require_once __DIR__ . '/index.php';
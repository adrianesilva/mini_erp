<?php
require 'controller/IndexController.php';

$uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');

$index = new IndexController();
$index->verificaUrl($uri);
?>
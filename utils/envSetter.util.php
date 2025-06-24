<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
// $dotenv->safeLoad();

function env($key, $default = null) {
    return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
}
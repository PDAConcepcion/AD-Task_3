<?php

require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();
// $dotenv->load();

$databases = [
    'pgHost'     => env(key: 'POSTGRE_HOST', default: 'host.docker.internal'),
    'pgPort'     => env('POSTGRE_PORT', '5112'),
    'pgDB'       => env('POSTGRE_DB', 'post_db'),
    'pgUser'     => env('POSTGRE_USER', 'user'),
    'pgPassword' => env('POSTGRE_PASSWORD', 'password'),
    'mongoHost'  => env('MONGO_HOST', 'host.docker.internal'),
    'mongoPort'  => env('MONGO_PORT', '27111'),
    'mongoDB'    => env('MONGO_DB', 'mong_db'),
];

function env($key, $default = null) {
    return getenv($key) ?: $default;
}
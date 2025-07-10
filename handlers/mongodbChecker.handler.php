<?php
// filepath: c:\xampp\htdocs\AD-Task-3\handlers\mongodbChecker.handler.php

require_once BASE_PATH . '/utils/dbEnvSetter.util.php';

$host = $databases['mongoHost'];
$port = $databases['mongoPort'];
$db   = $databases['mongoDB'];

try {
    $mongo = new MongoDB\Driver\Manager("mongodb://{$host}:{$port}");
    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);
    echo "✅ Connected to MongoDB successfully.<br>";
} catch (Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "<br>";
}
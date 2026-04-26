<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306", "root", "");
    $pdo->exec("CREATE DATABASE IF NOT EXISTS volunteer_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created successfully or already exists.\n";
} catch (PDOException $e) {
    echo "DB Connection Failed: " . $e->getMessage() . "\n";
    exit(1);
}

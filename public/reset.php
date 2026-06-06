<?php
/**
 * RESET PASSWORD ENTRY POINT
 */

// Database aur Controller ko include karein
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../controller/AuthController.php';

// DB Connection
try {
    $database = new Database();
    $pdo = $database->connect();
} catch (Exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// AuthController initialize karein aur resetPassword function call karein
$auth = new AuthController($pdo);
$auth->resetPassword(); 
?>
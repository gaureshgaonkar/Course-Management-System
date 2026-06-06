<?php
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../Controller/AttendanceController.php';

$db = new Database();
$pdo = $db->connect();

// Ab ye line error nahi degi kyunki Controller ab 1 hi argument maang raha hai
$controller = new AttendanceController($pdo);
$controller->handleRequest();
?>
<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Controller/AuthController.php";

$db = new Database();
$pdo = $db->connect();

$controller = new AuthController($pdo);
$controller->forgotPassword();

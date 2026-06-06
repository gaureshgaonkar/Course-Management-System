<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../Controller/AuthController.php";

// create DB object
$db = new Database();

// get PDO connection
$pdo = $db->connect();

// pass to controller
$auth = new AuthController($pdo);
$auth->register();
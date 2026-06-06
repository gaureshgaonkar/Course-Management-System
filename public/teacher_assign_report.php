<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Controller/TeacherReportController.php';

$db = new Database();
$pdo = $db->connect();

$controller = new TeacherReportController($pdo);
$controller->index();
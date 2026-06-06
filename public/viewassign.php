<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../Model/AssignmentReportModel.php'; 
require_once __DIR__ . '/../Controller/AssignmentReportController.php';

$dbObj = new Database();
$pdo = $dbObj->connect();
$controller = new CourseController($pdo);
$controller->handleRequest();
<?php
require_once "../controller/coursecontroller.php";

$controller = new CourseController();

$action = $_GET['action'] ?? 'index';

if ($action == "form") {
    $controller->form($_GET['courseid'] ?? null);
} elseif ($action == "save") {
    $controller->save();
} elseif ($action == "delete") {
    $controller->delete($_GET['courseid']);
} else {
    $controller->index();
}
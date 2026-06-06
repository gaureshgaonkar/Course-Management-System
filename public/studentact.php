<?php
require_once "../controller/studentcontroller.php";

$controller = new StudentController();

$action = $_GET['action'] ?? 'index';

if ($action == "form") {
    $controller->form($_GET['id'] ?? null);
} elseif ($action == "save") {
    $controller->save();
} elseif ($action == "delete") {
    $controller->delete($_GET['id']);
} else {
    $controller->index();
}
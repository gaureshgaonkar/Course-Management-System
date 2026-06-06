<?php
require_once "../controller/TeacherController.php";
$controller = new TeacherController();

$action = $_GET['action'] ?? 'index';

if ($action == "form") {
    $controller->form($_GET['id'] ?? null);
} elseif ($action == "save"){
    $controller->save();
} elseif ($action == "delete"){
    $controller->delete($_GET['id']);
}else {
    $controller->index();
}
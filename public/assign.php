<?php /*
require '../config/database.php';
require '../model/assign_course.php';
require '../model/assign_student.php';
require '../model/assign_teacher.php';
require '../controller/CourseAssignController.php';

$db = new Database();
$conn = $db->connect();

$controller = new CourseAssignController($conn);

$action = $_GET['action'] ?? 'create';

switch($action) {
    case 'create':
        $controller->create();
        break;
    case 'getStudentsByClass':
        $controller->getStudentsByClass();
        break;
    case 'store':
        $controller->store();
        break;
}*/
// 1. Include your Database class file
require_once '../config/Database.php'; // Adjust path if needed

// 2. Include Model and Controller
require_once '../Model/assign.php'; 
require_once '../Controller/assign_controller.php';

// 3. Instantiate the Database and get the PDO connection
$dbObj = new Database();
$pdo = $dbObj->connect(); // This creates the actual connection variable

// 4. Pass the $pdo connection to the Controller
$controller = new CourseController($pdo);
$controller->handleRequest(); // Runs 'default' case -> shows Form$controller->handleRequest();
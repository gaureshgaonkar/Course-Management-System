<?php
require_once __DIR__ . '/../Model/AssignmentReportModel.php';

class CourseController {
    private $model;
    public function __construct($pdo) { $this->model = new CourseModel($pdo); }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'default';

        switch ($action) {
            case 'filter':
                echo json_encode($this->model->getAssignedStudentsByCourse($_GET['course_id']));
                exit;

            case 'get_unassigned':
                echo json_encode($this->model->getUnassignedStudents($_GET['course_id']));
                exit;

            case 'quick_add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $courseId = $_POST['course_id'];
                    $studentIds = json_decode($_POST['student_ids']);
                    $res = $this->model->quickAddStudents($courseId, $studentIds);
                    echo json_encode(['success' => $res]);
                    exit;
                }
                break;

            case 'delete':
                $res = $this->model->deleteAssignment($_GET['course_id'], $_GET['student_id']);
                echo json_encode(['success' => $res]);
                exit;

            default:
                $courses = $this->model->getAllCourses();
                include __DIR__ . '/../view/assign/view_assignments.php';
                break;
        }
    }
}
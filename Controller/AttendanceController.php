<?php
require_once __DIR__ . '/../Model/AttendanceModel.php';

class AttendanceController {
    private $model;

    public function __construct($pdo) {
        $this->model = new AttendanceModel($pdo);
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';

        // AJAX: Load Students
        if ($action === 'fetch' && isset($_GET['course_id'])) {
            $students = $this->model->getStudentsByCourse($_GET['course_id']);
            header('Content-Type: application/json');
            echo json_encode($students);
            exit();
        }

        // POST: Save Only Selected
        if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = $_POST['course_id'];
            $date = $_POST['att_date'];
            $studentIds = $_POST['student_ids'] ?? [];

            if ($this->model->saveAttendance($courseId, $date, $studentIds)) {
                header("Location: attendance.php?status=success");
                exit();
            }
        }

        $courses = $this->model->getCourses();
        include __DIR__ . '/../view/attendance/mark_attendance.php';
    }
}
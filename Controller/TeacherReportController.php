<?php
require_once __DIR__ . '/../Model/TeacherAssignmentModel.php';

class TeacherReportController {
    private $model;

    public function __construct($pdo) {
        $this->model = new TeacherAssignmentModel($pdo);
    }

    public function index() {
        // AJAX: Filter list
        if (isset($_GET['action']) && $_GET['action'] == 'filter') {
            $data = $this->model->getCoursesByTeacher($_GET['teacher_id']);
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }

        // AJAX: Delete assignment
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $res = $this->model->deleteTeacherAssignment($_GET['course_id'], $_GET['teacher_id']);
            header('Content-Type: application/json');
            echo json_encode(['success' => $res]);
            exit;
        }

        $teachers = $this->model->getTeachersList();
        include __DIR__ . '/../view/assign/view_teacher_assigns.php';
    }
}
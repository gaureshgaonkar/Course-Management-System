<?php
require_once __DIR__ . '/../Model/AttendanceReportModel.php';

class AttendanceReportController {
    private $model;
    public function __construct($pdo) { $this->model = new AttendanceReportModel($pdo); }

    public function index() {
        $action = $_GET['action'] ?? 'index';

        if ($action == 'filter') {
            $data = $this->model->getRangeReport($_GET['course_id'], $_GET['from_date'], $_GET['to_date']);
            echo json_encode($data); exit;
        }

        if ($action == 'date_view') {
            $data = $this->model->getDateWiseAttendance($_GET['course_id'], $_GET['date']);
            echo json_encode($data); exit;
        }

        $courses = $this->model->getCoursesList();
        include __DIR__ . '/../view/attendance/view_attendance.php';
    }
}
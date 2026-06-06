<?php
require_once 'assign.php';

class CourseController {
    private $model;

    public function __construct($pdo) {
        $this->model = new CourseModel($pdo);
    }

    /**
     * This method should ONLY show the report.
     * Call this from public/viewaction.php
     */
public function showAssignments() {
    $report = $this->model->getFullAssignmentList();
    
    // Load the view file you just shared
    include __DIR__ . '../view/assign/assign.php';
    
    // STOP everything here so the Form doesn't load below it
    exit(); 
}

    /**
     * This method handles the Form and the Save logic.
     * Call this from public/assign.php
     */
    public function handleRequest() {
        $action = $_GET['action'] ?? 'index.php';

        switch ($action) {
            case 'save':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $course = $_POST['course_id'];
                    $teacher = $_POST['teacher_id'];
                    // Matches the 'name="student_ids[]"' in your View
                    $students = $_POST['student_ids'] ?? []; 
                    
                    if ($this->model->saveAssignments($course, $teacher, $students)) {
                        // Redirect to your separate view page
                        header("Location: assign.php?status=success");
                        exit(); 
                    } else {
                        echo "Error saving data.";
                    }
                }
                break;

            case 'view':
                // Optional: handle view inside the main router too
                $this->showAssignments();
                break;

            default:
                // This code ONLY runs for the main Form page
                $courses = $this->model->getAllCourses();
                $teachers = $this->model->getAllTeachers();
                $allStudents = $this->model->getAllStudents();
                
                include __DIR__ . '/../view/assign/assign.php';
                break;
        }
    }
}
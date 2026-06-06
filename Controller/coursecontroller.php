<?php
require_once "../config/database.php";
require_once "../model/course.php";

class CourseController {

    private $course;

    public function __construct() {
        $db = (new Database())->connect();
        $this->course = new Course($db);
    }

    public function index() {
        $courses = $this->course->getAll();
        require "../view/course/index.php";
    }

    public function form($courseid = null) {
        $course = $courseid ? $this->course->getById($courseid) : null;
        require "../view/course/form.php";
    }

    public function save() {
        if (!empty($_POST['course_id'])) {
    
            $this->course->update([
                $_POST['coursename'],
                $_POST['course_id']
            ]);
        } else {
    
            $this->course->create([
                $_POST['coursename'],
            ]);
        }

        header("Location: courseact.php");
        exit;
    }

    public function delete($courseid) {
        $this->course->delete($courseid);
        header("Location: courseact.php");
        exit;
    }
}

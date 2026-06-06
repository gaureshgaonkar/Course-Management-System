<?php
require_once "../config/database.php";
require_once "../model/student.php";

class StudentController {

    private $student;

    public function __construct() {
        $db = (new Database())->connect();
        $this->student = new Student($db);
    }

    public function index() {
        $students = $this->student->getAll();
        require "../view/student/index.php";
    }

    public function form($id = null) {
        $student = $id ? $this->student->getById($id) : null;
        require "../view/student/form.php";
    }

    public function save() {
        if (!empty($_POST['student_id'])) {
            $this->student->update([
                $_POST['name'], $_POST['rollno'], $_POST['email'],
                $_POST['mobileno'],$_POST['class'], $_POST['student_id']
            ]);
        } else {
            $this->student->create([
                $_POST['name'], $_POST['rollno'], $_POST['email'],$_POST['mobileno'],
                $_POST['class']
            ]);
        }
        header("Location: studentact.php");
    }

    public function delete($id) {
        $this->student->delete($id);
        header("Location: studentact.php");
    }
}

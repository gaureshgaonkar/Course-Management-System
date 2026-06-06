<?php
require_once "../config/database.php";
require_once "../model/teacher.php";

class teacherController {
    private $teacher;
    public function __construct() {
        $db = (new database())->connect();
        $this->teacher = new teacher($db);
    }

    public function index() {
        $teachers = $this->teacher->getAll();
        require "../view/teacher/index.php";
    }

    public function form($id = null) {
        $teacher = $id ? $this->teacher->getById($id) : null;
        require "../view/teacher/form.php";
    }
    public function save() {
        if(!empty($_POST['id'])) {
            $this->teacher->update([
                $_POST['name'],$_POST['email'],
                $_POST['mobileno'],$_POST['id']
            ]);
        } else {
            $this->teacher->create([
                $_POST['name'],$_POST['email'],
                $_POST['mobileno']
            ]);
        }
        header("Location: ../public/teacheract.php");
    }

    public function delete($id) {
        $this->teacher->delete($id);
        header("Location: ../public/teacheract.php");
    }
}
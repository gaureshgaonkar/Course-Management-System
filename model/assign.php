<?php
class CourseModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Get all courses for the dropdown
    public function getAllCourses() {
        return $this->db->query("SELECT * FROM Course")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all teachers for the dropdown
    public function getAllTeachers() {
        return $this->db->query("SELECT * FROM Teachers")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllStudents() {
    // Fetches every student to populate the "List of Student" box
    return $this->db->query("SELECT student_id, name, rollno FROM Students")->fetchAll(PDO::FETCH_ASSOC);
}

    // AJAX FETCH: Get students filtering by the 'class' attribute
    public function getStudentsByClass($className) {
        $stmt = $this->db->prepare("SELECT student_id, name, rollno FROM Students WHERE class = ?");
        $stmt->execute([$className]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getFullAssignmentList() {
    // We use JOIN to get names from Course and Students tables
    $sql = "SELECT c.coursename, s.name as student_name, s.rollno, s.class 
            FROM course_student cs
            JOIN Course c ON cs.course_id = c.course_id
            JOIN Students s ON cs.student_id = s.student_id
            ORDER BY c.coursename ASC, s.name ASC";
            
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SAVE: Insert into two different tables using a Transaction
   public function saveAssignments($courseId, $teacherId, $studentIds) {
    try {
        $this->db->beginTransaction();

        // 1. Teacher save/update logic
        $stT = $this->db->prepare("INSERT INTO course_teacher (course_id, teacher_id) 
                                   VALUES (?, ?) 
                                   ON DUPLICATE KEY UPDATE teacher_id = VALUES(teacher_id)");
        $stT->execute([$courseId, $teacherId]);

        // 2. Student save logic - PEHLE PURANE RECORDS DELETE KAREIN
        $delS = $this->db->prepare("DELETE FROM course_student WHERE course_id = ?");
        $delS->execute([$courseId]);

        // 3. AB NAYE STUDENTS INSERT KAREIN
        if (!empty($studentIds)) {
            $stS = $this->db->prepare("INSERT INTO course_student (course_id, student_id) VALUES (?, ?)");
            foreach ($studentIds as $s_id) {
                $stS->execute([$courseId, $s_id]);
            }
        }

        $this->db->commit();
        return true;
    } catch (PDOException $e) {
        $this->db->rollBack();
        die("SQL ERROR: " . $e->getMessage()); 
    }
}
}

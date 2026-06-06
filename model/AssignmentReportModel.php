<?php
class CourseModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function getAllCourses() {
        return $this->db->query("SELECT * FROM Course")->fetchAll(PDO::FETCH_ASSOC);
    }

    // NAYA: Jo students is course mein pehle se nahi hain unhe dhoondna
    public function getUnassignedStudents($courseId) {
        $sql = "SELECT student_id, name, rollno FROM Students 
                WHERE student_id NOT IN (SELECT student_id FROM course_student WHERE course_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // NAYA: Selected students ko course mein insert karna
    public function quickAddStudents($courseId, $studentIds) {
        $stmt = $this->db->prepare("INSERT INTO course_student (course_id, student_id) VALUES (?, ?)");
        foreach ($studentIds as $id) {
            $stmt->execute([$courseId, $id]);
        }
        return true;
    }

    public function getAssignedStudentsByCourse($courseId) {
        $stmt = $this->db->prepare("SELECT c.coursename, s.student_id, s.name as student_name, s.rollno, s.class 
                                    FROM course_student cs
                                    JOIN Course c ON cs.course_id = c.course_id
                                    JOIN Students s ON cs.student_id = s.student_id
                                    WHERE cs.course_id = ?");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAssignment($courseId, $studentId) {
        $stmt = $this->db->prepare("DELETE FROM course_student WHERE course_id = ? AND student_id = ?");
        return $stmt->execute([$courseId, $studentId]);
    }
}
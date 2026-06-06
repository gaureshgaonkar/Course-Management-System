<?php
class TeacherAssignmentModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Dropdown ke liye teachers laane ke liye
    public function getTeachersList() {
        return $this->db->query("SELECT teacher_id, name FROM teachers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Teacher assignments aur count laane ke liye (JOIN query)
    public function getCoursesByTeacher($teacherId) {
        $sql = "SELECT ct.course_id, c.coursename, t.name as teacher_name
                FROM course_teacher ct
                JOIN course c ON ct.course_id = c.course_id
                JOIN teachers t ON ct.teacher_id = t.teacher_id
                WHERE ct.teacher_id = ?
                ORDER BY c.coursename ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([(int)$teacherId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assignment delete karne ke liye
    public function deleteTeacherAssignment($course_id, $teacher_id) {
        $sql = "DELETE FROM course_teacher WHERE course_id = ? AND teacher_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([(int)$course_id, (int)$teacher_id]);
    }
}
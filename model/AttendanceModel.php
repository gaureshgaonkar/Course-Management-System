<?php
class AttendanceModel {
    private $db;

    public function __construct($pdo) { 
        $this->db = $pdo; 
    }

    public function getCourses() {
        return $this->db->query("SELECT * FROM Course ORDER BY coursename ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentsByCourse($courseId) {
        $sql = "SELECT s.student_id, s.name, s.rollno 
                FROM course_student cs
                JOIN Students s ON cs.student_id = s.student_id
                WHERE cs.course_id = ? 
                ORDER BY s.rollno ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveAttendance($courseId, $date, $studentIds) {
        try {
            $this->db->beginTransaction();

            // 1. Pehle us din ki purani entries delete karo (Cleanup)
            $del = $this->db->prepare("DELETE FROM attendance WHERE course_id = ? AND attendance_date = ?");
            $del->execute([$courseId, $date]);

            // 2. Sirf 'Present' students ko insert karo (No status column needed)
            if (!empty($studentIds)) {
                $ins = $this->db->prepare("INSERT INTO attendance (student_id, course_id, attendance_date) VALUES (?, ?, ?)");
                
                foreach ($studentIds as $id) {
                    $ins->execute([$id, $courseId, $date]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            die("SQL Error: " . $e->getMessage()); // Error debugging ke liye
        }
    }
}
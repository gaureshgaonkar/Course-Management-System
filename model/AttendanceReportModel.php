<?php
class AttendanceReportModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function getCoursesList() {
        return $this->db->query("SELECT course_id, coursename FROM Course ORDER BY coursename ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // FEATURE 1: Overall Performance (Range)
    public function getRangeReport($courseId, $from, $to) {
        $sql = "SELECT s.student_id, s.name as student_name, s.rollno,
                (SELECT COUNT(DISTINCT attendance_date) FROM attendance WHERE course_id = ?) as total_working_days,
                COUNT(a.attendance_id) as attended_days
                FROM Students s
                JOIN course_student cs ON s.student_id = cs.student_id
                LEFT JOIN attendance a ON s.student_id = a.student_id 
                     AND a.course_id = ? 
                     AND a.attendance_date BETWEEN ? AND ?
                WHERE cs.course_id = ?
                GROUP BY s.student_id ORDER BY s.rollno ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$courseId, $courseId, $from, $to, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // FEATURE 2: Particular Date List
    public function getDateWiseAttendance($courseId, $date) {
        $sql = "SELECT s.name, s.rollno, 'Present' as status 
                FROM attendance a
                JOIN Students s ON a.student_id = s.student_id
                WHERE a.course_id = ? AND a.attendance_date = ?
                ORDER BY s.rollno ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$courseId, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
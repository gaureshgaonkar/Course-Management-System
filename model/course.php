<?php
class Course {
    private $conn;
    private $table = "course";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM $this->table");
    }

    public function getById($courseid) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM $this->table WHERE course_id = ?"
        );
        $stmt->execute([$courseid]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO $this->table (coursename) VALUES (?)"
        );
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->conn->prepare(
            "UPDATE $this->table 
             SET coursename = ? 
             WHERE course_id = ?"
        );
        return $stmt->execute($data);
    }

    public function delete($courseid) {
        $stmt = $this->conn->prepare(
            "DELETE FROM $this->table WHERE course_id = ?"
        );
        return $stmt->execute([$courseid]);
    }
}
?>

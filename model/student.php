<?php
class Student {
    private $conn;
    private $table = "students";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM $this->table WHERE student_id=?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO $this->table (name,rollno,email,mobileno,class) VALUES (?,?,?,?,?)"
        );
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->conn->prepare(
            "UPDATE $this->table SET name=?, rollno=?, email=?,  mobileno=?, class=?  WHERE student_id=?"
        );
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM $this->table WHERE student_id=?"
        );
        return $stmt->execute([$id]);
    }
}

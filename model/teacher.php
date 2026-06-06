<?php 
class teacher {
    private $conn;
    private $table="teachers";
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM $this->table");
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE teacher_id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (name,email,mobileno) VALUES (?,?,?)");
        return $stmt->execute($data);
    }

   public function update($data) {
        $stmt = $this->conn->prepare(
            "UPDATE $this->table SET name=?, email=?,  mobileno=? WHERE teacher_id=?"
        );
        return $stmt->execute($data);
    }
      
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE teacher_id=?");
        return $stmt->execute([$id]);
    }
}
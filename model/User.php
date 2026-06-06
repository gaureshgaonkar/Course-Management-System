<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

  
    public function create($name, $email, $password) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name,email,password) VALUES (?,?,?)"
        );

        return $stmt->execute([$name, $email, $hash]);
    }

    
    public function findByEmail($email) {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function saveResetToken($email,$token){

        $stmt = $this->pdo->prepare(
            "UPDATE users SET reset_token=? WHERE email=?"
        );

        return $stmt->execute([$token,$email]);
    }

   
    public function findByToken($token){

        $stmt = $this->pdo->prepare(
            "SELECT * FROM users WHERE reset_token=?"
        );

        $stmt->execute([$token]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updatePasswordByToken($token,$password){

      
        $hash = password_hash($password,PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            "UPDATE users 
             SET password=?, reset_token=NULL 
             WHERE reset_token=?"
        );

        return $stmt->execute([$hash,$token]);
    }
}

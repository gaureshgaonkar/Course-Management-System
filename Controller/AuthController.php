<?php
session_start();
require_once "../config/database.php";
require_once "../model/User.php";

class AuthController {

    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    // 1. REGISTER
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name     = $_POST['name'];
            $email    = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->create($name, $email, $password)) {
                header("Location: ../public/login.php");
                exit;
            }
        }
        require "../view/authentication/register.php";
    }

    // 2. LOGIN
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email    = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['name'];
                header("Location: ../view/authentication/dashboard.php");
                exit;
            } else {
                $error = "Invalid credentials";
            }
        }
        require "../view/authentication/login.php";
    }

    // 3. LOGOUT
    public function logout() {
        session_destroy();
        header("Location: ../public/login.php");
        exit;
    }

    // 4. FORGOT PASSWORD (Reset Link & Email Option)
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $_POST['email'];
            $user = $this->userModel->findByEmail($email);

            if ($user) {
                // Secure Token Generation
                $token = bin2hex(random_bytes(32));
                $this->userModel->saveResetToken($email, $token);

                // Option: Show Link on screen (Shareable)
                // Note: Change 'localhost' to your actual domain if hosted
                $resetLink = "http://localhost:8080/mproject/public/reset.php?token=$token";
                
                $msg = "Success! Recovery link is ready: <br> 
                        <a href='$resetLink' class='btn btn-sm btn-primary mt-2'>Reset My Password</a>";
                
                // Tip: In production, use PHPMailer here to send $resetLink to $email
            } else {
                $error = "This email is not registered in our system.";
            }
        }
        require "../view/authentication/forgot.php";
    }

    // 5. RESET PASSWORD (Final Step)
    public function resetPassword()
{
    $token = $_GET['token'] ?? null;

    if(!$token){
        die("Error: No token found. Please use the link from your email.");
    }

    $user = $this->userModel->findByToken($token);

    if(!$user){
        die("Error: This reset link is invalid or expired.");
    }

    // Agar token sahi hai, toh view load hoga
    require "../view/authentication/reset.php"; 
}
}
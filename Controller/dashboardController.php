<?php
/**
 * DASHBOARD CONTROLLER
 * Kaam: User session check karna aur Dashboard view load karna.
 */

class DashboardController {

    public function index() {
        

        // 3. Dashboard View Load karein
        // Path check kar lein: view/authentication/dashboard.php
        $viewPath = __DIR__ . '/../view/authentication/dashboard.php';

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            die("Error: Dashboard view file not found at " . $viewPath);
        }
    }
}
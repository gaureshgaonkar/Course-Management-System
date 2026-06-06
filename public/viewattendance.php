<?php
/**
 * VIEW ATTENDANCE (ANALYTICS & DATE-WISE) - ENTRY POINT
 * Is file ko browser mein chalayein: http://localhost/project/public/viewattendance.php
 */

// 1. Database connection aur Controller files ko include karein
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../Controller/AttendanceReportController.php';

// 2. Database connect karein
try {
    $db = new Database();
    $pdo = $db->connect();
} catch (PDOException $e) {
    // Agar database connect nahi hua toh error dikhayega
    die("Connection failed: " . $e->getMessage());
}

/**
 * 3. Controller Initialize
 * Humne Controller fix kiya hai taaki wo AJAX aur Normal Load dono ko handle kare.
 */
$controller = new AttendanceReportController($pdo);

/**
 * 4. Action Handling
 * Ye function niche diye gaye requests ko handle karega:
 * - Normal Page Load (Jab aap link open karte hain)
 * - action=filter (Overall range report ke liye)
 * - action=date_view (Particular date ke liye)
 */
$controller->index();

?>
<?php
/* database.php - connects to MySQL. Every page that needs the database starts with:
       require("database.php");
   Same idea as your class database.php: it gives you the connection object $con. */

$host = "localhost";
$user = "root";            // XAMPP default
$pass = "";                // XAMPP default is empty
$db   = "tbl_wbdv212";      // your database in phpMyAdmin

$con = new mysqli($host, $user, $pass, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$con->set_charset("utf8mb4");

/* Helper 1: save a message, then go to another page. The page shows it as a notification in the lower left
   (includes/toast.php). This replaces your class pattern of alert() + window.location.href.
   $type is 'success', 'error' or 'info'. */
function flash_redirect($type, $title, $msg, $page) {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $_SESSION['flash'] = ['type' => $type, 'title' => $title, 'msg' => $msg];
    header("Location: " . $page);
    exit;
}

/* Helper 2: write one row to tbl_login_logs (success = 1 or 0). $user_id can be null when the email does not exist. */
function write_login_log($con, $user_id, $email, $success) {
    $ip  = $_SERVER['REMOTE_ADDR'] ?? '';
    $log = $con->prepare("INSERT INTO tbl_login_logs (user_id, email_tried, success, ip_address) VALUES (?, ?, ?, ?)");
    $log->bind_param("isis", $user_id, $email, $success, $ip);
    $log->execute();
}
?>
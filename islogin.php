<?php
/* islogin.php - checks the login form (same job as your class islogin.php).
   login.php (the form) sends the email + password here with method="POST". */
session_start();
require("database.php");

// Opened this file directly instead of submitting the form? Send them back.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

/* 1. Find the user by email.
      Class version:  "SELECT * FROM tbl_students WHERE username = '$username' AND password = '$password'"
      Here the "?" is a placeholder, so whatever is typed can never change the SQL (stops SQL injection).
      The password is NOT put in the query: we compare it after, with password_verify().
      stat = 'active' means the account is switched on ('inactive' = disabled, same soft-delete idea as your tbl_students). */
$query = $con->prepare("SELECT user_id, first_name, role, password_hash FROM tbl_users WHERE email = ? AND stat = 'active'");
$query->bind_param("s", $email);
$query->execute();
$user = $query->get_result()->fetch_assoc();      // one row, or nothing if the email does not exist

/* 2. Send each account type to its own landing page. */
$pages = [
    'customer' => 'account.php',            // client dashboard
    'staff'    => 'staff_dashboard.php',
    'admin'    => 'admin_dashboard.php'     // owner dashboard
];

/* 3. Right password?  (md5 in class; password_verify matches the password_hash() saved at registration) */
/* Check the password. New sign-ups are saved with password_hash() (starts with $2y$).
   Rows you insert by hand in phpMyAdmin with the MD5 function (like in class) also work. */
$stored   = $user['password_hash'] ?? '';
$password_ok = false;
if ($stored !== '') {
    if (strpos($stored, '$2y$') === 0) {
        $password_ok = password_verify($password, $stored);
    } else {
        $password_ok = hash_equals($stored, md5($password));   // md5 row
    }
}

if ($user && $password_ok) {
    $role = strtolower(trim((string)$user['role']));

    session_regenerate_id(true);                  // new session ID after login = safer
    $_SESSION['user_id']    = $user['user_id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['role']       = $role;

    $con->query("UPDATE tbl_users SET last_login_at = NOW() WHERE user_id = " . (int)$user['user_id']);
    write_login_log($con, $user['user_id'], $email, 1);

    $go = $pages[$role] ?? 'index.php';
    flash_redirect('success', 'Login Success', 'Welcome back, ' . $user['first_name'] . '!', $go);
}
else {
    $uid = $user['user_id'] ?? null;
    write_login_log($con, $uid, $email, 0);                 // failed attempts are logged too
    flash_redirect('error', 'Login Denied', 'Wrong email or password.', 'login.php');
}
?>
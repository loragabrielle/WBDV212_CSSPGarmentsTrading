<?php
/* login.php */
session_start();

// Already logged in? Skip the login page.
if (!empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }

$mode = 'login';
$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // TODO: DB query here
    //   1. SELECT user_id, first_name, role, password_hash, status FROM users WHERE email = ?  (prepared statement)
    //   2. if (!$user || !password_verify($password, $user['password_hash'])) { $loginError = 'Wrong email or password.'; }
    //   3. else: session_regenerate_id(true);
    //            $_SESSION['user_id'] = $user['user_id']; $_SESSION['first_name'] = $user['first_name']; $_SESSION['role'] = $user['role'];
    //            update last_login_at, insert a login_logs row, then redirect by role (admin/staff/customer)
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Log in | CSSP Garments Trading</title>
  <link rel="icon" href="./Assets/logo-light-text.png">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS Files/AboutUs_Style.css">
  <link rel="stylesheet" href="CSS Files/Account_Menu.css">
  <link rel="stylesheet" href="CSS Files/Auth_Style.css">
  <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('cssp-theme') || 'light');</script>
</head>
<body class="auth-page">
<?php $hideTicker = true; include 'header.php'; ?>
<?php include 'auth_layout.php'; ?>

<script src="JS Files/auth.js"></script>
<script src="JS Files/Nav_Script.js"></script> <!-- navbar: menus, hamburger, search, theme, currency -->
</body>
</html>
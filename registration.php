<?php
/* registration.php */
session_start();

if (!empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }

$mode = 'register';
$registerError = '';
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;                       // keeps what they typed if there is an error
    unset($old['password'], $old['confirm_password']);
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Sign up | CSSP Garments Trading</title>
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

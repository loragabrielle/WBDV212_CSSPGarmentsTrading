<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Keep staff and administrators in their own dashboard.
if (($_SESSION['role'] ?? '') === 'staff') {
    header('Location: staff_dashboard.php');
    exit;
}
if (($_SESSION['role'] ?? '') === 'admin') {
    header('Location: admin_dashboard.php');
    exit;
}

require 'includes/guard.php';
require_role(['customer']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Account | CSSP Garments Trading</title>
</head>
<body>
  <!-- placeholder: replace with your real dashboard -->
  <h1>My Account</h1>
  <p>Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)</p>
  <a href="index.php">Back to shop</a> | <a href="logout.php">Logout</a>
  <?php include 'includes/toast.php'; ?>
</body>
</html>
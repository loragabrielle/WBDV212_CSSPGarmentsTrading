<?php
/* includes/guard.php - locks a page to certain roles.
   Put this at the VERY TOP of a dashboard page (before any HTML):
       <?php require 'includes/guard.php'; require_role(['admin']); ?>
   Not logged in  -> sent to login.php
   Wrong role     -> sent to index.php (a client cannot open the admin page by typing its URL) */
function require_role(array $roles) {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }
    if (!in_array($_SESSION['role'] ?? '', $roles, true)) {
        if (($_SESSION['role'] ?? '') === 'staff') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'title' => 'Access denied',
                'msg' => 'Your staff account cannot open that page.'
            ];
            header('Location: admin_dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit;
    }
}
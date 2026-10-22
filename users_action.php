<?php
session_start();
require 'database.php';
require 'includes/guard.php';
require_role(['admin']);
require 'includes/admin_helpers.php';
/* Creates user accounts and applies administrator account changes. */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash_redirect('error', 'Invalid request', 'Use the user management page.', 'users_security.php');
}
admin_require_csrf();
$action = $_POST['action'] ?? '';
$userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

try {
    if ($action === 'create_user') {
        $firstName = admin_post_text('first_name', 100);
        $lastName = admin_post_text('last_name', 100);
        $email = mb_strtolower(trim((string)($_POST['email'] ?? '')));
        $birthday = trim((string)($_POST['birthday'] ?? ''));
        $gender = $_POST['gender'] ?? '';
        $phone = admin_post_text('phone', 50);
        $address = admin_post_text('address', 1000);
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';
        $birthDate = DateTime::createFromFormat('Y-m-d', $birthday);
        $validBirthDate = $birthDate && $birthDate->format('Y-m-d') === $birthday;
        if ($validBirthDate && $birthDate > new DateTime('today')) $validBirthDate = false;
        if ($firstName === '' || $lastName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            !$validBirthDate || !in_array($gender, ['Male', 'Female', 'Prefer not to say'], true) ||
            $phone === '' || $address === '' || !in_array($role, ['admin', 'staff', 'customer'], true) ||
            !is_string($password) || strlen($password) < 8) {
            throw new RuntimeException('Complete all account details and use a password of at least eight characters.');
        }
        $check = $con->prepare('SELECT user_id FROM tbl_users WHERE email = ?');
        $check->bind_param('s', $email);
        $check->execute();
        $exists = $check->get_result()->fetch_assoc();
        $check->close();
        if ($exists) throw new RuntimeException('That email address is already registered.');
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $active = 'active';
        $statement = $con->prepare('INSERT INTO tbl_users (first_name, last_name, birthday, gender, phone, email, address, password_hash, role, stat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->bind_param('ssssssssss', $firstName, $lastName, $birthday, $gender, $phone, $email, $address, $hash, $role, $active);
        $statement->execute();
        $statement->close();
        flash_redirect('success', 'User created', 'The account is ready to use.', 'users_security.php?tab=users');
    }

    if (!$userId) throw new RuntimeException('Choose a valid user account.');
    if ($action === 'reset_password') {
        $password = $_POST['password'] ?? '';
        if (!is_string($password) || strlen($password) < 8) throw new RuntimeException('The new password must have at least eight characters.');
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = $con->prepare('UPDATE tbl_users SET password_hash = ? WHERE user_id = ?');
        $statement->bind_param('si', $hash, $userId);
        $statement->execute();
        $statement->close();
        flash_redirect('success', 'Password reset', 'The new password was saved.', 'users_security.php?tab=users');
    }

    if ($userId === (int)$_SESSION['user_id']) throw new RuntimeException('You cannot change your own account from this page.');
    if ($action === 'change_role') {
        $role = $_POST['role'] ?? '';
        if (!in_array($role, ['admin', 'staff', 'customer'], true)) throw new RuntimeException('Choose a valid role.');
        $statement = $con->prepare('UPDATE tbl_users SET role = ? WHERE user_id = ?');
        $statement->bind_param('si', $role, $userId);
        $statement->execute();
        $statement->close();
        flash_redirect('success', 'Role updated', 'The user role was changed.', 'users_security.php?tab=users');
    }
    if ($action === 'toggle_status') {
        $statement = $con->prepare("UPDATE tbl_users SET stat = IF(stat = 'active', 'inactive', 'active') WHERE user_id = ?");
        $statement->bind_param('i', $userId);
        $statement->execute();
        $statement->close();
        flash_redirect('success', 'Account status changed', 'The account was activated or deactivated.', 'users_security.php?tab=users');
    }
    throw new RuntimeException('Choose a valid account action.');
} catch (Throwable $error) {
    error_log('User action failed: ' . $error->getMessage());
    flash_redirect('error', 'User update failed', $error instanceof RuntimeException ? $error->getMessage() : 'The account could not be updated.', 'users_security.php?tab=users');
}

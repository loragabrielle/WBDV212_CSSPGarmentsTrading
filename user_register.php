<?php
/* saves the sign-up form into the database method="POST". */
session_start();
require("database.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registration.php");
    exit;
}

/* get values from the form (the names match the name="" of each input) */
$fname    = trim($_POST['first_name'] ?? '');
$lname    = trim($_POST['last_name'] ?? '');
$bday     = $_POST['birthday'] ?? '';
$gender   = $_POST['gender'] ?? '';
$contact  = trim($_POST['phone'] ?? '');
$email    = strtolower(trim($_POST['email'] ?? ''));
$address  = trim($_POST['address'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

/* if error notif */
function reg_fail($title, $msg) {
    $_SESSION['old'] = array_diff_key($_POST, ['password' => 1, 'confirm_password' => 1]);
    flash_redirect('error', $title, $msg, 'registration.php');
}

/* check again in server */
if ($fname === '' || $lname === '' || $contact === '' || $address === '' || $gender === '') {
    reg_fail('Missing Information', 'Please fill in all fields.');
}
if (!preg_match('/^[\p{L} ]+$/u', $fname)) { reg_fail('Letters Only', 'First name can only include letters and spaces'); }
if (!preg_match('/^[\p{L} ]+$/u', $lname)) { reg_fail('Letters Only', 'Last name can only include letters and spaces'); }
if (!in_array($gender, ['Male', 'Female', 'Prefer not to say'], true)) {
    reg_fail('Invalid Gender', 'Please select a gender from the list.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    reg_fail('Invalid Email', 'Please enter a valid email address.');
}
$date = DateTime::createFromFormat('Y-m-d', $bday);
if (!$date || $date->diff(new DateTime())->y < 18) {
    reg_fail('Age Requirement', 'You must be 18 years or older to register.');
}
if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
    reg_fail('Weak Password', 'Use at least 8 characters with letters and numbers.');
}
if ($password !== $confirm) {
    reg_fail('Passwords Do Not Match', 'Please type the same password in both boxes.');
}

/* is the email already used? */
$check = $con->prepare("SELECT user_id FROM tbl_users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    flash_redirect('info', 'Email Already Registered', 'Please log in instead.', 'login.php');
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$query = $con->prepare("INSERT INTO tbl_users (first_name, last_name, birthday, gender, phone, email, address, password_hash)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$query->bind_param("ssssssss", $fname, $lname, $bday, $gender, $contact, $email, $address, $hash);
$exec = $query->execute();

if ($exec) {
    // No auto-login: after signing up the user must log in (security best practice).
    unset($_SESSION['old']);
    flash_redirect('success', 'Account Created', 'Your account is ready. Please log in.', 'login.php');
}
else {
    reg_fail('Sign Up Failed', 'Something went wrong while creating your account. Please try again.');
}
?>

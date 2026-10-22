<?php
/* logout.php - ends the session and sends the user back to the login page */
session_start();
$_SESSION = [];                                        // 1. empty the session data
if (ini_get('session.use_cookies')) {                  // 2. expire the session cookie
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();                                     // 3. destroy the session on the server

session_start();                                       // 4. a fresh, empty session just to carry the message
$_SESSION['flash'] = ['type' => 'info', 'title' => 'Logged Out', 'msg' => 'You have been logged out.'];
header('Location: login.php');
exit;
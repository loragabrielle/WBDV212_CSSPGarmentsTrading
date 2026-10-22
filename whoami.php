<?php
/* whoami.php - TEMPORARY check page. Open it while logged in, read the result, then DELETE this file. */
session_start();
require 'database.php';

$id = (int)($_SESSION['user_id'] ?? 0);
$dbRole = '(no row found)'; $dbStat = ''; $dbEmail = '';
if ($id) {
    $q = $con->prepare("SELECT email, role, stat FROM tbl_users WHERE user_id = ?");
    $q->bind_param("i", $id);
    $q->execute();
    if ($row = $q->get_result()->fetch_assoc()) { $dbEmail = $row['email']; $dbRole = $row['role']; $dbStat = $row['stat']; }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><title>Who am I?</title></head>
<body style="font-family:sans-serif;line-height:1.7;padding:24px">
  <h2>Who am I?</h2>
  <p><b>Logged in as (session):</b> user_id <?= $id ?: 'none' ?> | role = <b><?= htmlspecialchars($_SESSION['role'] ?? 'none') ?></b></p>
  <p><b>In the database now:</b> <?= htmlspecialchars($dbEmail) ?> | role = <b><?= htmlspecialchars($dbRole) ?></b> | stat = <?= htmlspecialchars($dbStat) ?></p>
  <p>
    <?php if ($id && ($_SESSION['role'] ?? '') !== $dbRole): ?>
      The session role and database role are different. <b>Log out and log in again.</b>
    <?php elseif ($id && $dbRole !== 'staff'): ?>
      This account's role is "<?= htmlspecialchars($dbRole) ?>", not staff. Change it in phpMyAdmin (tbl_users), then log out and log in again.
    <?php elseif ($id): ?>
      Role is staff. You should be sent to staff_dashboard.php.
    <?php endif; ?>
  </p>
  <a href="logout.php">Logout</a>
</body></html>
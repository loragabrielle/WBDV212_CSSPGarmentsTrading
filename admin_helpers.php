<?php
/* Small helpers shared by the admin and staff pages. */

function admin_escape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function admin_money($amount, $currency = 'PHP') {
    $symbols = [
        'PHP' => '₱',
        'USD' => '$',
        'GBP' => '£'
    ];
    $symbol = $symbols[$currency] ?? $symbols['PHP'];

    return $symbol . number_format((float)$amount, 2);
}

function admin_status_badge($status) {
    $knownStatuses = ['pending', 'paid', 'shipped', 'delivered', 'cancelled', 'refunded'];
    $safeStatus = in_array($status, $knownStatuses, true) ? $status : 'pending';
    $label = ucfirst($safeStatus);

    return '<span class="status-badge status-' . $safeStatus . '">' .
        admin_escape($label) . '</span>';
}

/* Retained for the postponed dashboard pages that use the activity-log table. */
function write_activity_log(mysqli $con, $user_id, $action, $details) {
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
    $statement = $con->prepare(
        'INSERT INTO tbl_activity_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)'
    );
    if (!$statement) {
        throw new mysqli_sql_exception('Could not prepare the activity log: ' . $con->error);
    }

    $statement->bind_param('isss', $user_id, $action, $details, $ipAddress);
    if (!$statement->execute()) {
        throw new mysqli_sql_exception('Could not save the activity log: ' . $statement->error);
    }
    $statement->close();
}

/* Retained for product, order and shipping modules when their tables are set up later. */
function admin_log_action(mysqli $con, $action, $details) {
    write_activity_log($con, (int)($_SESSION['user_id'] ?? 0), $action, $details);
}

function admin_query_rows(mysqli $con, $sql) {
    $result = $con->query($sql);
    if (!$result) {
        throw new mysqli_sql_exception('Dashboard query failed: ' . $con->error);
    }

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
    return $rows;
}

function admin_query_value(mysqli $con, $sql, $column) {
    $rows = admin_query_rows($con, $sql);
    return $rows[0][$column] ?? 0;
}

function admin_csrf_token() {
    if (empty($_SESSION['admin_csrf_token'])) {
        $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['admin_csrf_token'];
}

function admin_require_csrf() {
    $sentToken = $_POST['csrf_token'] ?? '';
    $savedToken = $_SESSION['admin_csrf_token'] ?? '';
    if (!is_string($sentToken) || !is_string($savedToken) || $savedToken === '' ||
        !hash_equals($savedToken, $sentToken)) {
        flash_redirect('error', 'Request expired', 'Please refresh the page and try again.', 'admin_dashboard.php');
    }
}

function admin_post_text($key, $maximumLength = 2000) {
    $value = trim((string)($_POST[$key] ?? ''));
    return mb_substr($value, 0, $maximumLength);
}

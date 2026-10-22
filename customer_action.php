<?php
session_start();
require 'database.php';
require 'includes/guard.php';
require_role(['admin']);
require 'includes/admin_helpers.php';
/* updates customer status or marks a customer message as read. */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash_redirect('error', 'Invalid request', 'Use the customer page to make changes.', 'customers_manage.php');
}
admin_require_csrf();
$action = $_POST['action'] ?? '';
$customerId = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
$messageId = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);

try {
    if ($action === 'mark_read' && $messageId) {
        $read = 1;
        $statement = $con->prepare('UPDATE tbl_messages SET is_read = ? WHERE message_id = ? AND is_read = 0');
        $statement->bind_param('ii', $read, $messageId);
        $statement->execute();
        $statement->close();
        admin_log_action($con, 'customer_message_read', 'Message ID ' . $messageId . ' marked read');
        flash_redirect('success', 'Message updated', 'The message was marked as read.', 'customers_manage.php?tab=messages');
    }
    if (!$customerId) flash_redirect('error', 'Customer not found', 'Refresh the customer list and try again.', 'customers_manage.php');
    if ($action === 'toggle_customer') {
        $statement = $con->prepare("UPDATE tbl_users SET stat = IF(stat = 'active', 'inactive', 'active') WHERE user_id = ? AND role = 'customer'");
        $statement->bind_param('i', $customerId);
        $statement->execute();
        $changed = $statement->affected_rows;
        $statement->close();
        if (!$changed) flash_redirect('error', 'Customer not found', 'This account could not be updated.', 'customers_manage.php');
        admin_log_action($con, 'customer_status_changed', 'Customer account ID ' . $customerId);
        flash_redirect('success', 'Customer status updated', 'The customer account status was changed.', 'customers_manage.php?tab=customers&id=' . $customerId);
    }
    if ($action === 'delete_customer') {
        $inactive = 'inactive';
        $statement = $con->prepare("UPDATE tbl_users SET stat = ? WHERE user_id = ? AND role = 'customer'");
        $statement->bind_param('si', $inactive, $customerId);
        $statement->execute();
        $statement->close();
        admin_log_action($con, 'customer_soft_deleted', 'Customer account ID ' . $customerId);
        flash_redirect('success', 'Customer deactivated', 'The customer account was soft deleted.', 'customers_manage.php');
    }
    flash_redirect('error', 'Action not found', 'Choose a valid customer action.', 'customers_manage.php');
} catch (mysqli_sql_exception $error) {
    error_log('Customer action failed: ' . $error->getMessage());
    flash_redirect('error', 'Customer not updated', 'The customer change could not be saved.', 'customers_manage.php');
}

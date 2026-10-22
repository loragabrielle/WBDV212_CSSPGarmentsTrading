<?php
require 'includes/guard.php';
require_role(['admin', 'staff']);
require 'database.php';
require 'includes/admin_helpers.php';
require 'includes/admin_layout.php';

$tab = $_GET['tab'] ?? 'customers';
if (!in_array($tab, ['customers', 'messages'], true)) $tab = 'customers';
$search = trim((string)($_GET['q'] ?? ''));
$customerId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$searchLike = '%' . $search . '%';
$customers = [];
$customer = null;
$orders = [];
$messages = [];
$pageError = '';

try {
    if ($tab === 'customers') {
        $statement = $con->prepare(
            "SELECT user_id, first_name, last_name, email, phone, stat, created_at
             FROM tbl_users WHERE role = 'customer'
               AND (? = '' OR first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?)
             ORDER BY created_at DESC"
        );
        $statement->bind_param('sssss', $search, $searchLike, $searchLike, $searchLike, $searchLike);
        $statement->execute();
        $customers = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $statement->close();

        if ($customerId > 0) {
            $statement = $con->prepare("SELECT user_id, first_name, last_name, email, phone, address, stat, created_at FROM tbl_users WHERE user_id = ? AND role = 'customer'");
            $statement->bind_param('i', $customerId);
            $statement->execute();
            $customer = $statement->get_result()->fetch_assoc();
            $statement->close();
            if ($customer) {
                $statement = $con->prepare('SELECT order_id, order_status, total_amount, created_at FROM tbl_orders WHERE customer_user_id = ? ORDER BY created_at DESC');
                $statement->bind_param('i', $customerId);
                $statement->execute();
                $orders = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
                $statement->close();
            }
        }
    } else {
        $messages = admin_query_rows(
            $con,
            "SELECT m.message_id, m.user_id, m.message_type, m.subject, m.message_text, m.rating, m.is_read, m.created_at,
                    u.first_name, u.last_name, u.email
             FROM tbl_messages m LEFT JOIN tbl_users u ON u.user_id = m.user_id
             ORDER BY m.created_at DESC LIMIT 100"
        );
    }
} catch (mysqli_sql_exception $error) {
    error_log('Customer data could not load: ' . $error->getMessage());
    $pageError = 'Customer information could not be loaded.';
}

admin_layout_start('Customers', 'customers');
?>
<nav class="admin-tabs" aria-label="Customer sections">
    <a class="admin-tab <?= $tab === 'customers' ? 'active' : '' ?>" href="customers_manage.php?tab=customers">Customers</a>
    <a class="admin-tab <?= $tab === 'messages' ? 'active' : '' ?>" href="customers_manage.php?tab=messages">Messages &amp; reviews</a>
</nav>
<?php if ($pageError !== ''): ?><div class="admin-alert" role="alert"><?= admin_escape($pageError) ?></div><?php endif; ?>
<?php if ($tab === 'customers'): ?>
    <form class="admin-toolbar" method="get"><input type="hidden" name="tab" value="customers"><label>Search customers<input name="q" value="<?= admin_escape($search) ?>" placeholder="Name, email or phone"></label><button class="admin-action-button" type="submit">Search</button></form>
    <?php if ($customer): ?>
        <section class="dashboard-panel" style="margin-bottom:18px"><div class="panel-heading"><div><p class="dashboard-eyebrow">Customer profile</p><h2><?= admin_escape($customer['first_name'] . ' ' . $customer['last_name']) ?></h2></div><a class="admin-action-button secondary" href="customers_manage.php?tab=customers&amp;q=<?= rawurlencode($search) ?>">Back to list</a></div>
            <p><?= admin_escape($customer['email']) ?></p><p><?= admin_escape($customer['phone']) ?></p><p><?= nl2br(admin_escape($customer['address'])) ?></p>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <div class="admin-row-actions" style="margin-top:16px">
                    <form method="post" action="customer_action.php">
                        <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>"><input type="hidden" name="customer_id" value="<?= (int)$customerId ?>"><input type="hidden" name="action" value="toggle_customer">
                        <button class="admin-action-button secondary" type="submit"><?= $customer['stat'] === 'active' ? 'Block customer' : 'Unblock customer' ?></button>
                    </form>
                    <?php if ($customer['stat'] === 'active'): ?><form method="post" action="customer_action.php" data-confirm-message="Deactivate this customer account? The account will be kept in the database.">
                        <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>"><input type="hidden" name="customer_id" value="<?= (int)$customerId ?>"><input type="hidden" name="action" value="delete_customer"><button class="admin-action-button danger" type="submit">Soft delete</button>
                    </form><?php endif; ?>
                </div>
            <?php endif; ?>
        </section>
        <section class="dashboard-panel"><div class="panel-heading"><h2>Order history</h2></div>
            <?php if (!$orders): ?><p class="dashboard-empty">No orders are linked to this account.</p><?php else: ?><table class="admin-data-table"><thead><tr><th>Order</th><th>Date</th><th>Status</th><?php if ($_SESSION['role'] === 'admin'): ?><th>Total</th><?php endif; ?><th>View</th></tr></thead><tbody>
                <?php foreach ($orders as $order): ?><tr><td data-label="Order">#<?= (int)$order['order_id'] ?></td><td data-label="Date"><?= admin_escape(date('M j, Y', strtotime($order['created_at']))) ?></td><td data-label="Status"><?= admin_status_badge($order['order_status']) ?></td><?php if ($_SESSION['role'] === 'admin'): ?><td data-label="Total"><?= admin_money($order['total_amount']) ?></td><?php endif; ?><td data-label="View"><a class="admin-action-button secondary" href="order_view.php?id=<?= (int)$order['order_id'] ?>">Open</a></td></tr><?php endforeach; ?>
            </tbody></table><?php endif; ?>
        </section>
    <?php else: ?>
        <div class="admin-data-card"><?php if (!$customers): ?><p class="admin-empty">No customer accounts found.</p><?php else: ?><table class="admin-data-table"><thead><tr><th>Customer</th><th>Email</th><th>Phone</th><th>Status</th><th>Joined</th><th>Profile</th></tr></thead><tbody>
            <?php foreach ($customers as $row): ?><tr><td data-label="Customer"><strong><?= admin_escape($row['first_name'] . ' ' . $row['last_name']) ?></strong></td><td data-label="Email"><?= admin_escape($row['email']) ?></td><td data-label="Phone"><?= admin_escape($row['phone']) ?></td><td data-label="Status"><?= admin_escape($row['stat']) ?></td><td data-label="Joined"><?= admin_escape(date('M j, Y', strtotime($row['created_at']))) ?></td><td data-label="Profile"><a class="admin-action-button secondary" href="?tab=customers&amp;id=<?= (int)$row['user_id'] ?>">View history</a></td></tr><?php endforeach; ?>
        </tbody></table><?php endif; ?></div>
    <?php endif; ?>
<?php else: ?>
    <div class="admin-data-card"><?php if (!$messages): ?><p class="admin-empty">No messages or reviews yet.</p><?php else: ?><table class="admin-data-table"><thead><tr><th>Type / sender</th><th>Message</th><th>Rating</th><th>Read</th><?php if ($_SESSION['role'] === 'admin'): ?><th>Action</th><?php endif; ?></tr></thead><tbody>
        <?php foreach ($messages as $message): ?><tr><td data-label="Type / sender"><strong><?= admin_escape(ucfirst($message['message_type'])) ?></strong><br><?= admin_escape(trim(($message['first_name'] ?? 'Guest') . ' ' . ($message['last_name'] ?? ''))) ?><br><small><?= admin_escape($message['email'] ?? 'No account email') ?></small><br><small><?= admin_escape(date('M j, Y', strtotime($message['created_at']))) ?></small></td><td data-label="Message"><strong><?= admin_escape($message['subject']) ?></strong><br><?= nl2br(admin_escape($message['message_text'])) ?></td><td data-label="Rating"><?= $message['rating'] === null ? '—' : number_format((int)$message['rating']) . ' / 5' ?></td><td data-label="Read"><?= (int)$message['is_read'] ? 'Read' : 'Unread' ?></td><?php if ($_SESSION['role'] === 'admin'): ?><td data-label="Action"><?php if (!(int)$message['is_read']): ?><form method="post" action="customer_action.php"><input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>"><input type="hidden" name="action" value="mark_read"><input type="hidden" name="message_id" value="<?= (int)$message['message_id'] ?>"><button class="admin-action-button secondary" type="submit">Mark as read</button></form><?php else: ?>—<?php endif; ?></td><?php endif; ?></tr><?php endforeach; ?>
    </tbody></table><?php endif; ?></div>
<?php endif; ?>
<?php admin_layout_end(); ?>

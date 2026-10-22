<?php
require 'includes/guard.php';
require_role(['admin', 'staff']);
require 'database.php';
require 'includes/admin_helpers.php';
require 'includes/admin_layout.php';

$isAdmin = $_SESSION['role'] === 'admin';
$tab = $_GET['tab'] ?? 'users';
if (!in_array($tab, ['users', 'logins'], true)) $tab = 'users';
$users = [];
$loginRows = [];
$loginColumns = [];
$pageError = '';

try {
    if ($tab === 'users') {
        $users = admin_query_rows(
            $con,
            'SELECT user_id, first_name, last_name, email, role, stat, created_at, last_login_at
             FROM tbl_users ORDER BY created_at DESC'
        );
    } else {
        // The login-log table already belongs to the website; display its real columns.
        $result = $con->query('SELECT * FROM tbl_login_logs ORDER BY 1 DESC LIMIT 100');
        if (!$result) {
            throw new mysqli_sql_exception('Could not read login history: ' . $con->error);
        }
        $loginColumns = array_map(function ($field) { return $field->name; }, $result->fetch_fields());
        $loginRows = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    }
} catch (mysqli_sql_exception $error) {
    error_log('User accounts page could not load: ' . $error->getMessage());
    $pageError = 'Account or login history could not be loaded. Check that the existing user and login-log tables are available.';
}

admin_layout_start('User Accounts & Logs', 'users');
?>
<section class="people-page-intro">
    <div>
        <p class="dashboard-eyebrow">People &amp; access</p>
        <h2><?= $tab === 'users' ? 'Registered accounts' : 'Login history' ?></h2>
        <p><?= $tab === 'users'
            ? 'Review registrations and account access in one place.'
            : 'Review the login attempts already recorded by the website.' ?></p>
    </div>
    <?php if ($isAdmin && $tab === 'users'): ?>
        <button class="admin-action-button" type="button" data-modal-open="userModal">＋ Add account</button>
    <?php endif; ?>
</section>
<nav class="admin-tabs" aria-label="Account sections">
    <a class="admin-tab <?= $tab === 'users' ? 'active' : '' ?>" href="?tab=users">User accounts</a>
    <a class="admin-tab <?= $tab === 'logins' ? 'active' : '' ?>" href="?tab=logins">Login logs</a>
</nav>
<?php if ($pageError !== ''): ?><div class="admin-alert" role="alert"><?= admin_escape($pageError) ?></div><?php endif; ?>

<?php if ($tab === 'users'): ?>
    <div class="account-summary-strip">
        <span>Showing <strong><?= number_format(count($users)) ?></strong> registered accounts</span>
        <span class="role-chip"><?= $isAdmin ? 'Administrator controls enabled' : 'Read-only staff view' ?></span>
    </div>
    <div class="admin-data-card">
        <?php if (!$users): ?>
            <div class="admin-empty">No registered accounts yet.</div>
        <?php else: ?>
            <table class="admin-data-table">
                <thead><tr><th>Person</th><th>Email</th><th>Role</th><th>Account status</th><th>Last login</th><?php if ($isAdmin): ?><th>Manage</th><?php endif; ?></tr></thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td data-label="Person"><div class="account-person">
                            <span class="account-avatar"><?= admin_escape(strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1))) ?></span>
                            <span><strong><?= admin_escape($user['first_name'] . ' ' . $user['last_name']) ?></strong><small>Member since <?= admin_escape(date('M Y', strtotime($user['created_at']))) ?></small></span>
                        </div></td>
                        <td data-label="Email"><?= admin_escape($user['email']) ?></td>
                        <td data-label="Role"><span class="role-label role-<?= admin_escape($user['role']) ?>"><?= admin_escape(ucfirst($user['role'])) ?></span></td>
                        <td data-label="Account status"><span class="account-status <?= $user['stat'] === 'active' ? 'account-active' : 'account-inactive' ?>"><?= admin_escape(ucfirst($user['stat'])) ?></span></td>
                        <td data-label="Last login"><?= $user['last_login_at'] ? admin_escape(date('M j, Y g:i A', strtotime($user['last_login_at']))) : 'Not signed in yet' ?></td>
                        <?php if ($isAdmin): ?>
                            <td data-label="Manage"><div class="admin-row-actions">
                                <button type="button" class="admin-action-button secondary reset-user-button" data-id="<?= (int)$user['user_id'] ?>" data-name="<?= admin_escape($user['first_name'] . ' ' . $user['last_name']) ?>">Reset password</button>
                                <?php if ((int)$user['user_id'] !== (int)$_SESSION['user_id']): ?>
                                    <button type="button" class="admin-action-button secondary change-role-button" data-id="<?= (int)$user['user_id'] ?>" data-name="<?= admin_escape($user['first_name'] . ' ' . $user['last_name']) ?>" data-role="<?= admin_escape($user['role']) ?>">Role</button>
                                    <form method="post" action="users_action.php" <?= $user['stat'] === 'active' ? 'data-confirm-message="Deactivate this account? The account history will be kept."' : '' ?>>
                                        <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="user_id" value="<?= (int)$user['user_id'] ?>">
                                        <button class="admin-action-button <?= $user['stat'] === 'active' ? 'danger' : '' ?>" type="submit"><?= $user['stat'] === 'active' ? 'Deactivate' : 'Activate' ?></button>
                                    </form>
                                <?php endif; ?>
                            </div></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php if ($isAdmin): ?>
        <div class="admin-modal-backdrop" id="userModal" role="dialog" aria-modal="true" aria-labelledby="userModalTitle">
            <div class="admin-modal-card">
                <div class="admin-modal-heading"><h2 id="userModalTitle">Register a new account</h2><button class="admin-icon-button" type="button" data-modal-close aria-label="Close">×</button></div>
                <form class="admin-form-stack" method="post" action="users_action.php">
                    <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>">
                    <input type="hidden" name="action" value="create_user">
                    <div class="admin-toolbar" style="margin:0">
                        <label>First name<input name="first_name" required maxlength="100"></label>
                        <label>Last name<input name="last_name" required maxlength="100"></label>
                    </div>
                    <label>Email address<input name="email" type="email" required maxlength="200"></label>
                    <div class="admin-toolbar" style="margin:0">
                        <label>Birthday<input name="birthday" type="date" required></label>
                        <label>Gender<select name="gender" required><option value="">Choose one</option><option value="Male">Male</option><option value="Female">Female</option><option value="Prefer not to say">Prefer not to say</option></select></label>
                    </div>
                    <label>Phone number<input name="phone" required maxlength="50"></label>
                    <label>Address<textarea name="address" required maxlength="1000"></textarea></label>
                    <label>Initial password<input name="password" type="password" minlength="8" required autocomplete="new-password"></label>
                    <label>Account role<select name="role"><option value="customer">Customer</option><option value="staff">Staff</option><option value="admin">Admin</option></select></label>
                    <p class="admin-alert">Passwords are securely stored with PHP password_hash(). Give the initial password to the user privately.</p>
                    <div class="admin-confirm-actions"><button class="admin-action-button secondary" type="button" data-modal-close>Cancel</button><button class="admin-action-button" type="submit">Create account</button></div>
                </form>
            </div>
        </div>
        <div class="admin-modal-backdrop" id="passwordModal" role="dialog" aria-modal="true" aria-labelledby="passwordModalTitle">
            <div class="admin-modal-card">
                <div class="admin-modal-heading"><h2 id="passwordModalTitle">Reset password</h2><button class="admin-icon-button" type="button" data-modal-close aria-label="Close">×</button></div>
                <form class="admin-form-stack" method="post" action="users_action.php">
                    <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>"><input type="hidden" name="action" value="reset_password"><input type="hidden" name="user_id" id="resetUserId">
                    <p id="resetUserName"></p><label>New password<input name="password" type="password" minlength="8" required autocomplete="new-password"></label>
                    <div class="admin-confirm-actions"><button class="admin-action-button secondary" type="button" data-modal-close>Cancel</button><button class="admin-action-button" type="submit">Save password</button></div>
                </form>
            </div>
        </div>
        <div class="admin-modal-backdrop" id="roleModal" role="dialog" aria-modal="true" aria-labelledby="roleModalTitle">
            <div class="admin-modal-card">
                <div class="admin-modal-heading"><h2 id="roleModalTitle">Change account role</h2><button class="admin-icon-button" type="button" data-modal-close aria-label="Close">×</button></div>
                <form class="admin-form-stack" method="post" action="users_action.php">
                    <input type="hidden" name="csrf_token" value="<?= admin_escape(admin_csrf_token()) ?>"><input type="hidden" name="action" value="change_role"><input type="hidden" name="user_id" id="roleUserId">
                    <p id="roleUserName"></p><label>New role<select name="role" id="roleSelect"><option value="customer">Customer</option><option value="staff">Staff</option><option value="admin">Admin</option></select></label>
                    <div class="admin-confirm-actions"><button class="admin-action-button secondary" type="button" data-modal-close>Cancel</button><button class="admin-action-button" type="submit">Save role</button></div>
                </form>
            </div>
        </div>
        <script>
            document.querySelectorAll('.reset-user-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    document.getElementById('resetUserId').value = button.dataset.id;
                    document.getElementById('resetUserName').textContent = 'Set a new password for ' + button.dataset.name;
                    document.getElementById('passwordModal').classList.add('open');
                });
            });
            document.querySelectorAll('.change-role-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    document.getElementById('roleUserId').value = button.dataset.id;
                    document.getElementById('roleUserName').textContent = 'Choose a new role for ' + button.dataset.name;
                    document.getElementById('roleSelect').value = button.dataset.role;
                    document.getElementById('roleModal').classList.add('open');
                });
            });
        </script>
    <?php endif; ?>
<?php else: ?>
    <div class="account-summary-strip">
        <span>Most recent sign-in attempts</span>
        <span class="role-chip"><?= $isAdmin ? 'Admin view' : 'Staff view' ?></span>
    </div>
    <div class="admin-data-card">
        <?php if (!$loginRows): ?>
            <div class="admin-empty">No login attempts have been recorded yet.</div>
        <?php else: ?>
            <table class="admin-data-table">
                <thead><tr><?php foreach ($loginColumns as $column): ?><th><?= admin_escape(ucwords(str_replace('_', ' ', $column))) ?></th><?php endforeach; ?></tr></thead>
                <tbody><?php foreach ($loginRows as $login): ?><tr>
                    <?php foreach ($loginColumns as $column): ?>
                        <?php $value = $login[$column] ?? ''; ?>
                        <td data-label="<?= admin_escape(ucwords(str_replace('_', ' ', $column))) ?>">
                            <?php if ($column === 'success'): ?>
                                <span class="account-status <?= (int)$value === 1 ? 'account-active' : 'account-inactive' ?>"><?= (int)$value === 1 ? 'Success' : 'Failed' ?></span>
                            <?php elseif (in_array($column, ['created_at', 'login_at', 'attempted_at', 'date_time', 'timestamp'], true) && $value !== ''): ?>
                                <?= admin_escape(date('M j, Y g:i A', strtotime($value))) ?>
                            <?php else: ?>
                                <?= admin_escape($value) ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr><?php endforeach; ?></tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endif; ?>

<style>
    css
```

.people-page-intro {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 20px;
    margin-bottom: 22px;
}

.people-page-intro h2 {
    margin-bottom: 6px;
    font-size: clamp(1.8rem, 3vw, 2.4rem);
}

.people-page-intro p:not(.dashboard-eyebrow) {
    color: var(--text-muted);
}

.account-summary-strip {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin: 0 0 14px;
    color: var(--text-muted);
    font-size: 0.87rem;
}

.role-chip {
    padding: 8px 13px;
    color: var(--navy);
    background: var(--yellow);
    border-radius: 22px;
    font-size: 0.75rem;
    font-weight: 700;
}

.account-person {
    display: flex;
    align-items: center;
    gap: 10px;
}

.account-person strong,
.account-person small {
    display: block;
}

.account-person small {
    margin-top: 4px;
    color: var(--text-muted);
}

.account-avatar {
    display: grid;
    place-items: center;
    width: 40px;
    height: 40px;
    flex: 0 0 auto;
    color: var(--yellow);
    background: var(--navy);
    border-radius: 50%;
    font: 1.1rem 'Bebas Neue Custom', sans-serif;
}

.role-label {
    display: inline-flex;
    padding: 5px 10px;
    background: var(--bg);
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.role-admin {
    color: var(--navy);
    background: var(--yellow);
}

.role-staff {
    color: var(--navy);
    background: #dce9f5;
}

.role-customer {
    color: var(--green);
    background: #e4f0e9;
}

[data-theme="dark"] .role-staff {
    color: #e7f2ff;
    background: #27425f;
}

[data-theme="dark"] .role-customer {
    color: #a9e3bf;
    background: #244437;
}

.account-status {
    display: inline-flex;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.account-active {
    color: var(--green);
    background: #e4f0e9;
}

.account-inactive {
    color: #8e1d2a;
    background: #fbe4e6;
}

[data-theme="dark"] .account-active {
    color: #a9e3bf;
    background: #244437;
}

[data-theme="dark"] .account-inactive {
    color: #ffb7bf;
    background: #4c2831;
}

@media (max-width: 650px) {
    .people-page-intro {
        align-items: start;
        flex-direction: column;
    }

    .account-summary-strip {
        align-items: start;
        flex-direction: column;
    }
}
</style>
<?php admin_layout_end(); ?>

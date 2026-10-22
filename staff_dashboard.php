<?php
require 'includes/guard.php';
require_role(['staff']);
require 'database.php';
require 'includes/admin_helpers.php';
require 'includes/admin_layout.php';

$accountCounts = ['total' => 0, 'customer' => 0, 'staff' => 0, 'admin' => 0];
$recentLogins = [];
$failedLogins = 0;
$dashboardError = '';

try {
    $active = 'active';
    $statement = $con->prepare(
        'SELECT role, COUNT(*) AS total FROM tbl_users WHERE stat = ? GROUP BY role'
    );
    $statement->bind_param('s', $active);
    $statement->execute();
    $countRows = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    $statement->close();

    foreach ($countRows as $row) {
        $role = $row['role'];
        $count = (int)$row['total'];
        if (isset($accountCounts[$role])) $accountCounts[$role] = $count;
        $accountCounts['total'] += $count;
    }

    $loginResult = $con->query('SELECT * FROM tbl_login_logs ORDER BY 1 DESC LIMIT 6');
    if (!$loginResult) {
        throw new mysqli_sql_exception('Could not read login history: ' . $con->error);
    }
    $recentLogins = $loginResult->fetch_all(MYSQLI_ASSOC);
    $loginResult->free();

    $failedResult = $con->query('SELECT COUNT(*) AS total FROM tbl_login_logs WHERE success = 0');
    if (!$failedResult) {
        throw new mysqli_sql_exception('Could not count unsuccessful login attempts: ' . $con->error);
    }
    $failedLogins = (int)($failedResult->fetch_assoc()['total'] ?? 0);
    $failedResult->free();
} catch (mysqli_sql_exception $error) {
    error_log('Staff dashboard could not load account information: ' . $error->getMessage());
    $dashboardError = 'Account or login history is not available. Check that tbl_users and tbl_login_logs exist.';
}

admin_layout_start('Staff Workspace', 'dashboard');
?>
<section class="staff-intro">
    <div>
        <p class="staff-eyebrow">CSSP Garments Trading / Staff</p>
        <h2>Welcome back, <?= admin_escape($_SESSION['first_name'] ?? 'Team member') ?>.</h2>
        <p>This is your read-only workspace for account and sign-in information.</p>
    </div>
    <span class="staff-access-pill"><i></i> Staff access</span>
</section>

<?php if ($dashboardError !== ''): ?><div class="staff-error" role="alert"><?= admin_escape($dashboardError) ?></div><?php endif; ?>

<section class="staff-stat-grid" aria-label="Staff workspace summary">
    <article class="staff-stat-card">
        <span class="staff-stat-icon">◎</span><span class="staff-stat-label">Active accounts</span>
        <strong><?= number_format($accountCounts['total']) ?></strong><small>All account types</small>
    </article>
    <article class="staff-stat-card">
        <span class="staff-stat-icon">♙</span><span class="staff-stat-label">Customers</span>
        <strong><?= number_format($accountCounts['customer']) ?></strong><small>Active customer accounts</small>
    </article>
    <article class="staff-stat-card">
        <span class="staff-stat-icon">✦</span><span class="staff-stat-label">Staff team</span>
        <strong><?= number_format($accountCounts['staff']) ?></strong><small>Active staff accounts</small>
    </article>
    <article class="staff-stat-card staff-stat-alert">
        <span class="staff-stat-icon">↯</span><span class="staff-stat-label">Failed sign-ins</span>
        <strong><?= number_format($failedLogins) ?></strong><small>Recorded login attempts</small>
    </article>
</section>

<section class="staff-panel-grid">
    <article class="staff-panel staff-access-panel">
        <div class="staff-panel-heading"><div><span class="staff-eyebrow">Your workspace</span><h2>What you can access</h2></div><span class="staff-lock">Read only</span></div>
        <div class="staff-access-item"><span class="staff-check">✓</span><div><strong>Account directory</strong><p>View registered accounts and their current access status.</p></div></div>
        <div class="staff-access-item"><span class="staff-check">✓</span><div><strong>Login history</strong><p>Review sign-in attempts recorded by the website.</p></div></div>
        <div class="staff-access-item staff-access-preview"><span class="staff-preview-icon">◇</span><div><strong>Product workspace preview</strong><p>Explore the planned inventory layout. Preview data is not connected to a product database.</p></div></div>
        <a class="staff-main-link" href="products_preview.php">Open product workspace preview <span aria-hidden="true">→</span></a>
    </article>

    <article class="staff-panel staff-profile-panel">
        <span class="staff-eyebrow">Signed in</span>
        <div class="staff-profile-avatar"><?= admin_escape(strtoupper(substr($_SESSION['first_name'] ?? 'S', 0, 1))) ?></div>
        <h2><?= admin_escape($_SESSION['first_name'] ?? 'Staff member') ?></h2>
        <span class="staff-profile-role">Staff member</span>
        <p>Your account is read-only. Only an administrator can add accounts, change roles, reset passwords, or change account status.</p>
        <a class="staff-main-link" href="users_security.php?tab=users">Browse account directory <span aria-hidden="true">→</span></a>
        <a class="staff-secondary-link" href="users_security.php?tab=logins">View login logs <span aria-hidden="true">→</span></a>
    </article>

    <article class="staff-panel staff-recent-panel">
        <div class="staff-panel-heading"><div><span class="staff-eyebrow">Security activity</span><h2>Recent login attempts</h2></div><a class="staff-secondary-link" href="users_security.php?tab=logins">View all →</a></div>
        <?php if (!$recentLogins): ?>
            <div class="staff-empty"><span>◷</span><strong>No login records yet</strong><p>Sign-in attempts will appear here when recorded.</p></div>
        <?php else: ?>
            <div class="staff-login-list">
                <?php foreach ($recentLogins as $login): ?>
                    <?php
                    $email = $login['email_tried'] ?? 'Unknown account';
                    $success = isset($login['success']) && (int)$login['success'] === 1;
                    $dateValue = '';
                    foreach (['created_at', 'login_at', 'attempted_at', 'date_time', 'timestamp'] as $dateColumn) {
                        if (!empty($login[$dateColumn])) { $dateValue = $login[$dateColumn]; break; }
                    }
                    ?>
                    <div class="staff-login-row">
                        <span class="staff-login-dot <?= $success ? 'success' : 'failed' ?>"></span>
                        <div><strong><?= admin_escape($email) ?></strong><small><?= $success ? 'Successful sign-in' : 'Unsuccessful attempt' ?></small></div>
                        <time><?= $dateValue !== '' ? admin_escape(date('M j, g:i A', strtotime($dateValue))) : '' ?></time>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</section>

<style>
Here’s your CSS cleaned up and formatted with each selector and property on separate lines for better readability.

css
```

.staff-intro {
    display: flex;
    align-items: end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 25px;
}

.staff-eyebrow {
    display: block;
    margin-bottom: 6px;
    color: var(--text-muted);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.staff-intro h2 {
    margin-bottom: 6px;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
}

.staff-intro p:not(.staff-eyebrow) {
    color: var(--text-muted);
}

.staff-access-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 14px;
    color: var(--navy);
    background: var(--yellow);
    border-radius: 24px;
    font-size: 0.78rem;
    font-weight: 700;
    white-space: nowrap;
}

.staff-access-pill i {
    width: 8px;
    height: 8px;
    background: var(--green);
    border-radius: 50%;
}

.staff-error {
    margin-bottom: 18px;
    padding: 14px 16px;
    color: #610000;
    background: #fff0f0;
    border: 1px solid #e6b6b6;
    border-radius: 10px;
}

[data-theme="dark"] .staff-error {
    color: #ffd7d7;
    background: #42252c;
    border-color: #78414b;
}

.staff-stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.staff-stat-card,
.staff-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.staff-stat-card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-height: 150px;
    padding: 20px;
    overflow: hidden;
}

.staff-stat-icon {
    position: absolute;
    top: 12px;
    right: 16px;
    color: var(--navy);
    opacity: 0.13;
    font-size: 2.8rem;
}

[data-theme="dark"] .staff-stat-icon {
    color: var(--yellow);
    opacity: 0.2;
}

.staff-stat-label {
    color: var(--text-muted);
    font-size: 0.86rem;
    font-weight: 700;
}

.staff-stat-card strong {
    margin: 12px 0 4px;
    color: var(--navy);
    font-size: 2rem;
}

[data-theme="dark"] .staff-stat-card strong {
    color: var(--yellow);
}

.staff-stat-card small {
    margin-top: auto;
    color: var(--text-muted);
}

.staff-stat-alert strong {
    color: var(--red);
}

.staff-panel-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.2fr) minmax(250px, 0.8fr);
    gap: 18px;
}

.staff-panel {
    min-width: 0;
    padding: clamp(19px, 3vw, 26px);
}

.staff-panel-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 17px;
}

.staff-panel-heading h2 {
    margin: 0;
    font-size: 1.5rem;
}

.staff-lock {
    padding: 6px 10px;
    color: var(--text-muted);
    background: var(--bg);
    border-radius: 18px;
    font-size: 0.72rem;
    font-weight: 700;
}

.staff-access-item {
    display: flex;
    gap: 12px;
    padding: 13px 0;
    border-top: 1px solid var(--border);
}

.staff-access-item strong {
    display: block;
    margin-bottom: 3px;
}

.staff-access-item p {
    color: var(--text-muted);
    font-size: 0.83rem;
    line-height: 1.5;
}

.staff-check,
.staff-preview-icon {
    display: grid;
    place-items: center;
    width: 27px;
    height: 27px;
    flex: 0 0 auto;
    color: var(--green);
    background: rgba(45, 106, 79, 0.12);
    border-radius: 50%;
    font-weight: 700;
}

.staff-access-preview .staff-preview-icon {
    color: var(--navy);
    background: rgba(26, 58, 92, 0.1);
}

[data-theme="dark"] .staff-access-preview .staff-preview-icon {
    color: var(--yellow);
    background: rgba(244, 208, 63, 0.12);
}

.staff-main-link,
.staff-secondary-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 42px;
    color: var(--navy);
    font-size: 0.84rem;
    font-weight: 700;
}

[data-theme="dark"] .staff-main-link,
[data-theme="dark"] .staff-secondary-link {
    color: var(--yellow);
}

.staff-main-link {
    margin-top: 10px;
    padding: 9px 14px;
    border: 1px solid var(--border);
    border-radius: 22px;
}

.staff-main-link:hover {
    color: var(--yellow);
    background: var(--navy);
}

.staff-profile-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.staff-profile-panel .staff-eyebrow {
    align-self: flex-start;
}

.staff-profile-avatar {
    display: grid;
    place-items: center;
    width: 68px;
    height: 68px;
    margin: 8px 0 12px;
    color: var(--yellow);
    background: var(--navy);
    border-radius: 50%;
    font: 2rem 'Bebas Neue Custom', sans-serif;
}

.staff-profile-panel h2 {
    margin: 0;
    font-size: 1.6rem;
}

.staff-profile-role {
    margin: 7px 0 13px;
    padding: 5px 11px;
    color: var(--navy);
    background: var(--yellow);
    border-radius: 20px;
    font-size: 0.74rem;
    font-weight: 700;
}

.staff-profile-panel p {
    color: var(--text-muted);
    font-size: 0.84rem;
    line-height: 1.55;
}

.staff-profile-panel .staff-secondary-link {
    margin-top: 4px;
}

.staff-recent-panel {
    grid-column: 1 / -1;
}

.staff-login-list {
    display: grid;
}

.staff-login-row {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 60px;
    border-top: 1px solid var(--border);
}

.staff-login-dot {
    width: 9px;
    height: 9px;
    flex: 0 0 auto;
    border-radius: 50%;
}

.staff-login-dot.success {
    background: var(--green);
}

.staff-login-dot.failed {
    background: var(--red);
}

.staff-login-row div {
    flex: 1;
    min-width: 0;
}

.staff-login-row strong,
.staff-login-row small {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.staff-login-row strong {
    font-size: 0.88rem;
}

.staff-login-row small,
.staff-login-row time {
    margin-top: 3px;
    color: var(--text-muted);
    font-size: 0.76rem;
}

.staff-empty {
    display: grid;
    justify-items: center;
    padding: 25px;
    color: var(--text-muted);
    text-align: center;
}

.staff-empty span {
    font-size: 2rem;
}

.staff-empty strong {
    margin: 7px 0 4px;
    color: var(--text);
}

@media (max-width: 740px) {
    .staff-panel-grid {
        grid-template-columns: 1fr;
    }

    .staff-recent-panel {
        grid-column: auto;
    }
}

@media (max-width: 560px) {
    .staff-intro {
        align-items: start;
        flex-direction: column;
    }

    .staff-login-row time {
        font-size: 0.68rem;
        text-align: right;
    }
}
</style>
<?php admin_layout_end(); ?>

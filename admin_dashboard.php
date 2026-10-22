<?php
require 'includes/guard.php';
require_role(['admin', 'staff']);
require 'database.php';
require 'includes/admin_helpers.php';
require 'includes/admin_layout.php';

$isAdmin = $_SESSION['role'] === 'admin';
$accountCounts = ['total' => 0, 'customer' => 0, 'staff' => 0, 'admin' => 0, 'inactive' => 0];
$recentLogins = [];
$failedLogins = 0;
$dashboardError = '';

try {
    $countRows = admin_query_rows(
        $con,
        'SELECT role, stat, COUNT(*) AS total FROM tbl_users GROUP BY role, stat'
    );
    foreach ($countRows as $row) {
        $role = $row['role'];
        $count = (int)$row['total'];
        if (isset($accountCounts[$role])) $accountCounts[$role] += $count;
        $accountCounts['total'] += $count;
        if ($row['stat'] === 'inactive') $accountCounts['inactive'] += $count;
    }

    // Read login history using the existing table instead of requiring dashboard-specific tables.
    $logResult = $con->query('SELECT * FROM tbl_login_logs ORDER BY 1 DESC LIMIT 8');
    if (!$logResult) {
        throw new mysqli_sql_exception('Could not read login history: ' . $con->error);
    }
    $recentLogins = $logResult->fetch_all(MYSQLI_ASSOC);
    $logResult->free();

    $failedRows = admin_query_rows(
        $con,
        'SELECT COUNT(*) AS total FROM tbl_login_logs WHERE success = 0'
    );
    $failedLogins = (int)($failedRows[0]['total'] ?? 0);
} catch (mysqli_sql_exception $error) {
    error_log('User dashboard could not load account data: ' . $error->getMessage());
    $dashboardError = 'User or login-log data is unavailable. Check that tbl_users and tbl_login_logs exist in tbl_wbdv212.';
}

admin_layout_start('People & Access', 'dashboard');
?>
<section class="dashboard-intro">
    <div>
        <p class="dashboard-eyebrow">CSSP Garments Trading / People</p>
        <h2>Welcome, <?= admin_escape($_SESSION['first_name'] ?? 'Team member') ?>.</h2>
        <p class="dashboard-subtitle">Manage account access and review recent sign-in activity.</p>
    </div>
    <span class="role-chip"><?= $isAdmin ? 'Administrator' : 'Staff' ?> view</span>
</section>

<?php if ($dashboardError !== ''): ?><div class="dashboard-error" role="alert"><?= admin_escape($dashboardError) ?></div><?php endif; ?>

<section class="people-metrics" aria-label="Account overview">
    <article class="people-metric">
        <span class="people-metric-icon">◎</span>
        <span class="metric-label">All accounts</span>
        <strong class="metric-value"><?= number_format($accountCounts['total']) ?></strong>
        <span class="metric-note">Registered people</span>
    </article>
    <article class="people-metric">
        <span class="people-metric-icon">♙</span>
        <span class="metric-label">Customers</span>
        <strong class="metric-value"><?= number_format($accountCounts['customer']) ?></strong>
        <span class="metric-note">Customer accounts</span>
    </article>
    <article class="people-metric">
        <span class="people-metric-icon">✦</span>
        <span class="metric-label">Staff members</span>
        <strong class="metric-value"><?= number_format($accountCounts['staff']) ?></strong>
        <span class="metric-note">Staff access accounts</span>
    </article>
    <?php if ($isAdmin): ?>
        <article class="people-metric">
            <span class="people-metric-icon">⌑</span>
            <span class="metric-label">Administrators</span>
            <strong class="metric-value"><?= number_format($accountCounts['admin']) ?></strong>
            <span class="metric-note">Administrator access</span>
        </article>
        <article class="people-metric">
            <span class="people-metric-icon">⊘</span>
            <span class="metric-label">Inactive accounts</span>
            <strong class="metric-value"><?= number_format($accountCounts['inactive']) ?></strong>
            <span class="metric-note">Accounts currently disabled</span>
        </article>
    <?php endif; ?>
    <article class="people-metric <?= $isAdmin ? 'people-metric-alert' : '' ?>">
        <span class="people-metric-icon">↯</span>
        <span class="metric-label">Failed logins</span>
        <strong class="metric-value"><?= number_format($failedLogins) ?></strong>
        <span class="metric-note">Recorded unsuccessful attempts</span>
    </article>
</section>

<section class="people-content-grid">
    <article class="people-panel people-welcome-panel">
        <div class="people-panel-heading">
            <div><p class="dashboard-eyebrow">Access center</p><h2>People and login activity</h2></div>
            <span class="people-live-mark"><i></i> Connected</span>
        </div>
        <p class="people-panel-copy">This dashboard currently focuses on registration, user roles, account status, and sign-in history. Product, order, and shipping tools are kept out of the workspace while you build their database tables separately.</p>
        <a class="admin-action-button" href="users_security.php?tab=users">Open user accounts <span aria-hidden="true">→</span></a>
        <a class="admin-action-button secondary" style="margin-left:8px" href="products_preview.php">Preview product workspace <span aria-hidden="true">→</span></a>
    </article>

    <article class="people-panel people-quick-panel">
        <p class="dashboard-eyebrow">Your access</p>
        <div class="people-current-user">
            <span class="people-avatar"><?= admin_escape(strtoupper(substr($_SESSION['first_name'] ?? 'U', 0, 1))) ?></span>
            <div><strong><?= admin_escape($_SESSION['first_name'] ?? 'Team member') ?></strong><span><?= $isAdmin ? 'Administrator' : 'Staff member' ?></span></div>
        </div>
        <div class="people-permission-note"><?= $isAdmin
            ? 'You can add accounts, update account roles, reset passwords, and activate or deactivate users.'
            : 'You can review account and login information. Account changes are available to administrators only.' ?></div>
        <a class="people-text-link" href="users_security.php?tab=logins">Review login history <span aria-hidden="true">→</span></a>
    </article>

    <article class="people-panel people-recent-panel">
        <div class="people-panel-heading">
            <div><p class="dashboard-eyebrow">Latest records</p><h2>Recent sign-in attempts</h2></div>
            <a class="people-text-link" href="users_security.php?tab=logins">All logs →</a>
        </div>
        <?php if (!$recentLogins): ?>
            <div class="people-empty-state"><span>◷</span><strong>No login records yet</strong><p>Sign-in activity will appear here after someone logs in.</p></div>
        <?php else: ?>
            <div class="people-login-list">
                <?php foreach ($recentLogins as $login): ?>
                    <?php
                    $email = $login['email_tried'] ?? 'Unknown account';
                    $success = isset($login['success']) && (int)$login['success'] === 1;
                    $dateValue = '';
                    foreach (['created_at', 'login_at', 'attempted_at', 'date_time', 'timestamp'] as $dateColumn) {
                        if (!empty($login[$dateColumn])) { $dateValue = $login[$dateColumn]; break; }
                    }
                    ?>
                    <div class="people-login-row">
                        <span class="login-status-dot <?= $success ? 'is-success' : 'is-failed' ?>"></span>
                        <div class="people-login-main"><strong><?= admin_escape($email) ?></strong><span><?= $success ? 'Successful sign-in' : 'Unsuccessful attempt' ?></span></div>
                        <time><?= $dateValue !== '' ? admin_escape(date('M j, g:i A', strtotime($dateValue))) : '' ?></time>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</section>

<style>
    css
```
.dashboard-intro {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 20px;
    margin-bottom: 27px;
}

.dashboard-eyebrow {
    margin-bottom: 6px;
    color: var(--text-muted);
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

.dashboard-intro h2 {
    margin-bottom: 6px;
    font-size: clamp(1.8rem, 3vw, 2.55rem);
}

.dashboard-subtitle {
    color: var(--text-muted);
}

.role-chip {
    padding: 9px 15px;
    color: var(--navy);
    background: var(--yellow);
    border-radius: 22px;
    font-size: 0.8rem;
    font-weight: 700;
    white-space: nowrap;
}

[data-theme="dark"] .role-chip {
    color: var(--navy);
}

.dashboard-error {
    margin-bottom: 20px;
    padding: 14px 16px;
    color: #610000;
    background: #fff0f0;
    border: 1px solid #e6b6b6;
    border-radius: 10px;
}

[data-theme="dark"] .dashboard-error {
    color: #ffd7d7;
    background: #42252c;
    border-color: #78414b;
}

.people-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(175px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.people-metric,
.people-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.people-metric {
    position: relative;
    display: flex;
    flex-direction: column;
    min-height: 160px;
    padding: 20px;
    overflow: hidden;
}

.people-metric-icon {
    position: absolute;
    top: 12px;
    right: 16px;
    color: var(--navy);
    opacity: 0.13;
    font-size: 2.8rem;
}

[data-theme="dark"] .people-metric-icon {
    color: var(--yellow);
    opacity: 0.22;
}

.metric-label {
    color: var(--text-muted);
    font-size: 0.88rem;
    font-weight: 700;
}

.metric-value {
    margin: 12px 0 6px;
    color: var(--navy);
    font-size: 2rem;
    font-weight: 700;
}

[data-theme="dark"] .metric-value {
    color: var(--yellow);
}

    css
```
.metric-note {
    margin-top: auto;
    color: var(--text-muted);
    font-size: 0.8rem;
}

.people-metric-alert .metric-value {
    color: var(--red);
}

.people-content-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.45fr) minmax(250px, 0.8fr);
    gap: 18px;
}

.people-panel {
    min-width: 0;
    padding: clamp(19px, 3vw, 26px);
}

.people-panel-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.people-panel-heading h2 {
    margin: 0;
    font-size: 1.55rem;
}

.people-welcome-panel {
    background: linear-gradient(135deg, var(--surface), var(--bg));
}

.people-panel-copy {
    max-width: 700px;
    margin: 18px 0 22px;
    color: var(--text-muted);
    line-height: 1.7;
}

.people-live-mark {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--green);
    font-size: 0.78rem;
    font-weight: 700;
}

.people-live-mark i {
    width: 9px;
    height: 9px;
    background: var(--green);
    border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.12);
}

.people-quick-panel {
    display: flex;
    flex-direction: column;
}

.people-current-user {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 9px 0 16px;
}

.people-avatar {
    display: grid;
    place-items: center;
    width: 52px;
    height: 52px;
    color: var(--yellow);
    background: var(--navy);
    border-radius: 50%;
    font: 1.8rem 'Bebas Neue Custom', sans-serif;
}

.people-current-user strong,
.people-current-user span {
    display: block;
}

.people-current-user span:not(.people-avatar) {
    margin-top: 3px;
    color: var(--text-muted);
    font-size: 0.82rem;
}

.people-permission-note {
    margin-bottom: 16px;
    padding: 13px;
    color: var(--text-muted);
    background: var(--bg);
    border-radius: 10px;
    font-size: 0.84rem;
    line-height: 1.55;
}

.people-text-link {
    color: var(--navy);
    font-size: 0.84rem;
    font-weight: 700;
}

[data-theme="dark"] .people-text-link {
    color: var(--yellow);
}

   css
```
.people-text-link:hover {
    text-decoration: underline;
}

.people-recent-panel {
    grid-column: 1 / -1;
}

.people-login-list {
    display: grid;
}

.people-login-row {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 62px;
    border-top: 1px solid var(--border);
}

.login-status-dot {
    width: 10px;
    height: 10px;
    flex: 0 0 auto;
    border-radius: 50%;
}

.login-status-dot.is-success {
    background: var(--green);
}

.login-status-dot.is-failed {
    background: var(--red);
}

.people-login-main {
    flex: 1;
    min-width: 0;
}

.people-login-main strong,
.people-login-main span {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.people-login-main strong {
    font-size: 0.9rem;
}

.people-login-main span,
.people-login-row time {
    margin-top: 3px;
    color: var(--text-muted);
    font-size: 0.78rem;
}

.people-empty-state {
    display: grid;
    justify-items: center;
    padding: 30px;
    color: var(--text-muted);
    text-align: center;
}

.people-empty-state span {
    font-size: 2.2rem;
}

.people-empty-state strong {
    margin: 8px 0 4px;
    color: var(--text);
}

@media (max-width: 760px) {
    .people-content-grid {
        grid-template-columns: 1fr;
    }

    .people-recent-panel {
        grid-column: auto;
    }
}

@media (max-width: 560px) {
    .dashboard-intro {
        align-items: start;
        flex-direction: column;
    }

    .people-panel-heading {
        align-items: start;
    }

    .people-login-row time {
        font-size: 0.7rem;
        text-align: right;
    }
}
</style>
<?php admin_layout_end(); ?>

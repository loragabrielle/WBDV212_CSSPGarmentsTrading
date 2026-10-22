<?php
/* shared page frame for admin and staff dashboard pages. */
function admin_layout_start($pageTitle, $activePage) {
    $userName = htmlspecialchars($_SESSION['first_name'] ?? 'Team member', ENT_QUOTES, 'UTF-8');
    $role = $_SESSION['role'] ?? 'staff';
    $navItems = [
        ['Overview', $role === 'staff' ? 'staff_dashboard.php' : 'admin_dashboard.php', 'dashboard', '01'],
        ['User Accounts & Logs', 'users_security.php', 'users', '02'],
        ['Product Workspace', 'products_preview.php', 'products', '03']
    ];
    ?>
    <!DOCTYPE html>
    <html lang="en" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#1a3a5c">
        <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | CSSP Garments Trading</title>
        <link rel="stylesheet" href="CSS%20Files/Index_Style.css">
        <script>
            (function () {
                var savedTheme = localStorage.getItem('cssp-theme');
                document.documentElement.setAttribute('data-theme', savedTheme || 'light');
            })();
        </script>
        <style>
           css
```
.admin-shell {
    min-height: 100vh;
}

.admin-sidebar {
    position: fixed;
    inset: 0 auto 0 0;
    z-index: 30;
    display: flex;
    flex-direction: column;
    width: 264px;
    padding: 24px 16px;
    background: var(--navy);
    color: #fff;
    box-shadow: 8px 0 28px rgba(13, 27, 42, 0.12);
    transition: transform 0.25s ease;
}

.admin-brand {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 2px 8px 28px;
}

.admin-brand img {
    width: 48px;
    height: 48px;
    object-fit: contain;
}

.admin-brand-name {
    font: 1.4rem/1 'Bebas Neue Custom', sans-serif;
    letter-spacing: 0.04em;
}

.admin-brand-name span {
    display: block;
    margin-top: 4px;
    color: var(--yellow);
    font: 700 0.7rem 'Creato Display', sans-serif;
    letter-spacing: 0.08em;
}

.admin-nav-label {
    padding: 8px 12px;
    color: rgba(255, 255, 255, 0.58);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.admin-nav {
    display: grid;
    gap: 5px;
}

.admin-nav a {
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 48px;
    padding: 10px 12px;
    color: rgba(255, 255, 255, 0.82);
    border-radius: 10px;
    font-weight: 700;
    transition: background 0.2s ease, color 0.2s ease;
}

.admin-nav a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
}

.admin-nav a.active {
    color: var(--yellow);
    background: rgba(255, 255, 255, 0.11);
}

.admin-nav a.active::before {
    position: absolute;
    inset: 9px auto 9px 0;
    width: 4px;
    background: var(--yellow);
    border-radius: 0 4px 4px 0;
    content: '';
}

.admin-nav-number {
    width: 25px;
    color: rgba(255, 255, 255, 0.48);
    font: 1.1rem 'Bebas Neue Custom', sans-serif;
    text-align: center;
}

.admin-nav a.active .admin-nav-number {
    color: var(--yellow);
}

.admin-sidebar-bottom {
    display: grid;
    gap: 8px;
    margin-top: auto;
    padding-top: 20px;
}

.admin-sidebar-bottom a {
    display: flex;
    align-items: center;
    min-height: 46px;
    padding: 10px 12px;
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
}

.admin-sidebar-bottom a:hover {
    background: rgba(255, 255, 255, 0.1);
}

.admin-sidebar-bottom .shop-link {
    color: var(--yellow);
}

.admin-main {
    min-height: 100vh;
    margin-left: 264px;
}

.admin-topbar {
    position: sticky;
    top: 0;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 78px;
    padding: 12px clamp(18px, 4vw, 48px);
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    box-shadow: 0 3px 14px rgba(0, 0, 0, 0.04);
}

.admin-top-title {
    display: flex;
    align-items: center;
    gap: 14px;
}

.admin-top-title h1 {
    font-size: clamp(1.55rem, 3vw, 2.15rem);
}

.admin-top-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.admin-user {
    color: var(--text-muted);
    font-size: 0.92rem;
    font-weight: 700;
}

.admin-user strong {
    color: var(--text);
}

.admin-theme-button,
.admin-menu-button {
    display: inline-grid;
    place-items: center;
    width: 46px;
    height: 46px;
    color: var(--text);
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 50%;
    font-size: 1.1rem;
}

.admin-theme-button:hover,
.admin-menu-button:hover {
    color: var(--yellow);
    background: var(--navy);
}

.admin-menu-button {
    display: none;
}

.admin-content {
    width: min(1440px, 100%);
    margin: 0 auto;
    padding: clamp(20px, 4vw, 44px);
}

.admin-content h2 {
    margin-bottom: 16px;
    font-size: 1.55rem;
}

.admin-overlay {
    display: none;
}

.admin-confirm-backdrop {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
    place-items: center;
    padding: 18px;
    background: rgba(7, 17, 28, 0.62);
}

.admin-confirm-backdrop.open {
    display: grid;
}

.admin-confirm-card {
    width: min(440px, 100%);
    padding: 26px;
    color: var(--text);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
}

.admin-confirm-card h2 {
    margin: 0 0 8px;
    font-size: 1.7rem;
}

.admin-confirm-card p {
    margin-bottom: 22px;
    color: var(--text-muted);
}

.admin-confirm-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    flex-wrap: wrap;
}

.admin-action-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 10px 18px;
    color: var(--yellow);
    background: var(--navy);
    border: 2px solid var(--navy);
    border-radius: 24px;
    font-weight: 700;
}

.admin-action-button:hover {
    color: var(--navy);
    background: var(--yellow);
    border-color: var(--yellow);
}

.admin-action-button.secondary {
    color: var(--text);
    background: transparent;
    border-color: var(--border);
}

.admin-action-button.danger {
    color: #fff;
    background: var(--red);
    border-color: var(--red);
}

.admin-form-stack {
    display: grid;
    gap: 14px;
}

.admin-form-stack label,
.admin-field-label {
    display: grid;
    gap: 6px;
    color: var(--text-muted);
    font-size: 0.85rem;
    font-weight: 700;
}

.admin-form-stack input,
.admin-form-stack select,
.admin-form-stack textarea,
.admin-toolbar input,
.admin-toolbar select,
.admin-inline-form input,
.admin-inline-form select {
    width: 100%;
    min-height: 44px;
    padding: 10px 12px;
    color: var(--text);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    font: inherit;
}

           css
```
.admin-form-stack textarea {
    min-height: 100px;
    resize: vertical;
}

.admin-toolbar {
    display: flex;
    align-items: end;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}

.admin-toolbar label {
    flex: 1 1 180px;
    display: grid;
    gap: 6px;
    color: var(--text-muted);
    font-size: 0.82rem;
    font-weight: 700;
}

.admin-data-card {
    overflow: hidden;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.admin-data-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.admin-data-table th {
    padding: 13px 15px;
    color: var(--text-muted);
    background: var(--bg);
    font-size: 0.74rem;
    letter-spacing: 0.07em;
    text-transform: uppercase;
}

.admin-data-table td {
    padding: 14px 15px;
    border-top: 1px solid var(--border);
    vertical-align: middle;
}

.admin-row-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.admin-empty {
    padding: 32px 18px;
    color: var(--text-muted);
    text-align: center;
}

.admin-tabs {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    margin: 0 0 20px;
    padding-bottom: 4px;
}

.admin-tab {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 10px 17px;
    color: var(--text-muted);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 24px;
    font-weight: 700;
    white-space: nowrap;
}

.admin-tab.active,
.admin-tab:hover {
    color: var(--yellow);
    background: var(--navy);
    border-color: var(--navy);
}

.admin-modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 1000;
    display: none;
    overflow-y: auto;
    place-items: center;
    padding: 18px;
    background: rgba(7, 17, 28, 0.62);
}

.admin-modal-backdrop.open {
    display: grid;
}

.admin-modal-card {
    width: min(720px, 100%);
    max-height: calc(100vh - 36px);
    overflow-y: auto;
    padding: 24px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
}

.admin-modal-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.admin-modal-heading h2 {
    margin: 0;
}

.admin-icon-button {
    display: inline-grid;
    place-items: center;
    width: 44px;
    height: 44px;
    color: var(--text);
    border: 1px solid var(--border);
    border-radius: 50%;
}

.admin-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
}

.admin-alert {
    margin-bottom: 18px;
    padding: 14px 16px;
    color: var(--text);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
}

.admin-thumbnail {
    width: 54px;
    height: 54px;
    object-fit: cover;
    background: var(--bg);
    border-radius: 8px;
}

.admin-variant-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr)) 44px;
    gap: 8px;
    align-items: center;
    margin-bottom: 8px;
}

@media (max-width: 900px) {
    .admin-sidebar {
        transform: translateX(-105%);
    }

    .admin-shell.menu-open .admin-sidebar {
        transform: translateX(0);
    }

    .admin-shell.menu-open .admin-overlay {
        position: fixed;
        inset: 0;
        z-index: 25;
        display: block;
        background: rgba(6, 18, 30, 0.56);
    }

    .admin-main {
        margin-left: 0;
    }

    .admin-menu-button {
        display: inline-grid;
    }
}

@media (max-width: 560px) {
    .admin-topbar {
        min-height: 68px;
        padding-inline: 14px;
    }

    .admin-top-title {
        gap: 9px;
    }

    .admin-top-actions {
        gap: 7px;
    }

    .admin-user {
        max-width: 92px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.8rem;
    }

    .admin-content {
        padding: 20px 14px 36px;
    }
}

@media (max-width: 720px) {
    .admin-data-table,
    .admin-data-table tbody,
    .admin-data-table tr,
    .admin-data-table td {
        display: block;
        width: 100%;
    }

    .admin-data-table thead {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
    }

    .admin-data-table tr {
        padding: 8px 14px;
        border-bottom: 1px solid var(--border);
    }

    .admin-data-table td {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 9px 0;
        border: 0;
        text-align: right;
    }

    .admin-data-table td::before {
        color: var(--text-muted);
        content: attr(data-label);
        font-size: 0.76rem;
        font-weight: 700;
        text-align: left;
    }

    .admin-data-table td:has(.admin-row-actions) {
        display: block;
    }

    .admin-data-table td:has(.admin-row-actions)::before {
        display: block;
        margin-bottom: 8px;
    }

    .admin-variant-row {
        grid-template-columns: 1fr 1fr 1fr 44px;
    }
}

@media (max-width: 440px) {
    .admin-variant-row {
        grid-template-columns: 1fr 1fr;
    }

    .admin-variant-row input:nth-child(3) {
        grid-column: 1 / 2;
    }
}

@media print {
    .admin-sidebar,
    .admin-topbar,
    .admin-overlay {
        display: none !important;
    }

    .admin-main {
        margin: 0;
    }
}
        </style>
    </head>
    <body>
    <div class="admin-shell" id="adminShell">
        <aside class="admin-sidebar" id="adminSidebar" aria-label="Dashboard navigation">
            <a class="admin-brand" href="admin_dashboard.php">
                <img src="Assets/logo-light-text.png" alt="">
                <span class="admin-brand-name">CSSP Garments<span>TRADING DASHBOARD</span></span>
            </a>
            <p class="admin-nav-label">Workspace</p>
            <nav class="admin-nav">
                <?php foreach ($navItems as $item): ?>
                    <a href="<?= htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8') ?>"
                       class="<?= $activePage === $item[2] ? 'active' : '' ?>"
                       <?= $activePage === $item[2] ? 'aria-current="page"' : '' ?>>
                        <span class="admin-nav-number"><?= htmlspecialchars($item[3], ENT_QUOTES, 'UTF-8') ?></span>
                        <span><?= htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
            <div class="admin-sidebar-bottom">
                <a class="shop-link" href="index.php">← &nbsp; Back to shop</a>
                <a href="logout.php">↪ &nbsp; Logout</a>
            </div>
        </aside>
        <button class="admin-overlay" id="adminOverlay" type="button" aria-label="Close navigation"></button>
        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-top-title">
                    <button class="admin-menu-button" id="adminMenuButton" type="button" aria-label="Open navigation" aria-expanded="false">☰</button>
                    <h1><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></h1>
                </div>
                <div class="admin-top-actions">
                    <span class="admin-user">Signed in as <strong><?= $userName ?></strong></span>
                    <button class="admin-theme-button" id="adminThemeButton" type="button" aria-label="Toggle dark mode" title="Toggle dark mode">◐</button>
                </div>
            </header>
            <main class="admin-content">
    <?php
}

function admin_layout_end() {
    ?>
            </main>
        </div>
    </div>
    <?php include __DIR__ . '/toast.php'; ?>
    <div class="admin-confirm-backdrop" id="adminConfirmBackdrop" role="dialog" aria-modal="true" aria-labelledby="adminConfirmTitle">
        <div class="admin-confirm-card">
            <h2 id="adminConfirmTitle">Please confirm</h2>
            <p id="adminConfirmMessage">Are you sure you want to continue?</p>
            <div class="admin-confirm-actions">
                <button class="admin-action-button secondary" type="button" id="adminConfirmCancel">Go back</button>
                <button class="admin-action-button danger" type="button" id="adminConfirmAccept">Continue</button>
            </div>
        </div>
    </div>
    <script>
        (function () {
            var shell = document.getElementById('adminShell');
            var menuButton = document.getElementById('adminMenuButton');
            var overlay = document.getElementById('adminOverlay');
            var themeButton = document.getElementById('adminThemeButton');
            var confirmBackdrop = document.getElementById('adminConfirmBackdrop');
            var confirmMessage = document.getElementById('adminConfirmMessage');
            var confirmAccept = document.getElementById('adminConfirmAccept');
            var pendingForm = null;

            function closeMenu() {
                shell.classList.remove('menu-open');
                menuButton.setAttribute('aria-expanded', 'false');
            }

            menuButton.addEventListener('click', function () {
                var isOpen = shell.classList.toggle('menu-open');
                menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
            overlay.addEventListener('click', closeMenu);
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeMenu();
            });

            document.addEventListener('submit', function (event) {
                var form = event.target;
                if (!form.matches('form[data-confirm-message]')) return;
                if (form.dataset.confirmed === 'true') {
                    form.dataset.confirmed = 'false';
                    return;
                }
                event.preventDefault();
                pendingForm = form;
                confirmMessage.textContent = form.dataset.confirmMessage;
                confirmBackdrop.classList.add('open');
            });

            document.getElementById('adminConfirmCancel').addEventListener('click', function () {
                pendingForm = null;
                confirmBackdrop.classList.remove('open');
            });
            confirmAccept.addEventListener('click', function () {
                if (!pendingForm) return;
                pendingForm.dataset.confirmed = 'true';
                confirmBackdrop.classList.remove('open');
                confirmAccept.disabled = true;
                confirmAccept.textContent = 'Working...';
                pendingForm.requestSubmit();
                window.setTimeout(function () {
                    confirmAccept.disabled = false;
                    confirmAccept.textContent = 'Continue';
                }, 1200);
                pendingForm = null;
            });

            document.addEventListener('submit', function (event) {
                var submitButton = event.target.querySelector('button[type="submit"], input[type="submit"]');
                if (!submitButton || event.target.matches('form[data-confirm-message]')) return;
                submitButton.dataset.originalLabel = submitButton.textContent;
                submitButton.disabled = true;
                if (submitButton.tagName === 'BUTTON') submitButton.textContent = 'Working...';
            });

            document.querySelectorAll('[data-modal-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var modal = document.getElementById(button.dataset.modalOpen);
                    if (modal) modal.classList.add('open');
                });
            });
            document.querySelectorAll('[data-modal-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    button.closest('.admin-modal-backdrop').classList.remove('open');
                });
            });

            themeButton.addEventListener('click', function () {
                var nextTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', nextTheme);
                localStorage.setItem('cssp-theme', nextTheme);
            });
        })();
    </script>
    </body>
    </html>
    <?php
}

<?php
/* includes/toast.php - the lower-left notification (replaces alert()).
   Put <?php include 'includes/toast.php'; ?> just before </body> on any page that should show messages.
   PHP handlers send a message with flash_redirect() (see database.php); this file shows it once.
   JavaScript can also call:  showToast('error' | 'success' | 'info', 'Title', 'Message'); */
$flash = null;
if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);                       // show it only once
}
?>
<style>
#toastContainer {
    position: fixed; left: 24px; bottom: 24px; z-index: 9999;
    display: flex; flex-direction: column; gap: 12px;
    width: min(380px, calc(100vw - 32px));
    pointer-events: none;
}
.toast {
    --accent: #e63946;
    pointer-events: auto;
    display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: 14px;
    padding: 14px 16px;
    background: var(--surface, #fff); color: var(--text, #111);
    border: 1px solid var(--border, #e0e0d8); border-left: 5px solid var(--accent);
    border-radius: 12px; box-shadow: 0 12px 32px rgba(0, 0, 0, 0.22);
    opacity: 0; transform: translateX(-28px);
    animation: toastIn 0.45s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
.toast.success { --accent: #2d6a4f; }
.toast.info    { --accent: #1a3a5c; }
.toast.out { animation: toastOut 0.3s ease forwards; }
.toast-icon { display: grid; place-items: center; width: 34px; height: 34px; border-radius: 50%; background: var(--accent); }
.toast-icon svg { width: 18px; height: 18px; fill: none; stroke: #fff; stroke-width: 2.4; stroke-linecap: round; stroke-linejoin: round; }
.toast-title { font-weight: 700; font-size: 0.95rem; }
.toast-msg { margin-top: 2px; font-size: 0.85rem; line-height: 1.4; color: var(--text-muted, #555); }
.toast-close { width: 28px; height: 28px; border: 0; background: none; color: var(--text-muted, #555); font-size: 1.3rem; line-height: 1; cursor: pointer; border-radius: 50%; }
.toast-close:hover { background: rgba(128, 128, 128, 0.18); }
@keyframes toastIn  { to { opacity: 1; transform: none; } }
@keyframes toastOut { to { opacity: 0; transform: translateX(-28px); } }
@media (max-width: 640px) { #toastContainer { left: 16px; bottom: calc(16px + env(safe-area-inset-bottom)); } }
@media (prefers-reduced-motion: reduce) { .toast, .toast.out { animation-duration: 0.01s; } }
</style>

<div id="toastContainer" role="status" aria-live="polite"></div>

<script>
(function () {
    var ICONS = {
        error:   '<svg viewBox="0 0 24 24"><path d="M12 4 2.5 20h19L12 4z"/><path d="M12 10v4M12 17.2v.1"/></svg>',
        success: '<svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>',
        info:    '<svg viewBox="0 0 24 24"><path d="M12 11v6M12 7.2v.1"/></svg>'
    };
    window.showToast = function (type, title, message, ms) {
        type = ICONS[type] ? type : 'info';
        var box = document.getElementById('toastContainer');
        var el = document.createElement('div');
        el.className = 'toast ' + type;
        el.innerHTML = '<span class="toast-icon">' + ICONS[type] + '</span><div><div class="toast-title"></div><div class="toast-msg"></div></div><button type="button" class="toast-close" aria-label="Close">&times;</button>';
        el.querySelector('.toast-title').textContent = title || '';      // textContent = safe, no HTML injection
        el.querySelector('.toast-msg').textContent = message || '';
        box.appendChild(el);
        if (box.children.length > 4) box.firstElementChild.remove();
        var timer;
        function close() { clearTimeout(timer); el.classList.add('out'); setTimeout(function () { el.remove(); }, 300); }
        function start() { timer = setTimeout(close, ms || 5000); }
        el.querySelector('.toast-close').addEventListener('click', close);
        el.addEventListener('mouseenter', function () { clearTimeout(timer); });
        el.addEventListener('mouseleave', start);
        start();
    };
<?php if ($flash): ?>
    showToast(<?= json_encode($flash['type']) ?>, <?= json_encode($flash['title']) ?>, <?= json_encode($flash['msg']) ?>);
<?php endif; ?>
})();
</script>
/* Nav_Script.js - navbar behaviour for pages that do NOT load Index_Script.js (login, registration, ...).
   Same behaviour as your index navbar: mega menus, hamburger, search toggle, theme toggle, currency. */
(function () {
    'use strict';
    var $ = function (id) { return document.getElementById(id); };
    var html = document.documentElement;

    /* real header height -> used by the phone menu and the no-scroll login card */
    function setHeaderHeight() {
        var h = $('siteHeader');
        if (h) html.style.setProperty('--hdr-h', h.offsetHeight + 'px');
    }
    setHeaderHeight();
    window.addEventListener('resize', setHeaderHeight);
    window.addEventListener('load', setHeaderHeight);

    /* ticker: duplicate the items so the loop is seamless */
    var ticker = $('tickerTrack');
    if (ticker) ticker.innerHTML += ticker.innerHTML;

    /* mega menus (Products / About Us) */
    var megaItems = document.querySelectorAll('.nav-item.has-mega');
    function closeMegas(except) {
        megaItems.forEach(function (i) {
            if (i === except) return;
            i.classList.remove('nav-open');
            i.querySelector('.nav-link').setAttribute('aria-expanded', 'false');
        });
    }
    megaItems.forEach(function (item) {
        var btn = item.querySelector('.nav-link');
        btn.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            var open = !item.classList.contains('nav-open');
            closeMegas(item);
            item.classList.toggle('nav-open', open);
            btn.setAttribute('aria-expanded', String(open));
        });
    });
    document.addEventListener('click', function () { closeMegas(null); });

    /* hamburger */
    var burger = $('hamburger'), nav = $('mainNav');
    function setMenu(open) {
        if (!burger || !nav) return;
        nav.classList.toggle('open', open);
        burger.classList.toggle('open', open);
        burger.setAttribute('aria-expanded', String(open));
        document.body.style.overflow = open && window.innerWidth <= 768 ? 'hidden' : '';
    }
    if (burger) burger.addEventListener('click', function () { setMenu(!nav.classList.contains('open')); });
    if (nav) nav.addEventListener('click', function (e) {          // tapping a real link closes the menu
        var a = e.target.closest('a');
        if (a && a.getAttribute('href') && a.getAttribute('href') !== '#') setMenu(false);
    });
    window.addEventListener('resize', function () { if (window.innerWidth > 768) setMenu(false); });

    /* search bar */
    var sBtn = $('searchToggle'), sBar = $('searchBar'), sInput = $('searchInput');
    if (sBtn && sBar) {
        sBtn.addEventListener('click', function () {
            var open = sBar.classList.toggle('open');
            sBtn.setAttribute('aria-expanded', String(open));
            if (open && sInput) sInput.focus();
        });
        if (sInput) sInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && sInput.value.trim()) window.location.href = 'products.php?search=' + encodeURIComponent(sInput.value.trim());
        });
    }

    /* Esc closes everything */
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        closeMegas(null); setMenu(false);
        if (sBar) sBar.classList.remove('open');
    });

    /* theme toggle (same storage key as your index page) */
    var tBtn = $('themeToggle'), tIcon = $('themeIcon');
    function applyTheme(t) {
        html.setAttribute('data-theme', t);
        if (tIcon) tIcon.className = t === 'dark' ? 'fa-solid fa-moon' : 'fa-solid fa-sun';
    }
    applyTheme(localStorage.getItem('cssp-theme') || 'light');
    if (tBtn) tBtn.addEventListener('click', function () {
        var next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
        localStorage.setItem('cssp-theme', next);
        applyTheme(next);
    });

    /* currency dropdown (desktop). The phone buttons in header.php click these same <li> items. */
    var cBtn = $('currencyBtn'), cMenu = $('currencyDropdown'), cLabel = $('activeCurrency');
    if (cBtn && cMenu) {
        cBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = cMenu.classList.toggle('open');
            cBtn.setAttribute('aria-expanded', String(open));
        });
        document.addEventListener('click', function () { cMenu.classList.remove('open'); });
        cMenu.querySelectorAll('li').forEach(function (li) {
            li.addEventListener('click', function () {
                if (cLabel) cLabel.textContent = li.dataset.currency;
                localStorage.setItem('cssp-currency', li.dataset.currency);
                cMenu.classList.remove('open');
            });
        });
        var saved = localStorage.getItem('cssp-currency');
        if (saved && cLabel) cLabel.textContent = saved;
    }
})();
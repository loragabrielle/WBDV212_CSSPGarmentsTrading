/* auth.js - login/registration behaviour (plain JavaScript, no libraries) */
(function () {
    'use strict';
    var auth = document.getElementById('auth');
    if (!auth) return;

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isPhone = function () { return window.matchMedia('(max-width: 640px)').matches; };

    /* ---------- 1. Switch between Login and Sign up without a page reload ---------- */
    /* Desktop: if the active form is taller than the card, shrink it slightly so nothing is cut off
       and no scrollbar is ever needed. Phones/tablets scroll the page normally. */
    function fitForm(mode) {
        var stack = document.querySelector('.forms-stack'), panel = document.getElementById('formPanel');
        stack.style.zoom = '';
        if (window.innerWidth <= 1024) return;
        var cs = getComputedStyle(panel);
        var room = panel.clientHeight - parseFloat(cs.paddingTop) - parseFloat(cs.paddingBottom);
        var form = document.getElementById(mode === 'login' ? 'loginForm' : 'registerForm');
        var z = Math.max(0.55, Math.min(1, room / form.offsetHeight));
        if (z < 1) stack.style.zoom = z.toFixed(3);
    }
    window.addEventListener('load', function () { fitForm(auth.dataset.mode); });
    window.addEventListener('resize', function () { fitForm(auth.dataset.mode); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { fitForm(auth.dataset.mode); });

    var locked = false;
    function setMode(mode, href, push) {
        if (locked || auth.dataset.mode === mode) return;
        locked = true; setTimeout(function () { locked = false; }, reduceMotion ? 0 : 1100);
        auth.classList.remove('mode-login', 'mode-register');
        auth.classList.add('mode-' + mode);
        auth.dataset.mode = mode;
        fitForm(mode);
        document.title = (mode === 'login' ? 'Log in' : 'Sign up') + ' | CSSP Garments Trading';
        if (push) history.pushState({ mode: mode }, '', href);

        if (isPhone() && !reduceMotion) {            // phone: the sheet slides up
            var sheet = document.getElementById('formPanel');
            sheet.classList.remove('anim-up'); void sheet.offsetWidth; sheet.classList.add('anim-up');
        }
        // after the slide, put the cursor in the first field of the visible form
        setTimeout(function () {
            var first = document.querySelector('.mode-' + mode + ' #' + (mode === 'login' ? 'loginForm' : 'registerForm') + ' input:not([readonly])');
            if (first && !isPhone()) first.focus({ preventScroll: true });
        }, reduceMotion ? 0 : 1050);
    }

    document.querySelectorAll('[data-switch]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (e.ctrlKey || e.metaKey || e.shiftKey) return;   // let "open in new tab" work
            e.preventDefault();                                  // no JS = normal link, so this is a safe upgrade
            setMode(link.dataset.switch, link.getAttribute('href'), true);
        });
    });
    window.addEventListener('popstate', function () {            // back/forward buttons
        setMode(/registration/.test(location.pathname) ? 'register' : 'login', location.href, false);
    });

    /* ---------- 2. Show / hide password ---------- */
    document.querySelectorAll('[data-toggle-pw]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = btn.parentElement.querySelector('input');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            btn.firstElementChild.className = show ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        });
    });

    /* ---------- 3. Age from birthday ---------- */
    var birthday = document.getElementById('r_birthday');
    var age = document.getElementById('r_age');
    function calcAge(value) {
        if (!value) return null;
        var b = new Date(value), t = new Date();
        var a = t.getFullYear() - b.getFullYear();
        var m = t.getMonth() - b.getMonth();
        if (m < 0 || (m === 0 && t.getDate() < b.getDate())) a--;
        return a;
    }
    birthday.max = new Date().toISOString().split('T')[0];     // no future dates
    function updateAge() { var a = calcAge(birthday.value); age.value = (a !== null && a >= 0) ? a : ''; }
    birthday.addEventListener('input', updateAge);
    updateAge();

    /* ---------- 4. Validation ---------- */
    var rules = {
        l_email:    function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); },
        l_password: function (v) { return v.length > 0; },
        r_first:    function (v) { return v.trim().length > 0; },
        r_last:     function (v) { return v.trim().length > 0; },
        r_birthday: function (v) { var a = calcAge(v); return a !== null && a >= 18 && a < 120; },
        r_gender:   function (v) { return v !== ''; },
        r_phone:    function (v) { return /^[0-9+\-\s()]{7,15}$/.test(v); },
        r_email:    function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); },
        r_address:  function (v) { return v.trim().length >= 8; },
        r_password: function (v) { return v.length >= 8 && /[A-Za-z]/.test(v) && /\d/.test(v); },
        r_confirm:  function (v) { return v !== '' && v === document.getElementById('r_password').value; }
    };

    function check(input) {
        var rule = rules[input.id];
        if (!rule) return true;
        var ok = rule(input.value);
        var field = input.closest('.field');
        field.classList.toggle('invalid', !ok);
        field.classList.toggle('valid', ok && input.value !== '');
        return ok;
    }

    Object.keys(rules).forEach(function (id) {
        var input = document.getElementById(id);
        input.addEventListener('blur', function () { check(input); });
        input.addEventListener('input', function () {
            if (input.closest('.field').classList.contains('invalid')) check(input);   // clear the error as they fix it
        });
    });
    document.getElementById('r_birthday').addEventListener('change', function () { check(this); });

    /* password strength meter + re-check the confirm box */
    var meter = document.getElementById('pwMeter');
    document.getElementById('r_password').addEventListener('input', function () {
        var v = this.value, score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) score++;
        if (/\d/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        meter.dataset.level = v ? Math.max(score, 1) : 0;
        var confirm = document.getElementById('r_confirm');
        if (confirm.value) check(confirm);
    });

    /* submit: stop if invalid, otherwise show the loading spinner and let PHP take over */
    document.querySelectorAll('.auth-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var firstBad = null;
            form.querySelectorAll('input, select').forEach(function (input) {
                if (rules[input.id] && !check(input) && !firstBad) firstBad = input;
            });
            if (firstBad) { e.preventDefault(); firstBad.focus(); return; }
            form.querySelector('button[type="submit"]').classList.add('loading');
        });
    });
})();
<?php
/* includes/header.php - shared ticker + navbar. Put right after <body> on EVERY page:
     <?php include 'includes/header.php'; ?>
   Set $hideTicker = true; before the include to hide the ticker (login pages do this). */
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$isLoggedIn = !empty($_SESSION['user_id']);
$firstName  = $_SESSION['first_name'] ?? '';
?>
    <?php if (empty($hideTicker)): ?>
    <!-- PRE-HEADER INFINITE TICKER-->
    <div class="pre-header" aria-label="Delivery and service info">
        <div class="ticker-track" id="tickerTrack">
            <span><i class="fa-solid fa-ship"></i> National Delivery: 3 Days</span>
            <span><i class="fa-solid fa-map-location-dot"></i> Provincial Delivery: 5 Days</span>
            <span><i class="fa-solid fa-globe"></i> International Shipping: 1 Week</span>
            <span><i class="fa-solid fa-headset"></i> Customer Service: 7AM – 7PM</span>
            <span><i class="fa-solid fa-shield-halved"></i> 100% Secure Checkout</span>
            <span><i class="fa-solid fa-box-open"></i> Welcome Offer: Free Shipping</span>
          
            <span><i class="fa-solid fa-percent"></i> Save 10% with code CSSP10</span>
            <span><i class="fa-solid fa-tags"></i> FREESHIP (Free Delivery)</span>
            <span><i class="fa-solid fa-gift"></i> Claims: FREESHIP for Free Delivery • CSSP10 for 10% Off</span>
        </div>
    </div>

<?php endif; ?>

    <!-- HEADER/NAVIGATION -->
    <header class="site-header" id="siteHeader">
        <div class="header-inner">
            <!-- LOGO -->
            <a href="./index.php" class="logo-wrap" aria-label="CSSP Garments Trading homepage">
                <div class="logo-icon">
                    <img src="./Assets/logo-light-text.png" class="logo-img light-logo" alt="CSSP Garments Trading logo, light version" />
                    <img src="./Assets/logo-dark-text.png" class="logo-img dark-logo" alt="CSSP Garments Trading logo, dark version" />
                </div>
                <div class="logo-text">CSSP<span>Garments&nbsp;Trading</span></div>
            </a>

            <nav class="main-nav" id="mainNav" aria-label="Main navigation">

                <ul class="nav-list">

                    <!-- products mega menu -->
                    <li class="nav-item has-mega" id="navProducts">
                        <a href="#" class="nav-link" id="navProductsBtn" aria-haspopup="true" aria-expanded="false">
                            Products <i class="fa-solid fa-chevron-down nav-caret"></i>
                        </a>

                        <div class="mega-menu" id="megaProducts" aria-hidden="true">
                            <div class="mega-inner">        
                                <div class="mega-col">                         
                                    <span class="mega-label">Uniforms</span>                        
                                    <div class="mega-feature-card">                        
                                        <img src="./Assets/UNIFORM_MEGA MENU.png" alt="Maritime and culinary uniform range including coveralls and chef tops" />                        
                                        <p>Maritime &amp; Culinary Uniforms</p>                           
                                        <a href="products.php#uniforms" class="btn-sm">Gear Up</a>                           
                                    </div>                      
                                </div>
                          
                                <div class="mega-divider"></div>
                               
                                <div class="mega-col">                              
                                    <span class="mega-label">Safety Footwear</span>                              
                                    <div class="mega-feature-card">                              
                                        <img src="./Assets/SAFETYFOOTWEAR_MEGA MENU.png" alt="Steel-toe safety shoe for deck and industrial use" />                               
                                        <p>Steel-toe Safety Shoe</p>                              
                                        <a href="products.php#safety-footwears" class="btn-sm">Secure Step</a>                             
                                    </div>                           
                                </div>               
                            </div>                 
                        </div>               
                    </li>
              
                    <!-- about Us mega menu -->
                    <li class="nav-item has-mega" id="navAbout">              
                        <a href="#" class="nav-link" id="navAboutBtn" aria-haspopup="true" aria-expanded="false">              
                            About Us <i class="fa-solid fa-chevron-down nav-caret"></i>
                        </a>

                        <div class="mega-menu" id="megaAbout" aria-hidden="true">              
                            <div class="mega-inner">              
                                <div class="mega-col">              
                                    <span class="mega-label">Company</span>            
                                    <a href="./aboutus.php#history" class="mega-item text-only"><i class="fa-solid fa-anchor"></i> Our Story</a>            
                                    <a href="./aboutus.php#people" class="mega-item text-only"><i class="fa-solid fa-users"></i> Our Team</a>
                                    <a href="./aboutus.php#tailor" class="mega-item text-only"><i class="fa-solid fa-house"></i> Location</a>
                                </div>
              
                                <div class="mega-divider"></div>             
                                <div class="mega-col">             
                                    <span class="mega-label">Support</span>              
                                    <a href="./index.php#faq" class="mega-item text-only"><i class="fa-solid fa-circle-question"></i> FAQ</a>              
                                    <a href="./contacts.php" class="mega-item text-only"><i class="fa-solid fa-envelope"></i> Contact Us</a>
                                    <a href="./policies.php" class="mega-item text-only"><i class="fa-solid fa-file-contract"></i> Policies</a>
                                </div>              
                            </div>              
                        </div>             
                    </li>             
                </ul>
                            <!-- PHONE ONLY: currency lives inside the hamburger -->
                <div class="nav-extra nav-currency-m" role="group" aria-label="Currency">
                    <span class="nav-extra-label"><i class="fa-solid fa-coins"></i> Currency</span>
                    <div class="cur-pills">
                        <button type="button" data-cur="PHP">🇵🇭 PHP</button>
                        <button type="button" data-cur="USD">🇺🇸 USD</button>
                        <button type="button" data-cur="GBP">🇬🇧 GBP</button>
                    </div>
                </div>
            </nav>

            <!-- NAVBAR ICONS -->
            <div class="header-actions">

                <!-- Currency switcher -->
                <div class="currency-switcher" id="currencySwitcher">        
                    <button class="currency-btn" id="currencyBtn" aria-label="Change currency" aria-expanded="false">         
                        <i class="fa-solid fa-coins"></i>         
                        <span id="activeCurrency">PHP</span>           
                        <i class="fa-solid fa-chevron-down"></i>         
                    </button>           

                    <ul class="currency-dropdown" id="currencyDropdown">           
                        <li data-currency="PHP" data-symbol="₱">🇵🇭 PHP</li>
                        <li data-currency="USD" data-symbol="$">🇺🇸 USD</li>
                        <li data-currency="GBP" data-symbol="£">🇬🇧 GBP</li>
                    </ul>      
                </div>
        
        
        
        
                <button class="icon-btn" id="searchToggle" title="Search" aria-label="Toggle search">         
                    <i class="fa-solid fa-magnifying-glass"></i>         
                </button>

                <button class="theme-toggle" id="themeToggle" title="Toggle theme" aria-label="Toggle colour theme">           
                    <i class="fa-solid fa-sun" id="themeIcon"></i>      
                </button>

                <a class="icon-btn" title="Cart" aria-label="View cart" id="cartIconBtn" href="cart.php">           
                    <i class="fa-solid fa-cart-shopping"></i>           
                    <span class="badge" id="cartBadge">0</span>         
                </a>

                <!-- ACCOUNT MENU: last icon before the hamburger -->
                <div class="account-menu" id="accountMenu">
                    <button class="icon-btn account-btn" id="accountBtn" type="button" aria-haspopup="true" aria-expanded="false"
                            aria-label="<?= $isLoggedIn ? 'Account menu' : 'Login or create account' ?>">
                        <?php if ($isLoggedIn): ?>
                            <i class="fa-solid fa-circle-user"></i>
                            <span class="account-name"><?= htmlspecialchars($firstName) ?></span>
                        <?php else: ?>
                            <i class="fa-solid fa-right-to-bracket"></i>
                        <?php endif; ?>
                    </button>
                    <ul class="account-dropdown" id="accountDropdown" role="menu">
                        <?php if ($isLoggedIn): ?>
                            <li role="none"><a role="menuitem" href="account.php"><i class="fa-solid fa-user"></i> Account</a></li>
                            <li role="none"><a role="menuitem" href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                        <?php else: ?>
                            <li role="none"><a role="menuitem" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
                            <li role="none"><a role="menuitem" href="registration.php"><i class="fa-solid fa-user-plus"></i> Create account</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">          
                    <span></span><span></span><span></span>         
                </button>    
            </div>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-bar" id="searchBar" role="search">
            <input type="search" id="searchInput" placeholder="Search uniforms, PPE, safety shoes…" autocomplete="off" aria-label="Search products" />  
            <button aria-label="Submit search"><i class="fa-solid fa-magnifying-glass"></i></button>
            <div class="search-results" id="searchResults" aria-live="polite"></div> 
        </div>
    </header>

<script>
/* Navbar extras: desktop account dropdown + phone currency buttons (works on every page) */
(function () {
    /* account dropdown: click to open, outside click or Esc closes */
    var wrap = document.getElementById('accountMenu'), btn = document.getElementById('accountBtn'), menu = document.getElementById('accountDropdown');
    if (wrap && btn) {
        var setOpen = function (o) { menu.classList.toggle('open', o); btn.setAttribute('aria-expanded', o ? 'true' : 'false'); };
        btn.addEventListener('click', function (e) { e.stopPropagation(); setOpen(!menu.classList.contains('open')); });
        document.addEventListener('click', function (e) { if (!wrap.contains(e.target)) setOpen(false); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { setOpen(false); btn.focus(); } });
    }
    /* phone currency buttons just "click" the real currency list, so your existing price code still runs */
    var pills = document.querySelectorAll('.cur-pills button'), label = document.getElementById('activeCurrency');
    if (pills.length && label) {
        var sync = function () { var c = label.textContent.trim(); pills.forEach(function (p) { p.classList.toggle('active', p.dataset.cur === c); }); };
        pills.forEach(function (p) {
            p.addEventListener('click', function (e) {
                e.stopPropagation();
                var li = document.querySelector('#currencyDropdown li[data-currency="' + p.dataset.cur + '"]');
                if (li) li.click();
                sync();
            });
        });
        new MutationObserver(sync).observe(label, { childList: true, characterData: true, subtree: true });
        sync();
    }
})();
</script>
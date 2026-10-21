<!DOCTYPE html>
<html lang="en" data-theme="light"> 
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CSSP Garments Trading</title>

        <link rel="icon" type="image/png" href="Assets/logo-light-text.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="CSS Files/Products_Style.css">

        <!-- FontAwesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    
        <script src="https://kit.fontawesome.com/493ae0299a.js" crossorigin="anonymous"></script>

        <style>
            
            /* ============================== MY ACCOUNT DROPDOWN ============================== */
            .account-menu {
                position: relative;
                display: flex;
                align-items: center;
            }

            .account-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                cursor: pointer;
            }

            .account-btn .fa-circle-user {
                font-size: 1.25rem;
            }

            .account-dropdown {
                position: absolute;
                top: calc(100% + 12px);
                right: 0;
                width: 220px;
                padding: 8px;
                background: var(--bg, #ffffff);
                border-radius: 10px;

                opacity: 0;
                visibility: hidden;
                transform: translateY(8px);
                transition: opacity 0.2s ease,
                            transform 0.2s ease,
                            visibility 0.2s ease;
                z-index: 1000;
            }

            .account-menu.open .account-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .account-dropdown-header {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px;
                color: #1a3a5c;
                font-weight: 700;
                border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            }

            .account-dropdown-header i {
                font-size: 1.3rem;
            }

            .account-dropdown-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px;
                color: #2a4060;
                text-decoration: none;
                font-size: 0.95rem;
                border-radius: 6px;
                transition: background 0.2s ease,
                            color 0.2s ease;
            }

            .account-dropdown-item i {
                width: 18px;
                text-align: center;
            }

            .account-dropdown-item:hover {
                background: rgba(244, 208, 63, 0.15);
                color: var(--yellow, #f4d03f);
            }

            .account-dropdown-divider {
                height: 1px;
                margin: 5px 0;
                background: rgba(255, 255, 255, 0.15);
            }

            .account-dropdown-item.logout-item:hover {
                background: rgba(220, 53, 69, 0.15);
                color: #ff7777;
            }

            /* Mobile positioning */
            @media (max-width: 768px) {
                .account-dropdown {
                    right: 0;
                    width: 210px;
                }
            }

        /* ============================== THEME KINEME CHUCHU ============================== */
        :root {
            --navy: #1a3a5c;
            --navy-dark: #102840;
            --navy-light: #254c73;
            --yellow: #f4d03f;
            --yellow-hover: #e5bd24;
            --white: #ffffff;
            --text: #243447;
            --muted: #687789;
            --surface: #ffffff;
            --background: #f5f7fa;
            --border: #e1e7ed;
            --shadow: 0 10px 30px rgba(26, 58, 92, 0.09);
            --radius: 16px;
            --transition: 0.25s ease;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            margin: 0;
            font-family: 'Creato Display', sans-serif;
            color: var(--text);
            background: var(--background);
            line-height: 1.6;
        }

        img {
            display: block;
            max-width: 100%;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, textarea, select {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        main {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            padding: 36px 5%;
        }

        /* ============================== OTHERS ============================== */
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--navy);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 1.4px;
            line-height: 1.5;
        }

        .eyebrow i {
            color: #b48b00;
        }

        .section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .section-head h2 {
            margin: 8px 0;
            color: var(--navy);
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            line-height: 1.2;
        }

        .section-head p {
            margin: 0;
            color: var(--muted);
        }

        .text-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            color: var(--navy);
            font-weight: 700;
            transition: color var(--transition);
        }

        .text-link:hover {
            color: #a78000;
        }

        .text-link i,
        .btn i,
        .card-link i {
            transition: transform var(--transition);
        }

        .text-link:hover i,
        .btn:hover i,
        .category-card a:hover .card-link i {
            transform: translateX(4px);
        }

        /* ============================== WELCOME MY DEAR TO CSSP DARLING BABY123 ============================== */
        .welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin: 10px 0;
            color: var(--navy);
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.3px;
        }

        #welcomeName {
            color: #b48b00;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .date-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            padding: 12px 17px;
            color: var(--navy);
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 50px;
            box-shadow: 0 4px 14px rgba(26, 58, 92, 0.04);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .date-pill i {
            color: #b48b00;
        }

        /* ============================== HERO KA BA? ============================== */
        .hero {
            position: relative;
            isolation: isolate;
            display: flex;
            align-items: center;
            min-height: 410px;
            margin-bottom: 30px;
            padding: clamp(30px, 6vw, 70px);
            overflow: hidden;
            color: var(--white);
            background:
                linear-gradient(
                    90deg,
                    rgba(10, 29, 47, 0.94) 0%,
                    rgba(16, 40, 64, 0.82) 48%,
                    rgba(16, 40, 64, 0.25) 100%
                ),
                url("./Assets/Index/hero-image-three-staff.JPG")
                center 42% / cover no-repeat;
            background-color: var(--navy);
            border-radius: 22px;
            box-shadow: var(--shadow);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 650px;
        }

        .hero .eyebrow {
            color: var(--yellow);
        }

        .hero .eyebrow i {
            color: var(--yellow);
        }

        .hero h2 {
            margin: 20px 0;
            font-size: clamp(2.8rem, 6vw, 5rem);
            font-weight: 900;
            line-height: 0.98;
            letter-spacing: -2px;
        }

        .hero h2 span {
            color: var(--yellow);
        }

        .hero p {
            max-width: 570px;
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
            font-size: 1rem;
            line-height: 1.8;
        }

        /* ============================== PINDUTAN LANG PO, OKI? ============================== */
        .btn-row {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
            margin-top: 28px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 48px;
            padding: 13px 21px;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 0.9rem;
            font-weight: 800;
            text-align: center;
            cursor: pointer;
            transition:
                background var(--transition),
                color var(--transition),
                border-color var(--transition),
                transform var(--transition);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-gold {
            color: var(--navy-dark);
            background: var(--yellow);
        }

        .btn-gold:hover {
            background: var(--yellow-hover);
        }

        .btn-outline {
            color: var(--white);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.65);
        }

        .btn-outline:hover {
            color: var(--navy);
            background: var(--white);
            border-color: var(--white);
        }

        .btn-navy {
            color: var(--white);
            background: var(--navy);
        }

        .btn-navy:hover {
            background: var(--navy-dark);
        }

        /* ============================== KWEK-KWEK ============================== */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 70px;
        }

        .quick-card {
            display: flex;
            align-items: center;
            gap: 17px;
            min-width: 0;
            padding: 23px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 5px 18px rgba(26, 58, 92, 0.035);
            transition:
                transform var(--transition),
                box-shadow var(--transition),
                border-color var(--transition);
        }

        .quick-card:hover {
            transform: translateY(-5px);
            border-color: rgba(244, 208, 63, 0.9);
            box-shadow: var(--shadow);
        }

        .quick-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 54px;
            width: 54px;
            height: 54px;
            color: var(--navy);
            background: rgba(244, 208, 63, 0.2);
            border-radius: 12px;
            font-size: 1.35rem;
        }

        .quick-card > span:last-child {
            min-width: 0;
        }

        .quick-card strong {
            display: block;
            margin-bottom: 5px;
            color: var(--navy);
            font-size: 0.98rem;
        }

        .quick-card small {
            display: block;
            color: var(--muted);
            font-size: 0.81rem;
            line-height: 1.5;
        }

        /* ============================== THAT'S OUR CATEGORY RIGHT THERE ============================== */
        #categories {
            margin-bottom: 65px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .category-card {
            min-width: 0;
            overflow: hidden;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 6px 20px rgba(26, 58, 92, 0.04);
            transition:
                transform var(--transition),
                box-shadow var(--transition);
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow);
        }

        .category-card > a {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .category-image {
            position: relative;
            height: 235px;
            overflow: hidden;
            background: #e9eef3;
        }

        .category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover .category-image img {
            transform: scale(1.06);
        }

        .category-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            align-items: flex-start;
            padding: 25px;
        }

        .tag {
            display: inline-block;
            max-width: 100%;
            padding: 6px 10px;
            color: var(--navy);
            background: rgba(244, 208, 63, 0.22);
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 800;
            line-height: 1.5;
        }

        .category-body h3 {
            margin: 14px 0 8px;
            color: var(--navy);
            font-size: 1.45rem;
            line-height: 1.3;
        }

        .category-body p {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.8;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: auto;
            color: var(--navy);
            font-size: 0.88rem;
            font-weight: 800;
        }

        .card-link i {
            color: #a78000;
        }

        /* ============================== CONTACT US NACH ============================== */
        .bottom-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            padding: 35px 40px;
            color: var(--white);
            background: var(--yellow);
            border-radius: var(--radius);
        }

        .bottom-banner > div {
            max-width: 650px;
        }

        .bottom-banner h2 {
            margin: 0 0 8px;
            color: var(--navy-dark);
            font-size: clamp(1.5rem, 3vw, 2.1rem);
            line-height: 1.3;
        }

        .bottom-banner p {
            margin: 0;
            color: #354a5f;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .bottom-banner .btn {
            flex-shrink: 0;
        }

        /* ============================== DARK MODE NI AI (HINDI NI CSSP WBDV1) ============================== */
        body.dark-mode {
            --text: #e6edf5;
            --muted: #b1bfce;
            --surface: #172b40;
            --background: #0d1c2b;
            --border: #30465b;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.22);
        }

        body.dark-mode .eyebrow,
        body.dark-mode .welcome h1,
        body.dark-mode .section-head h2,
        body.dark-mode .quick-card strong,
        body.dark-mode .category-body h3,
        body.dark-mode .text-link,
        body.dark-mode .card-link {
            color: #f1d76b;
        }

        body.dark-mode .date-pill {
            color: #f1d76b;
            background: var(--surface);
            border-color: var(--border);
        }

        body.dark-mode .quick-icon {
            color: #f1d76b;
            background: rgba(244, 208, 63, 0.12);
        }

        body.dark-mode .tag {
            color: #f1d76b;
            background: rgba(244, 208, 63, 0.12);
        }

        body.dark-mode .category-image {
            background: #20364c;
        }

        body.dark-mode .bottom-banner {
            background: #263e54;
        }

        body.dark-mode .bottom-banner h2,
        body.dark-mode .bottom-banner p {
            color: #f1f5f9;
        }

        body.dark-mode .btn-navy {
            color: var(--navy-dark);
            background: var(--yellow);
        }

        body.dark-mode .btn-navy:hover {
            background: var(--yellow-hover);
        }

        /* ========================================
        RESPONSIVE: TABLETS
        ======================================== */

        @media (max-width: 1024px) {
            main {
                padding: 30px 4%;
            }

            .quick-grid {
                gap: 13px;
            }

            .quick-card {
                gap: 12px;
                padding: 18px;
            }

            .quick-icon {
                flex-basis: 46px;
                width: 46px;
                height: 46px;
            }

            .category-grid {
                gap: 16px;
            }

            .category-body {
                padding: 20px;
            }

            .category-image {
                height: 200px;
            }
        }

        /* ============================== RESPONSIVENESS NI AI (HINDI NI CSSP WBDV1) ============================== */
        @media (max-width: 768px) {
            main {
                padding: 25px 5%;
            }

            .welcome {
                align-items: flex-start;
                flex-direction: column;
                gap: 16px;
            }

            .welcome h1 {
                font-size: clamp(2rem, 8vw, 2.7rem);
                letter-spacing: -0.8px;
            }

            .date-pill {
                padding: 9px 13px;
                font-size: 0.8rem;
            }

            .hero {
                min-height: 420px;
                padding: 32px 25px;
                border-radius: 15px;
                background-position: 58% center;
            }

            .hero h2 {
                font-size: clamp(2.8rem, 12vw, 4rem);
            }

            .hero p {
                font-size: 0.92rem;
            }

            .btn-row {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-row .btn {
                width: 100%;
            }

            .quick-grid {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 50px;
            }

            .quick-card {
                padding: 18px;
            }

            .section-head {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .category-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .category-image {
                height: 260px;
            }

            .category-body {
                padding: 23px;
            }

            #categories {
                margin-bottom: 45px;
            }

            .bottom-banner {
                align-items: flex-start;
                flex-direction: column;
                padding: 28px 24px;
            }

            .bottom-banner .btn {
                width: 100%;
            }
        }

        @media (max-width: 400px) {
            main {
                padding-right: 16px;
                padding-left: 16px;
            }

            .hero {
                padding: 28px 20px;
            }

            .hero h2 {
                font-size: 2.55rem;
            }

            .category-image {
                height: 210px;
            }

            .quick-card {
                gap: 12px;
                padding: 15px;
            }

            .quick-icon {
                flex-basis: 42px;
                width: 42px;
                height: 42px;
                font-size: 1.1rem;
            }
        }

        a:focus-visible,
        button:focus-visible {
            outline: 3px solid #c39b00;
            outline-offset: 4px;
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
        </style>
        
    </head>
    <body>
        
        <!-- ===== PRE-HEADER TICKER ===== -->
        <!-- Infinite scrolling -->
        <div class="pre-header">
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
    
        <!-- ===== HEADER / NAVIGATION ===== -->
        <header class="site-header" id="siteHeader">
            <div class="header-inner">
            
                <!-- Logo -->
                <a href="index.php" class="logo-wrap" aria-label="CSSP Garments Trading homepage">
                    <div class="logo-icon">
                        <img src="Assets/logo-light-text.png" class="logo-img light-logo" alt="CSSP Garments Trading logo, light version">
                        <img src="Assets/logo-dark-text.png" class="logo-img dark-logo" alt="CSSP Garments Trading logo, dark version">
                    </div>
                    <div class="logo-text">CSSP<span>Garments&nbsp;Trading</span></div>
                </a>

                <nav class="main-nav" id="mainNav" aria-label="Main navigation">
                    <ul class="nav-list">
                        
                        <!-- products mega menu -->
                        <li class="nav-item has-mega" id="navProducts">
                            <a href="#" class="nav-link" id="navProductsBtn" aria-haspopup="true" aria-expanded="false">Products <i class="fa-solid fa-chevron-down nav-caret"></i></a>
                            <div class="mega-menu" id="megaProducts" aria-hidden="true">
                                <div class="mega-inner">
                            
                                    <div class="mega-col">
                                        <p class="mega-label">Uniforms</p>
                                        <div class="mega-feature-card">
                                            <img src="./Assets/UNIFORM_MEGA MENU.png" alt="Maritime and culinary uniform range including coveralls and chef tops" />
                                            <p>Maritime &amp; Culinary Uniforms</p>
                                            <a href="products.php#uniforms" class="btn-sm">Gear Up</a>
                                        </div>
                                    </div> 
                                        
                                    <div class="mega-divider"></div>
                                        
                                    <div class="mega-col">
                                        <p class="mega-label">Safety Footwear</p>
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
                            <a href="#" class="nav-link" id="navAboutBtn" aria-haspopup="true" aria-expanded="false">About Us <i class="fa-solid fa-chevron-down nav-caret"></i></a>
                            <div class="mega-menu" id="megaAbout" aria-hidden="true">
                                <div class="mega-inner">
                                    <div class="mega-col">
                                        <p class="mega-label">Company</p>
                                        <a href="./aboutus.php#history" class="mega-item text-only"><i class="fa-solid fa-anchor"></i> Our Story</a>
                                        <a href="./aboutus.php#people" class="mega-item text-only"><i class="fa-solid fa-users"></i> Our Team</a>
                                        <a href="./aboutus.php#tailor" class="mega-item text-only"><i class="fa-solid fa-house"></i> Location</a>
                                    </div>

                                    <div class="mega-divider"></div>

                                    <div class="mega-col">
                                        <p class="mega-label">Support</p>
                                        <a href="./index.php#faq" class="mega-item text-only"><i class="fa-solid fa-circle-question"></i> FAQ</a>
                                        <a href="./contacts.php" class="mega-item text-only"><i class="fa-solid fa-envelope"></i> Contact Us</a>
                                        <a href="./policies.php" class="mega-item text-only"><i class="fa-solid fa-file-contract"></i> Policies</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            
                <!-- upper-right-side icon group -->
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
            
                    <!-- cart icon -->
                    <a class="icon-btn" title="Cart" aria-label="View cart" id="cartIconBtn" href="cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge" id="cartBadge">0</span>
                    </a>
            
                    <!-- search icon -->
                    <button class="icon-btn" id="searchToggle" title="Search" aria-label="Toggle search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
            
                    <!-- light/dark mode toggle -->
                    <button class="theme-toggle" id="themeToggle" title="Toggle Theme" aria-label="Toggle colour theme">
                        <i class="fa-solid fa-sun" id="themeIcon"></i>
                    </button>

                    
                    <!-- My Account dropdown -->
                    <div class="account-menu" id="accountMenu">
                        <button class="icon-btn account-btn" id="accountBtn" title="My Account" aria-label="My Account" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i>
                        </button>

                        <div class="account-dropdown" id="accountDropdown">
                            <div class="account-dropdown-header">
                                <i class="fa-solid fa-user-circle"></i>
                                <span>My Account</span>
                            </div>

                            <a href="my_orders.php" class="account-dropdown-item">
                                <i class="fa-solid fa-box"></i>
                                <span>My Orders</span>
                            </a>

                            <div class="account-dropdown-divider"></div>

                            <a href="logout.php" class="account-dropdown-item logout-item" onclick="return confirm('Are you sure you want to log out?');">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Log Out</span>
                            </a>
                        </div>

                    </div>

            
                    <!-- Hamburger (mobile only) -->
                    <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>
        
            <!-- Search bar (hidden until toggled) -->
            <div class="search-bar" id="searchBar" role="search">
                <input type="search" id="searchInput" placeholder="Search uniforms, PPE, safety shoes…" autocomplete="off" aria-label="Search products">
                <button aria-label="Submit search"><i class="fa-solid fa-magnifying-glass"></i></button>
                <div class="search-results" id="searchResults" aria-live="polite"></div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main>
            <section class="welcome">
                <div>
                    <span class="eyebrow"><i class="fa-solid fa-water"></i>CSSP Garments Trading</span>
                    <h1>Welcome aboard,<span id="welcomeName"> Customer</span>!</h1>
                    <p>Your work deserves gear you can count on. Let's get you equipped.</p>
                </div>

                <div class="date-pill">
                    <i class="fa-regular fa-calendar"></i>
                    <span id="todayDate"></span>
                </div>
            </section>

            <!-- HERO SECTION -->
            <section class="hero" aria-labelledby="heroTitle">
                <div class="hero-content">
                    <span class="eyebrow"><i class="fa-solid fa-compass"></i>READY FOR THE NEXT SHIFT?</span>
                    <h2 id="heroTitle">Dressed for<br><span>The Deep.</span></h2>
                    <p>Explore dependable maritime uniforms, professional kitchen wear, and safety essentials selected for demanding work environments.</p>
                    <div class="btn-row">
                        <a class="btn btn-gold" href="./products.php">Explore Products<i class="fa-solid fa-arrow-right"></i></a>
                        <a class="btn btn-outline" href="./contacts.php">Request a Quote<i class="fa-regular fa-message"></i></a>
                    </div>
                </div>
            </section>

            <!-- QUICK ACTIONS -->
            <section class="quick-grid" aria-label="Quick actions">
                <a class="quick-card" href="./products.php">
                    <span class="quick-icon"><i class="fa-solid fa-layer-group"></i></span>
                    <span><strong>Browse Products</strong><small>Find gear for your role and crew.</small></span>
                </a>
                <a class="quick-card" href="./cart.php" id="quickCart">
                    <span class="quick-icon"><i class="fa-solid fa-cart-shopping"></i></span>
                    <span><strong>View Your Cart</strong><small>Review items before proceeding.</small></span>
                </a>
                <a class="quick-card" href="./my-orders.php">
                    <span class="quick-icon"><i class="fa-solid fa-clipboard-check"></i></span>
                    <span><strong>Order Requests</strong><small>Check your submitted requests.</small></span>
                </a>
            </section>

            <!-- SHOP BY CATEGORY -->
            <section id="categories">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">FIND YOUR FIT</span>
                        <h2>Shop by Category</h2>
                        <p>Start with the essentials for your next shift.</p>
                    </div>
                    <a class="text-link" href="./products.php">View all products<i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="category-grid">
                    <!-- UNIFORMS -->
                    <article class="category-card">
                        <a href="./products.php#uniforms" aria-label="Browse uniforms">
                            <div class="category-image">
                                <img src="./Assets/UNIFORM_MEGA MENU.png" alt="Maritime and culinary uniforms" loading="lazy">
                            </div>
                            <div class="category-body">
                                <span class="tag">Maritime &amp; Culinary</span>
                                <h3>Uniforms</h3>
                                <p>Professional coveralls and kitchen uniforms designed for comfort through every shift.</p>
                                <span class="card-link">Browse uniforms<i class="fa-solid fa-arrow-right"></i></span>
                            </div>

                        </a>
                    </article>

                    <!-- SAFETY FOOTWEAR -->
                    <article class="category-card">
                        <a href="./products.php#safety-footwears" aria-label="Browse safety footwear">
                            <div class="category-image">
                                <img src="./Assets/SAFETYFOOTWEAR_MEGA MENU.png" alt="Safety footwear and protective gear" loading="lazy">
                            </div>
                            <div class="category-body">
                                <span class="tag">Protection from the Ground Up</span>
                                <h3>Safety Footwear</h3>
                                <p> Explore dependable footwear options for demanding work areas and long shifts.</p>
                                <span class="card-link">Find your pair<i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                    </article>

                    <!-- SAFETY GEAR 
                    <article class="category-card">
                        <a href="./products.php#ppe" aria-label="Browse personal protective equipment">
                            <div class="category-image">
                                <img src="./Assets/Index/about image.JPG" alt="CSSP team checking workwear quality" loading="lazy">
                            </div>
                            <div class="category-body">
                                <span class="tag">Workplace Essentials</span>
                                <h3>Safety Gear &amp; PPE</h3>
                                <p>Discover protective essentials to help your team prepare for the job ahead.</p>
                                <span class="card-link">Explore safety gear<i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                    </article> -->

                </div>
            </section>

            <!-- CONTACT BANNER -->
            <section class="bottom-banner">
                <div>
                    <h2>Equipping an entire crew?</h2>
                    <p>Tell us what your team needs and request a quotation for bulk or customized orders.</p>
                </div>

                <a class="btn btn-navy" href="./contacts.php">Talk to Our Team<i class="fa-solid fa-arrow-right"></i></a>
            </section>

        </main>

        <!-- ===== FOOTER ===== -->
        <footer class="site-footer" id="footer">
            <div class="footer-wave">
                <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg"><path d="M0,40 C360,0 1080,80 1440,40 L1440,0 L0,0 Z" /></svg>
            </div>
            <div class="footer-inner">
        
                <!-- brand col -->
                <div class="footer-col brand-col">
                    <div class="footer-logo"><i class="fa-solid fa-ship"></i><span>CSSP Garments Trading</span></div>
                    <p>Your trusted maritime uniform supplier since 2024. Quality gear for every sailor, cook, and crew member.</p>
                    <div class="social-icons">
                        <a href="./contacts.php" title="Contacts"><i class="fa-regular fa-address-book"></i></a>
                    </div>
                </div>
        
                <!-- quick links -->
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                    <li><a href="./index.php"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                    <li><a href="./products.php"><i class="fa-solid fa-chevron-right"></i> Products</a></li>
                    <li><a href="./aboutus.php"><i class="fa-solid fa-chevron-right"></i> About Us</a></li>
                    <li><a href="./index.php#reviews"><i class="fa-solid fa-chevron-right"></i> Reviews</a></li>
                    <li><a href="./index.php#faq"><i class="fa-solid fa-chevron-right"></i> FAQ</a></li>
                    </ul>
                </div>

            </div>
        
                <div class="footer-bottom">
                    <p>&copy; 2024 CSSP Garments Trading. All rights reserved.<br> Designed by Logmunch!</p>
                    <div class="legal-links">
                        <a href="./policies.php#privacyPage">Privacy Policy</a>
                        <a href="./policies.php#termsPage">Terms & Conditions</a>
                        <a href="./policies.php#shippingPage">Shipping Policy</a>
                    </div>
                </div>
        </footer>

        <script src="JS Files/Products_Script.js"></script>

        <script>
            const accountMenu = document.getElementById("accountMenu");
            const accountBtn = document.getElementById("accountBtn");

            if (accountMenu && accountBtn) {
                accountBtn.addEventListener("click", function (event) {
                    event.stopPropagation();

                    const isOpen = accountMenu.classList.toggle("open");
                    accountBtn.setAttribute("aria-expanded", isOpen);
                });

                document.addEventListener("click", function (event) {
                    if (!accountMenu.contains(event.target)) {
                        accountMenu.classList.remove("open");
                        accountBtn.setAttribute("aria-expanded", "false");
                    }
                });

                document.addEventListener("keydown", function (event) {
                    if (event.key === "Escape") {
                        accountMenu.classList.remove("open");
                        accountBtn.setAttribute("aria-expanded", "false");
                        accountBtn.focus();
                    }
                });
            }

            
/* ========================================
   CSSP CUSTOMER DASHBOARD JAVASCRIPT
======================================== */

document.addEventListener("DOMContentLoaded", function () {

    // ====================================
    // WELCOME CUSTOMER
    // ====================================

    const welcomeName = document.getElementById("welcomeName");

    /*
      If your PHP login system stores the customer's name
      in a session, you can output it into this element
      directly from PHP.

      Otherwise, this uses "there" as the default.
    */

    if (welcomeName && !welcomeName.textContent.trim()) {
        welcomeName.textContent = "there";
    }

    // ====================================
    // TODAY'S DATE
    // ====================================

    const todayDate = document.getElementById("todayDate");

    if (todayDate) {
        const today = new Date();

        todayDate.textContent = today.toLocaleDateString("en-PH", {
            weekday: "short",
            year: "numeric",
            month: "short",
            day: "numeric"
        });
    }

    // ====================================
    // THEME TOGGLE
    // ====================================

    const themeToggle = document.getElementById("themeToggle");
    const themeIcon = document.getElementById("themeIcon");

    function applyTheme(isDark) {
        document.body.classList.toggle("dark-mode", isDark);

        if (themeIcon) {
            themeIcon.classList.toggle("fa-sun", !isDark);
            themeIcon.classList.toggle("fa-moon", isDark);
        }

        if (themeToggle) {
            themeToggle.setAttribute(
                "aria-label",
                isDark ? "Switch to light mode" : "Switch to dark mode"
            );

            themeToggle.setAttribute("title", isDark ? "Light Mode" : "Dark Mode");
        }
    }

    // Restore the previously selected theme.
    let savedTheme = null;

    try {
        savedTheme = localStorage.getItem("cssp-theme");
    } catch (error) {
        // Continue with light mode if storage is unavailable.
    }

    applyTheme(savedTheme === "dark");

    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            const isDark = !document.body.classList.contains("dark-mode");

            applyTheme(isDark);

            try {
                localStorage.setItem("cssp-theme", isDark ? "dark" : "light");
            } catch (error) {
                // Theme still works for the current page.
            }
        });
    }

    // ====================================
    // CART BADGE
    // ====================================

    const cartBadge = document.getElementById("cartBadge");

    function updateCartBadge() {
        if (!cartBadge) return;

        try {
            /*
              This expects "cart" in localStorage to be
              an array of cart items.

              Each item can contain a quantity property.
              If your cart uses a different structure,
              adjust this calculation to match it.
            */

            const cartData = localStorage.getItem("cart");

            if (!cartData) {
                cartBadge.textContent = "0";
                return;
            }

            const cart = JSON.parse(cartData);

            if (!Array.isArray(cart)) {
                cartBadge.textContent = "0";
                return;
            }

            const totalItems = cart.reduce(function (total, item) {
                const quantity = Number(item.quantity ?? 1);

                return total + (
                    Number.isFinite(quantity) && quantity > 0
                        ? quantity
                        : 0
                );
            }, 0);

            cartBadge.textContent = String(totalItems);

        } catch (error) {
            console.warn("Could not read cart data:", error);
            cartBadge.textContent = "0";
        }
    }

    updateCartBadge();

    // Update the badge when another tab changes the cart.
    window.addEventListener("storage", function (event) {
        if (event.key === "cart") {
            updateCartBadge();
        }
    });

});

        </script>
            
    </body>
</html>

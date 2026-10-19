<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CSSP Garments Trading</title>
        <meta name="description" content="CSSP Garments Trading – premium maritime uniforms, PPE, coveralls, safety footwear and kitchen uniforms since 2024." />
        <link rel="icon" href="./Assets/logo-light-text.png" />
        <link rel="stylesheet" href="CSS Files/Registration_Style.css">
        <link rel="stylesheet" href="CSS Files/AboutUs_Style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
        <script src="https://kit.fontawesome.com/493ae0299a.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>
    <body>
        <div class="split-container">
            <div class="info-sidebar">
                <div class="info-content cssp-sidebar-content">
                    <p class="sidebar-tagline">Welcome to CSSP Garments</p>
                    <h2>Create your account</h2>
                    <p class="sidebar-lead">Explore CSSP's core features for corporate accounts and individuals.</p>  

                    <div id="featuresToggle" class="toggle-include-btn">
                        <span id="toggleText">Hide what's included</span>
                        <i id="toggleArrow" class="fa fa-chevron-up"></i> 
                    </div>

                    <div id="featuresList" class="cssp-features-list active-dropdown">
                        <div class="cssp-feature-item">              
                            <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="feature-text-block">
                                <h4>Premium Maritime Coveralls</h4>
                                <p>Heavy-duty, marine-grade boilersuits designed for maximum crew comfort and safety above sea level.</p>
                            </div>
                        </div>

                        <div class="cssp-feature-item">
                            <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="feature-text-block">
                                <h4>Premium Kitchen Apparel</h4>
                                <p>Comfortable kitchen crew polos, standard chef's pants, and checkered pants tailored for active food service staff.</p>
                            </div>
                        </div>

                        <div class="cssp-feature-item">
                            <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="feature-text-block">
                                <h4>Certified Corporate PPE</h4>
                                <p>International standard protective equipment and high-visibility safety clothing to protect your workforce.</p>
                            </div>
                        </div>

                        <div class="cssp-feature-item">
                            <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                            <div class="feature-text-block">
                                <h4>Maritime Safety Shoes</h4>
                                <p>Slip-resistant, reinforced steel-toe footwear optimized for sailors, engineers, and professional galley crew.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-content-area">
                <form class="main-form" action="register.php" method="POST">
                    <div class="cssp-header">
                        <img src="Assets/logo-light-text.png" alt="Icon" class="cssp-icon">
                        <span class="cssp-name">CSSP GARMENTS TRADING</span>
                    </div>

                    <h1 class="form-title">SIGN UP</h1>
                    <p class="form-subtitle">Sign up to start setting up your team's uniforms.</p>

                    <table class="form-table">
                        <tr>
                            <td class="half-width-cell left-cell">
                                <div class="input-block-container">
                                    <label class="block-label" for="firstName">FIRST NAME</label>
                                    <input class="form-input" id="firstName" name="firstName" type="text" placeholder="Enter first name" required>
                                </div>
                            </td>

                            <td class="half-width-cell right-cell">
                                <div class="input-block-container">
                                    <label class="block-label" for="lastName">LAST NAME</label>
                                    <input class="form-input" id="lastName" name="lastName" type="text" placeholder="Enter last name" required>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="half-width-cell left-cell">
                                <div class="input-block-container">
                                    <label class="block-label" for="age">AGE</label>
                                    <input class="form-input" id="age" name="age" type="number" placeholder="Enter your age" required>
                                </div>
                            </td>

                            <td class="half-width-cell right-cell">
                                <div class="input-block-container">
                                    <label class="block-label" for="birthday">BIRTHDAY</label>
                                    <input class="form-input form-date" id="birthday" name="birthday" type="date" required>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="half-width-cell left-cell">
                                <div class="input-block-container">
                                    <label class="block-label" for="gender">GENDER</label>
                                    <div class="select-wrap">
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="" disabled selected>Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td class="half-width-cell right-cell">
                                <div class="input-block-container">
                                    <label class="block-label" for="phone">PHONE NUMBER</label>
                                    <input id="phone" name="phoneNumber" type="tel" placeholder="Enter phone number" required class="form-input">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="input-block-container">
                                    <label class="block-label" for="email">EMAIL ADDRESS</label>
                                    <input id="email" name="email" type="email" placeholder="Enter your email" required class="form-input">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="input-block-container">
                                    <label class="block-label" for="address">COMPLETE ADDRESS</label>
                                    <input id="address" name="address" type="text" placeholder="Enter house number, street, barangay, city, province" required class="form-input">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="input-block-container password-field-container">
                                    <label class="block-label" for="password">PASSWORD</label>
                                    <input id="password" name="password" type="password" placeholder="Create a password" required class="form-input">
                                    <i class="fa-solid fa-eye-slash toggle-password" data-target="password"></i>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="input-block-container password-field-container">
                                    <label class="block-label" for="confirmPassword">CONFIRM PASSWORD</label>
                                    <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm your password" required class="form-input" autocomplete="new-password">
                                    <i class="fa-solid fa-eye-slash toggle-password" data-target="confirmPassword"></i>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <button type="submit" class="primary-submit-btn">Create account</button>
                    
                    <div class="login-redirect-text">
                        Already have an account? <a href="login.php">Login</a>
                    </div>

                    <div class="horizontal-separator">
                        <span>Or</span>
                    </div>

                    <div class="google-row-container">
                        <button type="button" class="google-full-btn">
                            <svg class="google-icon-svg" viewBox="0 0 24 24" xmlns="http://w3.org">
                                <path d="M23.494 12.275c0-.825-.069-1.613-.194-2.375H12v4.512h6.444c-.275 1.456-1.044 2.688-2.269 3.513v2.913h3.663c2.137-1.975 3.362-4.887 3.362-8.563z" fill="#4285F4"/>
                                <path d="M12 24c3.24 0 5.956-1.075 7.944-2.912l-3.663-2.913c-1.013.675-2.313 1.088-4.281 1.088-3.288 0-6.075-2.225-7.063-5.225H1.113v3.013C3.094 20.813 7.219 24 12 24z" fill="#34A853"/>
                                <path d="M4.938 14.038c-.238-.675-.375-1.4-.375-2.15s.138-1.475.375-2.15V6.725H1.113C.4 8.138 0 9.725 0 11.888c0 2.163.4 3.75 1.113 5.163l3.825-3.013z" fill="#FBBC05"/>
                                <path d="M12 4.75c1.763 0 3.35.6 4.6 1.763l3.437-3.438C17.95 1.188 15.231 0 12 0 7.219 0 3.188 3.188 1.113 6.725l3.825 3.013c.988-3 3.775-5.225 7.063-5.225z" fill="#EA4335"/>
                            </svg>
                            <span class="google-text-center">Sign up with Google</span>
                        </button>
                    </div>

                    <div class="legal-notice">
                        <p class="legal-text">
                            By signing up, you agree to our <a href="#">Terms &amp; Conditions</a>, and have read and understood our <a href="#">Privacy Policy</a>.
                        </p>
                    </div>

                </form>
            </div>
        </div>

        <script src="JS Files/Registration_Script.js"></script>

    </body>
</html>

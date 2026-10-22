<?php
    /* includes/auth_layout.php */
    $loginError    = $loginError    ?? '';
    $registerError = $registerError ?? '';
    $old           = $old           ?? [];   // re-fill the register form after an error, e.g. $old['first_name']
    function old($k) { global $old; return htmlspecialchars($old[$k] ?? '', ENT_QUOTES, 'UTF-8'); }

?>

<main class="auth mode-<?= $mode ?>" id="auth" data-mode="<?= $mode ?>">
    <div class="auth-card">

        <!-- ===================== FORM PANEL ===================== -->
        <section class="panel panel-forms" id="formPanel">
            <div class="forms-stack">

                <!-- LOGIN FORM -->
                <form class="auth-form" id="loginForm" method="POST" action="login.php" novalidate>
                    <h1>Log in</h1>
                    <p class="auth-sub">Login to access your orders.</p>

                    <div class="form-alert" role="alert" aria-live="assertive"><?= htmlspecialchars($loginError) ?></div>

                    <div class="field">
                        <label for="l_email">Email</label>
                        <div class="input">
                            <i class="fa-regular fa-envelope lead"></i>
                            <input type="email" id="l_email" name="email" placeholder="Enter your email" autocomplete="email" required>
                        </div>
                        <span class="msg">Enter a valid email address.</span>
                    </div>

                    <div class="field">
                        <label for="l_password">Password</label>
                        <div class="input">
                            <i class="fa-solid fa-lock lead"></i>
                            <input type="password" id="l_password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                            <button type="button" class="toggle-pw" data-toggle-pw aria-label="Show password"><i class="fa-regular fa-eye-slash"></i></button>
                        </div>
                        <span class="msg">Please enter your password.</span>
                    </div>

                    <div class="form-meta">
                        <label class="remember">
                            <input type="checkbox" name="remember" value="1"> Remember me
                        </label>
                        <a href="forgot-password.php" class="link-red">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-primary btn-block">Login</button>
                    <div class="divider">or</div>
                    <a href="google-login.php" class="btn-ghost btn-block"><?php include __DIR__ . '/google_icon.php'; ?> Log in with Google</a>

                    <p class="switch-line">Don't have an account yet?
                        <a href="registration.php" class="link-red" data-switch="register">Sign up</a>
                    </p>
                </form>

                <!-- REGISTRATION FORM -->
                <form class="auth-form" id="registerForm" method="POST" action="registration.php" novalidate>
                    <h1>Sign up</h1>
                    <p class="auth-sub">Sign up to start setting up your team's uniforms.</p>

                    <div class="form-alert" role="alert" aria-live="assertive"><?= htmlspecialchars($registerError) ?></div>

                    <div class="row-2">
                        <div class="field">
                            <label for="r_first">First name</label>
                            <div class="input">
                                <i class="fa-regular fa-user lead"></i>
                                <input type="text" id="r_first" name="first_name" placeholder="Enter first name" autocomplete="given-name" value="<?= old('first_name') ?>" required>
                            </div>
                            <span class="msg">First name is required.</span>
                        </div>

                        <div class="field">
                            <label for="r_last">Last name</label>
                            <div class="input">
                                <i class="fa-regular fa-user lead"></i>
                                <input type="text" id="r_last" name="last_name" placeholder="Enter last name" autocomplete="family-name" value="<?= old('last_name') ?>" required>
                            </div>
                            <span class="msg">Last name is required.</span>
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="field">
                            <label for="r_birthday">Birthday</label>
                            <div class="input">
                                <i class="fa-regular fa-calendar lead"></i>
                                <input type="date" id="r_birthday" name="birthday" autocomplete="bday" value="<?= old('birthday') ?>" required>
                            </div>
                            <span class="msg">You must be 18 or older.</span>
                        </div>

                        <div class="field">
                            <label for="r_age">Age</label>
                            <div class="input">
                                <i class="fa-solid fa-cake-candles lead"></i>
                                <input type="text" id="r_age" name="age" placeholder="Auto from birthday" readonly tabindex="-1">
                            </div>
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="field">
                            <label for="r_gender">Gender</label>
                            <div class="input">
                                <i class="fa-solid fa-venus-mars lead"></i>
                                <select id="r_gender" name="gender" required>
                                    <option value="">Select gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Prefer not to say</option>
                                </select>
                            </div>
                            <span class="msg">Please select an option.</span>
                        </div>

                        <div class="field">
                            <label for="r_phone">Phone number</label>
                            <div class="input">
                                <i class="fa-solid fa-phone lead"></i>
                                <input type="tel" id="r_phone" name="phone" placeholder="Enter phone number" autocomplete="tel" value="<?= old('phone') ?>" required>
                            </div>
                            <span class="msg">Enter a valid phone number.</span>
                        </div>
                    </div>

                    <div class="field">
                        <label for="r_email">Email address</label>
                        <div class="input">
                            <i class="fa-regular fa-envelope lead"></i>
                            <input type="email" id="r_email" name="email" placeholder="Enter your email" autocomplete="email" value="<?= old('email') ?>" required>
                        </div>
                        <span class="msg">Enter a valid email address.</span>
                    </div>

                    <div class="field">
                        <label for="r_address">Complete address</label>
                        <div class="input">
                            <i class="fa-solid fa-location-dot lead"></i>
                            <input type="text" id="r_address" name="address" placeholder="House no., street, barangay, city, province" autocomplete="street-address" value="<?= old('address') ?>" required>
                        </div>
                        <span class="msg">Address is required.</span>
                    </div>

                    <div class="row-2">
                        <div class="field">
                            <label for="r_password">Password</label>
                            <div class="input">
                                <i class="fa-solid fa-lock lead"></i>
                                <input type="password" id="r_password" name="password" placeholder="Create a password" autocomplete="new-password" required>
                                <button type="button" class="toggle-pw" data-toggle-pw aria-label="Show password"><i class="fa-regular fa-eye-slash"></i></button>
                                <div class="meter" id="pwMeter" data-level="0" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
                            </div>
                            <span class="msg">8+ characters, letters and numbers.</span>
                        </div>

                        <div class="field">
                            <label for="r_confirm">Confirm password</label>
                                <div class="input"><i class="fa-solid fa-lock lead"></i>
                                <input type="password" id="r_confirm" name="confirm_password" placeholder="Confirm your password" autocomplete="new-password" required>
                                <button type="button" class="toggle-pw" data-toggle-pw aria-label="Show password"><i class="fa-regular fa-eye-slash"></i></button>
                            </div>
                            <span class="msg">Passwords do not match.</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary btn-block">Create account</button>
                    <div class="divider">or</div>
                    <a href="google-login.php" class="btn-ghost btn-block"><?php include __DIR__ . '/google_icon.php'; ?> Sign up with Google</a>

                    <p class="switch-line">Already have an account?
                        <a href="login.php" class="link-red" data-switch="login">Login</a>
                    </p>
                </form>
            </div>
        </section>

            
        <!-- showcase -->
        <aside class="panel panel-show" id="showPanel">
            <div class="show-bg" aria-hidden="true"></div>
            <!-- login text -->
            <div class="show-view show-login">
                <span class="pill">Maritime grade equipment</span>
                <h2>Gear up for the sea</h2>
                <p class="show-sub">Log in to track your orders and reorder your crew's uniforms in a few taps.</p>
            </div>

            <!-- register text -->
            <div class="show-view show-register">
                <span class="pill">Welcome to CSSP Garments</span>
                <h2>Create your account</h2>
                <p class="show-sub">Explore CSSP's core features for corporate accounts and individuals.</p>
                <ul class="included">
                    <li><i class="fa-solid fa-check"></i> Premium maritime coveralls</li>
                    <li><i class="fa-solid fa-check"></i> Premium kitchen apparel</li>
                    <li><i class="fa-solid fa-check"></i> Certified corporate PPE</li>
                    <li><i class="fa-solid fa-check"></i> Maritime safety shoes</li>
                </ul>
            </div>
        </aside>
    </div>
</main>

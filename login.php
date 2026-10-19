<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CSSP Garments Trading</title>
  <link rel="stylesheet" href="CSS Files/Login_Style.css">
  <link rel="stylesheet" href="CSS Files/AboutUs_Style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <script src="https://kit.fontawesome.com/493ae0299a.js" crossorigin="anonymous"></script>
</head>
<body>

  <div class="login-card-container">
    <div class="login-box-body">
      <form class="main-form" action="#" method="POST">
        
        <div class="cssp-header">
          <img src="Assets/logo-light-text.png" alt="Icon" class="cssp-icon">
          <span class="cssp-name">CSSP GARMENTS TRADING</span>
        </div>

        <h1 class="form-title">LOG IN</h1>
        <p class="form-subtitle">Login to access your orders.</p>

        <table class="form-table">
          <tr>
            <td>
              <div class="input-block-container">
                <label class="block-label">EMAIL</label>
                <input type="email" placeholder="Enter your email" required class="form-input" />
              </div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="input-block-container password-field-container">
                <label class="block-label">PASSWORD</label>
                <input type="password" placeholder="Enter your password" id="loginPassword" required class="form-input" />
                <i class="fas fa-eye-slash toggle-password" data-target="loginPassword"></i>
              </div>

              <a href="#" class="forgot-password-link">Forgot Password?</a>
            </td>
          </tr>
        </table>

        <button type="submit" class="primary-submit-btn">Login</button>

        <div class="register-redirect-text">
          Don't have an account yet? <a href="signup.html">Sign up</a>
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
            <span class="google-text-center">Log in with Google</span>
          </button>
        </div>

      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const togglePasswordIcons = document.querySelectorAll('.toggle-password');
      togglePasswordIcons.forEach(function (icon) {
        icon.addEventListener('click', function () {
          const targetId = this.getAttribute('data-target');
          const targetInput = document.getElementById(targetId);
          if (!targetInput) return;
          if (targetInput.type === 'password') {
            targetInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
          } else {
            targetInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
          }
        });
      });
    });
  </script>

</body>
</html>

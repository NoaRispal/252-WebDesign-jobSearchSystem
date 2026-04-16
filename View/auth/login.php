<!-- BACKEND: Rename to login.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->
<!-- BACKEND: &lt;?php require_once '../Helpers/session.php'; ?&gt; -->
<!-- BACKEND: If user is already logged in, redirect:
     if(isset($_SESSION['user_id'])) {
       header('Location: index.php');
       exit;
     }
-->
<!-- BACKEND: Display flash error message if login failed:
     &lt;?php if(isset($_SESSION['login_error'])): ?&gt;
       <div class="alert alert-error">&lt;?= $_SESSION['login_error'] ?&gt;</div>
       &lt;?php unset($_SESSION['login_error']); ?&gt;
     &lt;?php endif; ?&gt;
-->
<!-- ====== LOGIN FORM ====== -->
  <main class="auth-page" id="login-page">
    <div class="auth-card" id="login-card">
      <div style="text-align:center;margin-bottom:var(--space-lg);">
        <a href="<?= $baseUrl ?>/home" class="navbar-logo" style="justify-content:center;font-size:24px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px;height:32px;"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
          Job Portal
        </a>
      </div>

      <h1>Welcome Back</h1>
      <p>Login to your account to continue</p>

      <!-- BACKEND: Change action to: action="index.php?c=auth&a=login" method="POST"
           Add CSRF: <input type="hidden" name="csrf_token" value="&lt;?= $_SESSION['csrf_token'] ?&gt;">
           
           AuthController::login() should:
           1. Validate: filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
           2. Query:    SELECT * FROM users WHERE email = ?
           3. Verify:   password_verify($_POST['password'], $user['password_hash'])
           4. Session:  $_SESSION['user_id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['first_name'] = $user['first_name'];
           5. Redirect: Based on role:
                        admin     → admin-dashboard.php
                        employer  → employer-dashboard.php
                        job_seeker → index.php
           6. On fail:  $_SESSION['login_error'] = 'Invalid credentials';
                        redirect back to login.php
      -->
      <form action="<?= $baseUrl ?>/submit" method="POST" data-validate id="login-form">
        <div class="form-group">
          <label for="login-email">Email Address</label>
          <input type="email" class="form-control" name="email" placeholder="Enter your email" required id="login-email">
          <span class="form-error">Please enter a valid email</span>
        </div>
        <div class="form-group">
          <label for="login-password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Enter your password" required id="login-password">
          <span class="form-error">Password is required</span>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md);">
          <label style="display:flex;align-items:center;gap:var(--space-sm);font-size:14px;cursor:pointer;">
            <input type="checkbox" name="remember" value="1" style="accent-color:var(--clr-primary);width:16px;height:16px;" id="remember-me">
            Remember me
          </label>
          <a href="<?= $baseUrl ?>/reset" style="font-size:14px;color:var(--clr-primary);font-weight:var(--fw-medium);" id="forgot-password">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary" id="login-submit">Login</button>
      </form>

      <div class="auth-footer" id="login-footer">
        Don't have an account? <a href="<?= $baseUrl ?>/register">Register</a>
      </div>

      <!-- Demo Credentials -->
      <div style="margin-top:var(--space-lg);padding:var(--space-md);background:var(--clr-primary-light);border-radius:var(--radius-md);font-size:13px;">
        <strong style="color:var(--clr-primary);">Demo Accounts:</strong>
        <div style="margin-top:var(--space-sm);color:var(--clr-text-gray);line-height:1.8;">
          <strong>Admin:</strong> admin@jobportal.com / admin123<br>
          <strong>Employer:</strong> employer@company.com / employer123<br>
          <strong>Job Seeker:</strong> seeker@email.com / seeker123
        </div>
      </div>
    </div>
  </main>

  <!-- BACKEND: Remove this entire demo script block when real auth is implemented.
       The form will POST to AuthController::login() instead.
  -->
  <script>
    // Demo login — redirect based on email
    document.getElementById('login-form').addEventListener('submit', function(e) {
      e.preventDefault();
      var email = document.getElementById('login-email').value.trim().toLowerCase();
      var password = document.getElementById('login-password').value;

      if (!email || !password) return;

      // Demo routing by email
      if (email === 'admin@jobportal.com' && password === 'admin123') {
        window.location.href = '<?= $baseUrl ?>/admin/dashboard';
      } else if (email === 'employer@company.com' && password === 'employer123') {
        window.location.href = '<?= $baseUrl ?>/employer/dashboard';
      } else if (email === 'seeker@email.com' && password === 'seeker123') {
        window.location.href = '<?= $baseUrl ?>/home';
      } else {
        alert('Invalid credentials. Please use one of the demo accounts shown below.');
      }
    });
  </script>

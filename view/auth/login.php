<!-- ====== FLASH ====== -->
<?php 
if (isset($_SESSION['flash'])){ 

  $flashType = $_SESSION['flash_type'] ?? 'success';
  $isDanger = $flashType === 'danger';
  $bgColor  = $isDanger ? "#f8d7da" : "#d4edda";
  $brColor  = $isDanger ? "#f5c6cb" : "#c3e6cb";
  $txtColor = $isDanger ? "#721c24" : "#155724";
}
if (isset($_SESSION['flash'])): ?>
  <div class="alert" style="padding: 15px; background-color: <?= $bgColor ?>; color: <?= $txtColor ?>; border: 1px solid <?= $brColor ?>; border-radius: 4px; margin-bottom: 20px;">
    <?= htmlspecialchars($_SESSION['flash']); ?>
  </div>
    <?php 
        unset($_SESSION['flash']); 
    ?>
<?php endif; ?>

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

      <form action="<?= $baseUrl ?>/login/auth" method="POST" data-validate id="login-form">
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
          <strong>Admin:</strong> admin@example.com / admin123<br>
          <strong>Employer:</strong> employer@company.com / employer123<br>
          <strong>Job Seeker:</strong> seeker@email.com / seeker123
        </div>
      </div>
    </div>
  </main>

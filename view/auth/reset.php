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
        unset($_SESSION['flash_type']); 
    ?>
<?php endif; ?>

<main class="auth-page" id="reset-page">
  <div class="auth-card" id="reset-card">
    <div style="text-align:center;margin-bottom:var(--space-lg);">
      <a href="<?= $baseUrl ?>/home" class="navbar-logo" style="justify-content:center;font-size:24px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px;height:32px;"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        Job Portal
      </a>
    </div>

    <h1>Reset Password</h1>
    <p>Enter your new password below</p>

    <form action="<?= $baseUrl ?>/reset/auth" method="POST" data-validate id="reset-form">
      <div class="form-group">
        <label for="reset-email">Email Address</label>
        <input type="email" class="form-control" name="email" placeholder="Enter your email" required id="reset-email">
        <span class="form-error">Please enter a valid email</span>
      </div>
      <div class="form-group">
        <label for="reset-password">New Password</label>
        <input type="password" class="form-control" name="new_password" placeholder="Enter your new password" required id="reset-password">
        <span class="form-error">Password is required</span>
      </div>
      <div class="form-group">
        <label for="reset-password-confirm">Confirm New Password</label>
        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm your new password" required id="reset-password-confirm">
        <span class="form-error">Passwords must match</span>
      </div>

      <button type="submit" class="btn btn-primary" id="reset-submit">Reset Password</button>
    </form>

    <div class="auth-footer" id="reset-footer" style="margin-top:var(--space-lg); text-align:center;">
      Remembered your password? <a href="<?= $baseUrl ?>/login">Login here</a>
    </div>
  </div>
</main>

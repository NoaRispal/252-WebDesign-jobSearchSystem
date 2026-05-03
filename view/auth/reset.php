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

    <form action="<?= $baseUrl ?>/submit" method="POST" data-validate id="reset-form">
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

<script>
  // Demo reset flow loop
  document.getElementById('reset-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent backend submission
    
    var email = document.getElementById('reset-email').value;
    var pass = document.getElementById('reset-password').value;
    var conf = document.getElementById('reset-password-confirm').value;

    if (!email || !pass || !conf) return;

    if (pass !== conf) {
      alert("Error: Passwords do not match!");
      return;
    }

    alert("Success! Your password has been reset. You will now be redirected to login.");
    window.location.href = '<?= $baseUrl ?>/login';
  });
</script>

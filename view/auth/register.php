<!-- BACKEND: Rename to register.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->
<!-- BACKEND: If already logged in, redirect: if(isset($_SESSION['user_id'])) { header('Location: index.php'); exit; } -->
<!-- BACKEND: Display flash errors:
     &lt;?php if(isset($_SESSION['register_errors'])): ?&gt;
       &lt;?php foreach($_SESSION['register_errors'] as $error): ?&gt;
         <div class="alert alert-error">&lt;?= $error ?&gt;</div>
       &lt;?php endforeach; unset($_SESSION['register_errors']); ?&gt;
     &lt;?php endif; ?&gt;
-->
<!-- ====== REGISTER FORM ====== -->
  <main class="auth-page" id="register-page">
    <div class="auth-card" style="max-width:520px;" id="register-card">
      <div style="text-align:center;margin-bottom:var(--space-lg);">
        <a href="<?= $baseUrl ?>/home" class="navbar-logo" style="justify-content:center;font-size:24px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px;height:32px;"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
          Job Portal
        </a>
      </div>

      <h1>Create Account</h1>
      <p>Join Job Portal and start your journey</p>

      <!-- Role Selector -->
      <div class="role-selector" id="role-selector">
        <div class="role-option active" id="role-seeker">
          <input type="radio" name="role" value="job_seeker" checked style="display:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          <span>Job Seeker</span>
        </div>
        <div class="role-option" id="role-employer">
          <input type="radio" name="role" value="employer" style="display:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
          <span>Employer</span>
        </div>
      </div>

      <!-- BACKEND: Change action to: action="index.php?c=auth&a=register" method="POST"
           Add CSRF: <input type="hidden" name="csrf_token" value="&lt;?= $_SESSION['csrf_token'] ?&gt;">
           
           AuthController::register() should:
           1. Validate role: in_array($_POST['role'], ['job_seeker', 'employer'])
           2. Validate email: filter_var + SELECT COUNT(*) FROM users WHERE email = ? (must be 0)
           3. Validate password: strlen >= 8, confirm_password === password
           4. Sanitize: htmlspecialchars(trim($_POST['first_name'])), etc.
           5. Hash: $hash = password_hash($_POST['password'], PASSWORD_BCRYPT)
           6. INSERT: INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES (?,?,?,?,?)
           7. Auto-login: $_SESSION['user_id'] = $pdo->lastInsertId(); etc.
           8. Redirect based on role
           
           Pre-fill form fields on validation failure:
           <input value="&lt;?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?&gt;">
      -->
      <form action="<?= $baseUrl ?>/submit" method="POST" data-validate id="register-form">
        <input type="hidden" name="role" value="job_seeker" id="role-hidden">

        <div class="form-row">
          <div class="form-group">
            <label for="reg-first-name">First Name</label>
            <input type="text" class="form-control" name="first_name" placeholder="First name" required id="reg-first-name">
            <span class="form-error">First name is required</span>
          </div>
          <div class="form-group">
            <label for="reg-last-name">Last Name</label>
            <input type="text" class="form-control" name="last_name" placeholder="Last name" required id="reg-last-name">
            <span class="form-error">Last name is required</span>
          </div>
        </div>

        <div class="form-group">
          <label for="reg-email">Email Address</label>
          <input type="email" class="form-control" name="email" placeholder="Enter your email" required id="reg-email">
          <span class="form-error">Please enter a valid email</span>
        </div>

        <div class="form-group">
          <label for="reg-password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Create a password" required id="reg-password">
          <span class="form-error">Password is required (min 8 characters)</span>
        </div>

        <div class="form-group">
          <label for="reg-confirm-password">Confirm Password</label>
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm your password" required id="reg-confirm-password">
          <span class="form-error">Passwords must match</span>
        </div>

        <div style="margin-bottom:var(--space-md);">
          <label style="display:flex;align-items:flex-start;gap:var(--space-sm);font-size:13px;cursor:pointer;color:var(--clr-text-gray);">
            <input type="checkbox" name="terms" value="1" required style="accent-color:var(--clr-primary);width:16px;height:16px;margin-top:2px;" id="terms-checkbox">
            I agree to the <a href="#" style="color:var(--clr-primary);">Terms & Conditions</a> and <a href="#" style="color:var(--clr-primary);">Privacy Policy</a>
          </label>
        </div>

        <button type="submit" class="btn btn-primary" id="register-submit">Create Account</button>
      </form>

      <div class="auth-footer" id="register-footer">
        Already have an account? <a href="<?= $baseUrl ?>/login">Login</a>
      </div>
    </div>
  </main>

  <script>
    // Sync role selector with hidden input
    document.querySelectorAll('.role-option').forEach(function(option) {
      option.addEventListener('click', function() {
        var radio = option.querySelector('input[type="radio"]');
        if (radio) {
          document.querySelector('#role-hidden').value = radio.value;
        }
      });
    });
  </script>

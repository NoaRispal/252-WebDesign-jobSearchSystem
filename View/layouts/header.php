<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Find your dream job today. Browse thousands of job listings from top companies. Job Portal connects job seekers with employers worldwide.">
  <title>Job Portal — Find Your Dream Job Today</title>
  <link rel="stylesheet" href="<?= $baseUrl ?>/style.css">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23309689'><path d='M20 6h-4V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v11a3 3 0 003 3h14a3 3 0 003-3V8a2 2 0 00-2-2zM10 4h4v2h-4V4z'/></svg>">
</head>
<body>

  <!-- ====== NAVBAR ====== -->
  <nav class="navbar" id="navbar">
    <div class="container">
      <a href="<?= $baseUrl ?>/home" class="navbar-logo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        Job Portal
      </a>

      <div class="navbar-nav" id="navbar-nav">
        <a href="<?= $baseUrl ?>/home" class="<?= ($urlParam === 'home' || $urlParam === '') ? 'active' : '' ?>">Home</a>
        <a href="<?= $baseUrl ?>/jobs" class="<?= (strpos($urlParam, 'jobs') === 0) ? 'active' : '' ?>">Jobs</a>
        <a href="<?= $baseUrl ?>/about" class="<?= $urlParam === 'about' ? 'active' : '' ?>">About Us</a>
        <a href="<?= $baseUrl ?>/contact" class="<?= $urlParam === 'contact' ? 'active' : '' ?>">Contact Us</a>
      </div>

      <div class="navbar-actions">
        <?php if (strpos($urlParam, 'admin') === 0): ?>
          <span style="font-size:14px;color:var(--clr-text-gray);display:flex;align-items:center;gap:var(--space-sm);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Admin
          </span>
          <a href="<?= $baseUrl ?>/login" class="btn btn-outline btn-sm">Logout</a>
        <?php elseif (strpos($urlParam, 'employer') === 0): ?>
          <span style="font-size:14px;color:var(--clr-text-gray);display:flex;align-items:center;gap:var(--space-sm);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Employer
          </span>
          <a href="<?= $baseUrl ?>/login" class="btn btn-outline btn-sm" id="logout-btn">Logout</a>
        <?php else: ?>
          <a href="<?= $baseUrl ?>/login" class="btn-login" <?= $urlParam === 'login' ? 'style="color:var(--clr-primary);"' : '' ?>>Login</a>
          <a href="<?= $baseUrl ?>/register" class="btn-register" <?= $urlParam === 'register' ? 'style="background:var(--clr-primary-dark);"' : '' ?>>Register</a>
        <?php endif; ?>
      </div>

      <button class="navbar-hamburger" id="hamburger" aria-label="Toggle navigation">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobile-menu">
    <a href="<?= $baseUrl ?>/home" class="<?= ($urlParam === 'home' || $urlParam === '') ? 'active' : '' ?>">Home</a>
    <a href="<?= $baseUrl ?>/jobs" class="<?= (strpos($urlParam, 'jobs') === 0) ? 'active' : '' ?>">Jobs</a>
    <a href="<?= $baseUrl ?>/about" class="<?= $urlParam === 'about' ? 'active' : '' ?>">About Us</a>
    <a href="<?= $baseUrl ?>/contact" class="<?= $urlParam === 'contact' ? 'active' : '' ?>">Contact Us</a>
    
    <?php if (strpos($urlParam, 'admin') === 0 || strpos($urlParam, 'employer') === 0): ?>
        <a href="<?= $baseUrl ?>/login" class="btn btn-outline">Logout</a>
    <?php else: ?>
        <a href="<?= $baseUrl ?>/login" <?= $urlParam === 'login' ? 'class="active"' : '' ?>>Login</a>
        <a href="<?= $baseUrl ?>/register" class="btn btn-primary">Register</a>
    <?php endif; ?>
  </div>

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

<?php
    // Determine which dashboard context we're in
    $isAdminDashboard = (strpos($urlParam, 'admin') === 0);
    $isEmployerDashboard = (strpos($urlParam, 'employer') === 0);
    $isDashboard = $isAdminDashboard || $isEmployerDashboard;
    $isJobSeeker = (isset($_SESSION['role']) && $_SESSION['role'] === 'job_seeker');
    // Admin browsing public pages (session is admin but not on admin dashboard)
    $isAdminBrowsing = (!$isDashboard && isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

    // Mobile menu links for dashboard contexts
    $dashboardMobileLinks = [];
    if ($isAdminDashboard) {
      $dashboardMobileLinks = [
        ['href' => $baseUrl . '/admin/dashboard',  'label' => 'Dashboard',        'active' => ($urlParam === 'admin' || $urlParam === 'admin/dashboard')],
        ['href' => $baseUrl . '/admin/references', 'label' => 'Reference Tables', 'active' => ($urlParam === 'admin/references')],
        ['href' => $baseUrl . '/admin/users',      'label' => 'Users',            'active' => ($urlParam === 'admin/users')],
        ['href' => $baseUrl . '/home',             'label' => 'Browse Site',      'active' => false],
      ];
    } elseif ($isEmployerDashboard) {
      $dashboardMobileLinks = [
        ['href' => $baseUrl . '/employer/dashboard', 'label' => 'Dashboard',  'active' => ($urlParam === 'employer' || $urlParam === 'employer/dashboard')],
        ['href' => $baseUrl . '/employer/job-form',  'label' => 'Create Job', 'active' => ($urlParam === 'employer/job-form')],
      ];
    }

    // Show mobile menu for public pages and dashboard pages
    $showMobileNav = (!$isDashboard) || !empty($dashboardMobileLinks);
?>

  <!-- ====== NAVBAR ====== -->
  <!-- BEFORE ROLE-BASED NAVBAR REFACTOR (original header.php):
       The navbar showed full nav links (Home, Jobs, About, Contact) on all pages.
       Admin/employer pages showed role badge + Logout in navbar-actions.
       Job seekers saw Login/Register like guests.
  END BEFORE ROLE-BASED NAVBAR REFACTOR -->
  <nav class="navbar" id="navbar">
    <div class="container">
      <a href="<?= $baseUrl ?>/home" class="navbar-logo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        Job Portal
      </a>

      <?php if (!$isDashboard): ?>
        <!-- Public navigation links — shown for guests, job seekers, and public pages -->
        <div class="navbar-nav" id="navbar-nav">
          <a href="<?= $baseUrl ?>/home" class="<?= ($urlParam === 'home' || $urlParam === '') ? 'active' : '' ?>">Home</a>
          <a href="<?= $baseUrl ?>/jobs" class="<?= (strpos($urlParam, 'jobs') === 0) ? 'active' : '' ?>">Jobs</a>
          <a href="<?= $baseUrl ?>/about" class="<?= $urlParam === 'about' ? 'active' : '' ?>">About Us</a>
          <a href="<?= $baseUrl ?>/contact" class="<?= $urlParam === 'contact' ? 'active' : '' ?>">Contact Us</a>
        </div>
        
      <?php endif; ?>

      <div class="navbar-actions">
        <?php if ($isAdminDashboard): ?>
          <!-- Admin dashboard: minimal badge + Browse Site link -->
          <a href="<?= $baseUrl ?>/home" class="btn btn-outline btn-sm" id="browse-site-btn" title="Browse the public job seeker pages">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Browse Site
          </a>
          <span style="font-size:14px;color:var(--clr-text-gray);display:flex;align-items:center;gap:var(--space-sm);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Admin
          </span>
          <a href="<?= $baseUrl ?>/logout" class="btn btn-outline-danger btn-sm" title="Logout from the Admin Dashboard">
            Logout
          </a>
          

        <?php elseif ($isEmployerDashboard): ?>
          <!-- Employer dashboard: minimal badge only — logout handled by sidebar -->
          <span style="font-size:14px;color:var(--clr-text-gray);display:flex;align-items:center;gap:var(--space-sm);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Employer
          </span>
          <a href="<?= $baseUrl ?>/logout" class="btn btn-outline-danger btn-sm" title="Logout from the Admin Dashboard">
            Logout
          </a>

        <?php elseif ($isAdminBrowsing): ?>
          <!-- Admin browsing public pages: show "Back to Dashboard" -->
          <a href="<?= $baseUrl ?>/admin/dashboard" class="btn btn-primary btn-sm" id="back-to-dashboard-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Dashboard
          </a>
          <span style="font-size:14px;color:var(--clr-text-gray);display:flex;align-items:center;gap:var(--space-sm);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Admin
          </span>
          <a href="<?= $baseUrl ?>/logout" class="btn btn-outline-danger btn-sm" title="Logout from the Admin Dashboard">
            Logout
          </a>
          

        <?php elseif ($isJobSeeker): ?>
          <!-- Logged-in job seeker: profile badge + logout -->
          <span style="font-size:14px;color:var(--clr-text-gray);display:flex;align-items:center;gap:var(--space-sm);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?= htmlspecialchars($_SESSION['full_name'] ?? 'Job Seeker') ?>
          </span>
          <a href="<?= $baseUrl ?>/logout" class="btn btn-outline-danger btn-sm" title="Logout from the Admin Dashboard">
            Logout
          </a>

        <?php else: ?>
          <!-- Guest: Login + Register -->
          <a href="<?= $baseUrl ?>/login" class="btn-login" <?= $urlParam === 'login' ? 'style="color:var(--clr-primary);"' : '' ?>>Login</a>
          <a href="<?= $baseUrl ?>/register" class="btn-register" <?= $urlParam === 'register' ? 'style="background:var(--clr-primary-dark);"' : '' ?>>Register</a>
        <?php endif; ?>
      </div>

      <?php if ($showMobileNav): ?>
        <button class="navbar-hamburger" id="hamburger" aria-label="Toggle navigation">
          <span></span><span></span><span></span>
        </button>
      <?php endif; ?>
    </div>
  </nav>

  <?php if ($showMobileNav): ?>
  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobile-menu">
    <?php if ($isDashboard): ?>
      <?php foreach ($dashboardMobileLinks as $item): ?>
        <a href="<?= $item['href'] ?>" class="<?= $item['active'] ? 'active' : '' ?>"><?= $item['label'] ?></a>
      <?php endforeach; ?>
      <a href="<?= $baseUrl ?>/logout" class="btn btn-outline-danger btn-sm" title="Logout">Logout</a>
    <?php else: ?>
      <a href="<?= $baseUrl ?>/home" class="<?= ($urlParam === 'home' || $urlParam === '') ? 'active' : '' ?>">Home</a>
      <a href="<?= $baseUrl ?>/jobs" class="<?= (strpos($urlParam, 'jobs') === 0) ? 'active' : '' ?>">Jobs</a>
      <a href="<?= $baseUrl ?>/about" class="<?= $urlParam === 'about' ? 'active' : '' ?>">About Us</a>
      <a href="<?= $baseUrl ?>/contact" class="<?= $urlParam === 'contact' ? 'active' : '' ?>">Contact Us</a>
      
      <?php if ($isAdminBrowsing): ?>
        <a href="<?= $baseUrl ?>/admin/dashboard" class="btn btn-primary">&larr; Back to Dashboard</a>
      <?php elseif ($isJobSeeker): ?>
        <a href="<?= $baseUrl ?>/logout" class="btn btn-outline-danger btn-sm" title="Logout from the Admin Dashboard">Logout</a>
      <?php else: ?>
        <a href="<?= $baseUrl ?>/login" <?= $urlParam === 'login' ? 'class="active"' : '' ?>>Login</a>
        <a href="<?= $baseUrl ?>/register" class="btn btn-primary">Register</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
<?php endif; ?>

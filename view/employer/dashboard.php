<!-- BEFORE $user FIX: $user was expected from an employer controller that doesn't exist yet.
     Fallback derives user info from $_SESSION until backend implements EmployerController. -->
<?php if (!isset($user)):
  $fullNameParts = explode(' ', $_SESSION['full_name'] ?? 'Employer User', 2);
  $user = [
    'first_name' => $fullNameParts[0] ?? 'Employer',
    'last_name'  => $fullNameParts[1] ?? '',
    'email'      => $_SESSION['email'] ?? ($_SESSION['full_name'] ?? 'employer') . '@company.com',
  ];
endif; ?>
<!-- ====== DASHBOARD LAYOUT ====== -->
  <div class="dashboard-layout" id="dashboard-layout">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar" id="dashboard-sidebar">
      <div style="margin-bottom:var(--space-xl);">
        <div style="display:flex;align-items:center;gap:var(--space-md);">
          <div style="width:44px;height:44px;border-radius:var(--radius-full);background:var(--clr-primary);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;">
            <?= strtoupper(substr($user['first_name'],0,1) . substr($user['last_name'],0,1)) ?>
          </div>
          <div>
            <div style="font-weight:600;color:white;font-size:15px;"><?= strtoupper(substr($user['first_name'],0,1) . substr($user['last_name'],0,1)) ?>.</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);"><?= htmlspecialchars($user['email']) ?></div>
          </div>
        </div>
      </div>
      <nav class="dashboard-sidebar-nav" id="sidebar-nav">
        <a href="<?= $baseUrl ?>/employer/dashboard" class="active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Dashboard
        </a>
        <a href="<?= $baseUrl ?>/employer/job-form">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
          Create Job
        </a>
        <a href="#">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
          My Jobs
        </a>
        <a href="#">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Profile
        </a>
        <a href="#">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
          Settings
        </a>
        <!-- BEFORE LOGOUT FIX: href pointed to /login without clearing session -->
        <a href="<?= $baseUrl ?>/logout" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Logout
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main" id="dashboard-main">
      <div class="dashboard-header">
        <h1>Dashboard</h1>
        <a href="<?= $baseUrl ?>/employer/job-form" class="btn btn-primary" id="create-job-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
          Create New Job
        </a>
      </div>

      <!-- Stats -->
      <!-- BACKEND: Replace hardcoded stats with DB counts:
           <h3>< ?= $totalJobs ?></h3>     (Total Jobs Posted)
           <h3>< ?= $count(all_jobs[]) ?></h3>     (Active Jobs)
           <h3>< ?= $pendingJobs ?></h3>    (Pending Review)
           <h3>< ?= $inactiveJobs ?></h3>   (Inactive Jobs)

           SQL: SELECT
                  COUNT(*) as total,
                  SUM(is_active = 1) as active,
                  SUM(is_active = 0) as inactive
                FROM job_vacancies
                WHERE employer_id = ?
      -->
      <div class="dashboard-stats" id="dashboard-stats">
        <div class="dashboard-stat-card">
          <div class="stat-icon green">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
          </div>
          <h3><?= count($all_jobs)?></h3>
          <p>Total Jobs Posted</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon blue">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <h3>
            <?= count(array_filter($jobs, function($job) {return $job['is_active'] == 1;})); ?>
          </h3>
          <p>Active Jobs</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon orange">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          </div>
          <h3>
            <?= count(array_filter($jobs, function($job) {return $job['status'] == 'pending';})); ?>
          </h3>
          <p>Pending Review</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon red">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
          </div>
          <h3>
            <?= count(array_filter($jobs, function($job) {return $job['is_active'] == 0;})); ?>
          </h3>
          <p>Inactive Jobs</p>
        </div>
      </div>

      <!-- Jobs Table -->
      <div class="dashboard-table-card" id="jobs-table-card">
        <div class="dashboard-table-header">
          <h2>My Job Postings</h2>
          <div style="display:flex;gap:var(--space-sm);align-items:center;">
            <input type="text" class="form-control" placeholder="Search jobs..." style="width:200px;padding:8px 12px;" id="table-search">
          </div>
        </div>
        <div style="overflow-x:auto;">
          <table class="dashboard-table" id="jobs-table">
            <thead>
              <tr>
                <th>Job Title</th>
                <th>Category</th>
                <th>Type</th>
                <th>Location</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Posted</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <!-- 
                 Edit button href: Links to employer-job-form.php?id=JOB_ID
                   → JobController::edit() pre-populates the form with existing data
                 Toggle button: POSTs to JobController::toggleStatus()
                   → UPDATE job_vacancies SET is_active = NOT is_active WHERE id = ? AND employer_id = ?
                 Delete button: POSTs to JobController::delete()
                   → DELETE FROM job_vacancies WHERE id = ? AND employer_id = ?
                   → Also DELETE FROM job_vacancy_skills WHERE job_vacancy_id = ?
            -->
            <!-- BEFORE RESPONSIVE CARD REFACTOR:
            < ?php /* foreach($all_jobs as $job): ?>
                <tr>
                  <td><strong>< ?= htmlspecialchars($job['title']) ?></strong></td>
                  <td>< ?= htmlspecialchars($job['category_name']) ?></td>
                  <td>< ?= htmlspecialchars($job['employment_type_name']) ?></td>
                  <td>< ?= htmlspecialchars($job['city'] . ', ' . $job['country']) ?></td>
                  <td>< ?= htmlspecialchars($job['salary_label']) ?></td>
                  <td><span class="status-badge < ?= $job['is_active'] ? 'active' : 'inactive' ?>">
                    < ?= $job['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                  <td>< ?= date('M d, Y', strtotime($job['created_at'])) ?></td>
                  <td>
                    <div class="table-actions">
                      <a href="employer-job-form.php?id=< ?= $job['id'] ?>" title="Edit">edit icon</a>
                      <form method="POST" action="index.php?c=job&a=toggleStatus" style="display:inline;">
                        <input type="hidden" name="job_id" value="< ?= $job['id'] ?>">
                        <button type="submit" title="Toggle Status">toggle icon</button>
                      </form>
                      <form method="POST" action="index.php?c=job&a=delete" style="display:inline;">
                        <input type="hidden" name="job_id" value="< ?= $job['id'] ?>">
                        <button type="submit" class="delete" title="Delete">delete icon</button>
                      </form>
                    </div>
                  </td>
                </tr>
              < ?php endforeach; */ ?>
            END BEFORE RESPONSIVE CARD REFACTOR -->

            <?php foreach($all_jobs as $job): ?>
                <tr>
                  <td class="card-primary" data-label="Job Title"><strong><?= htmlspecialchars($job['title']) ?></strong></td>
                  <td class="card-detail" data-label="Category"><?= htmlspecialchars($job['category_name']) ?></td>
                  <td class="card-detail" data-label="Type"><?= htmlspecialchars($job['employment_type_name']) ?></td>
                  <td class="card-detail" data-label="Location"><?= htmlspecialchars($job['city'] . ', ' . $job['country']) ?></td>
                  <td class="card-detail" data-label="Salary"><?= htmlspecialchars($job['salary_label']) ?></td>
                  <td class="card-primary" data-label="Status"><span class="status-badge <?= $job['is_active'] ? 'active' : 'inactive' ?>">
                    <?= $job['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                  <td class="card-detail" data-label="Posted"><?= date('M d, Y', strtotime($job['created_at'])) ?></td>
                  <!-- BEFORE ICON FIX: <a ...>edit icon</a> / <button ...>toggle icon</button> / <button ...>delete icon</button> -->
                  <td class="card-detail" data-label="Actions">
                    <div class="table-actions">
                      <a href="employer-job-form.php?id=<?= $job['id'] ?>" title="Edit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                      </a>
                      <form method="POST" action="index.php?c=job&a=toggleStatus" style="display:inline;">
                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                        <button type="submit" title="Toggle Status">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6"/><path d="M23 20v-6h-6"/><path d="M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"/></svg>
                        </button>
                      </form>
                      <form method="POST" action="index.php?c=job&a=delete" style="display:inline;">
                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                        <button type="submit" class="delete" title="Delete">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        </button>
                      </form>
                    </div>
                  </td>
                  <td class="card-chevron" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script src="<?= $baseUrl ?>/script.js"></script>
</body>
</html>

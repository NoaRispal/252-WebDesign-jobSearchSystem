<!-- ====== FLASH ====== -->
<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
        <?= $_SESSION['flash']; ?>
    </div>
    <?php 
        unset($_SESSION['flash']); 
    ?>
<?php endif; ?>

<!-- ====== DASHBOARD LAYOUT ====== -->
  <div class="dashboard-layout" id="dashboard-layout">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar" id="dashboard-sidebar">
      <div style="margin-bottom:var(--space-xl);">
        <div style="display:flex;align-items:center;gap:var(--space-md);">
          <div style="width:44px;height:44px;border-radius:var(--radius-full);background:green;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;">E</div>
          <div>
            <div style="font-weight:600;color:white;font-size:15px;">Employer</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);">employer@company.com</div>
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
            <?= count(array_filter($all_jobs, function($job) {return $job['Is_Active'] == 1;})); ?>
          </h3>
          <p>Active Jobs</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon red">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>
          </div>
          <h3>
            <?= count(array_filter($all_jobs, function($job) {return $job['Is_Active'] == 0;})); ?>
          </h3>
          <p>Inactive Jobs</p>
        </div>
      </div>

      <!-- Jobs Table -->
      <div class="dashboard-table-card" id="jobs-table-card">
        <div class="dashboard-table-header">
          <h2>My Job Postings</h2>
          <!-- <div style="display:flex;gap:var(--space-sm);align-items:center;">
            <input type="text" class="form-control" placeholder="Search jobs..." style="width:200px;padding:8px 12px;" id="table-search">
          </div> -->
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
            <?php foreach($all_jobs as $job): ?>
                <tr>
                  <td class="card-primary" data-label="Job Title"><strong><?= htmlspecialchars($job['Title_Name']) ?></strong></td>
                  <td class="card-detail" data-label="Category"><?= htmlspecialchars($job['Category_Name']) ?></td>
                  <td class="card-detail" data-label="Type"><?= htmlspecialchars($job['Employment_Type_Name']) ?></td>
                  <td class="card-detail" data-label="Location"><?= htmlspecialchars($job['City_Name'] . ', ' . $job['Country_Name']) ?></td>
                  <td class="card-detail" data-label="Salary"><?= htmlspecialchars($job['Range_Description']) ?></td>
                  <td class="card-primary" data-label="Status"><span class="status-badge <?= $job['Is_Active'] ? 'active' : 'inactive' ?>">
                  <?= $job['Is_Active'] ? 'Active' : 'Inactive' ?></span></td>
                  <td class="card-detail" data-label="Posted"><?= date('M d, Y', strtotime($job['Posting_Date'])) ?></td>
                  <td class="card-detail" data-label="Actions">
                    <div class="table-actions">
                      <a href="<?= $baseUrl ?>/employer/job-form?job_id_edit=<?= $job['Vacancy_ID'] ?>" title="Edit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                      </a>
                      <form method="POST" action="<?= $baseUrl ?>/employer/toggle" style="display:inline;">
                        <input type="hidden" name="job_id" value="<?= $job['Vacancy_ID'] ?>">
                        <input type="hidden" name="status" value="<?= $job['Is_Active'] ?>">
                        <button type="submit" title="Toggle Status">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6"/><path d="M23 20v-6h-6"/><path d="M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"/></svg>
                        </button>
                      </form>
                      <form method="POST" action="<?= $baseUrl ?>/employer/delete" style="display:inline;">
                        <input type="hidden" name="job_id" value="<?= $job['Vacancy_ID'] ?>">
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

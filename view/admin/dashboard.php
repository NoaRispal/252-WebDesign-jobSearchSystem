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
    <aside class="dashboard-sidebar" id="dashboard-sidebar">
      <div style="margin-bottom:var(--space-xl);">
        <div style="display:flex;align-items:center;gap:var(--space-md);">
          <div style="width:44px;height:44px;border-radius:var(--radius-full);background:#E74C3C;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;">A</div>
          <div>
            <div style="font-weight:600;color:white;font-size:15px;">Administrator</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);">admin@jobportal.com</div>
          </div>
        </div>
      </div>
      <nav class="dashboard-sidebar-nav">
        <a href="<?= $baseUrl ?>/admin/dashboard" class="active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Dashboard
        </a>
        <a href="<?= $baseUrl ?>/admin/references">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4a2 2 0 012-2h8.5L20 7.5V20a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/><polyline points="14 2 14 8 20 8"/></svg>
          Reference Tables
        </a>
        <a href="<?= $baseUrl ?>/admin/users">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
          Users
        </a>
        <!-- BEFORE LOGOUT FIX: href pointed to /login without clearing session -->
        <a href="<?= $baseUrl ?>/logout" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Logout
        </a>
      </nav>
    </aside>

    <main class="dashboard-main" id="dashboard-main">
      <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <a href="<?= $baseUrl ?>/admin/references" class="btn btn-primary" id="manage-refs-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 7V4a2 2 0 012-2h8.5L20 7.5V20a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/><polyline points="14 2 14 8 20 8"/></svg>
          Manage Reference Tables
        </a>
      </div>

      <!-- Stats -->
      <div class="dashboard-stats" id="admin-stats">
        <div class="dashboard-stat-card">
          <div class="stat-icon green"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg></div>
          <h3><?= count($allJobs) ?></h3>
          <p>Total Job Postings</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon blue"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
          <h3><?= $employerCount ?></h3>
          <p>Employers</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon orange"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
          <h3><?= $seekerCount ?></h3>
          <p>Job Seekers</p>
        </div>
        <!-- <div class="dashboard-stat-card">
          <div class="stat-icon red"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
          <h3>7</h3>
          <p>Flagged Postings</p>
        </div> -->
      </div>

      <!-- All Jobs Table -->
      <div class="dashboard-table-card" id="all-jobs-table-card">
        <div class="dashboard-table-header">
          <h2>All Job Postings</h2>
          <input type="text" class="form-control" placeholder="Search postings..." style="width:200px;padding:8px 12px;" id="admin-table-search">
        </div>
        <div style="overflow-x:auto;">
          <table class="dashboard-table" id="admin-jobs-table">
            <thead>
              <tr>
                <th>Job Title</th>
                <th>Employer</th>
                <th>Category</th>
                <th>Location</th>
                <th>Status</th>
                <th>Posted</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                <!-- OLD VERSION (Commented out for reference)
                <?php /* foreach($allJobs as $job): ?>;
                  <tr>
                    <td><strong><?= htmlspecialchars($job['title']) ?>;</strong></td>
                    <td><?= htmlspecialchars($job['employer_name']) ?>;</td>
                    <td><?= htmlspecialchars($job['category_name']) ?>;</td>
                    <td><?= htmlspecialchars($job['city'] . ', ' . $job['country']) ?>;</td>
                    <td><span class="status-badge <?= $job['is_active'] ? 'active' : 'inactive' ?>;">
                      <?= $job['is_active'] ? 'Active' : 'Inactive' ?>;</span></td>
                    <td><?= date('M d, Y', strtotime($job['created_at'])) ?>;</td>
                    <td><div class="table-actions">
                      <a href="<?= $baseUrl ?>;/jobs/detail?id=<?= $job['id'] ?>;" title="View">view icon</a>
                      <form method="POST" action="index.php?c=admin&a=removeJob">
                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>;">
                        <button class="delete" title="Remove">remove icon</button>
                      </form>
                    </div></td>
                  </tr>
                <?php endforeach; */ ?> 
                -->
                <!-- BEFORE RESPONSIVE CARD REFACTOR:
                <?php /* foreach($allJobs as $job): ?>
                  <tr>
                    <td><strong><?= htmlspecialchars($job['Title_Name'] ?? 'Unknown Title') ?></strong></td>
                    <td><?= htmlspecialchars($job['Company_Name'] ?? 'Unknown Employer') ?></td>
                    <td><?= htmlspecialchars($job['Category_Name'] ?? 'Unknown Category') ?></td>
                    <td><?= htmlspecialchars(($job['City_Name'] ?? '') . ', ' . ($job['Country_Name'] ?? '')) ?></td>
                    <td><span class="status-badge <?= !empty($job['Is_Active']) ? 'active' : 'inactive' ?>">
                      <?= !empty($job['Is_Active']) ? 'Active' : 'Inactive' ?></span></td>
                    <td><?= date('M d, Y', strtotime($job['Posting_Date'] ?? 'now')) ?></td>
                    <td><div class="table-actions">
                      <a href="<?= $baseUrl ?>/jobs/detail?id=<?= $job['Vacancy_ID'] ?? '' ?>" title="View">view icon</a>
                      <form method="POST" action="index.php?c=admin&a=removeJob">
                        <input type="hidden" name="job_id" value="<?= $job['Vacancy_ID'] ?? '' ?>">
                        <button class="delete" title="Remove">remove icon</button>
                      </form>
                    </div></td>
                  </tr>
                <?php endforeach; */ ?>
                END BEFORE RESPONSIVE CARD REFACTOR -->

                <?php foreach($allJobs as $job): ?>
                  <tr>
                    <td class="card-primary" data-label="Job Title"><strong><?= htmlspecialchars($job['Title_Name'] ?? 'Unknown Title') ?></strong></td>
                    <td class="card-detail" data-label="Employer"><?= htmlspecialchars($job['Company_Name'] ?? 'Unknown Employer') ?></td>
                    <td class="card-detail" data-label="Category"><?= htmlspecialchars($job['Category_Name'] ?? 'Unknown Category') ?></td>
                    <td class="card-detail" data-label="Location"><?= htmlspecialchars(($job['City_Name'] ?? '') . ', ' . ($job['Country_Name'] ?? '')) ?></td>
                    <td class="card-primary" data-label="Status"><span class="status-badge <?= !empty($job['Is_Active']) ? 'active' : 'inactive' ?>">
                      <?= !empty($job['Is_Active']) ? 'Active' : 'Inactive' ?></span></td>
                    <td class="card-detail" data-label="Posted"><?= date('M d, Y', strtotime($job['Posting_Date'] ?? 'now')) ?></td>
                    <!-- BEFORE ICON FIX: <a ...>view icon</a> / <button ...>remove icon</button> -->
                    <td class="card-detail" data-label="Actions"><div class="table-actions">
                      <a href="<?= $baseUrl ?>/jobs/detail?id=<?= $job['Vacancy_ID'] ?? '' ?>" title="View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      </a>
                      <form method="POST" action="<?= $baseUrl ?>/admin/removeJob">
                        <input type="hidden" name="job_id" value="<?= $job['Vacancy_ID'] ?? '' ?>">
                        <button class="delete" title="Remove">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        </button>
                      </form>
                    </div></td>
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

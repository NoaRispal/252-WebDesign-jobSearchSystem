<!-- BACKEND: Rename to admin-dashboard.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->
<!-- BACKEND: ACCESS GUARD — Admin only:
     if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
       header('Location: login.php'); exit;
     }
-->
<!-- BACKEND: Controller passes these variables:
     - $allJobs       (array)  — all job_vacancies with JOINs (no employer_id filter)
     - $totalPostings  (int)   — COUNT(*) FROM job_vacancies
     - $employerCount  (int)   — COUNT(*) FROM users WHERE role='employer'
     - $seekerCount    (int)   — COUNT(*) FROM users WHERE role='job_seeker'
     - $flaggedCount   (int)   — COUNT(*) of flagged/reported postings
     
     Admin can DELETE any posting regardless of employer.
     View button: links to job-details.php?id=X
     Remove button: POSTs to AdminController::removeJob()
       → DELETE FROM job_vacancy_skills WHERE job_vacancy_id = ?
       → DELETE FROM job_vacancies WHERE id = ?
-->
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
        <a href="#">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
          All Job Postings
        </a>
        <a href="#">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
          Users
        </a>
        <a href="#">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
          Settings
        </a>
        <a href="<?= $baseUrl ?>/login" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);">
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
          <h3>156</h3>
          <p>Total Job Postings</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon blue"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
          <h3>48</h3>
          <p>Employers</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon orange"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
          <h3>312</h3>
          <p>Job Seekers</p>
        </div>
        <div class="dashboard-stat-card">
          <div class="stat-icon red"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
          <h3>7</h3>
          <p>Flagged Postings</p>
        </div>
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
              <!-- BACKEND: Replace static rows with PHP loop:
                   &lt;?php foreach($allJobs as $job): ?&gt;
                     <tr>
                       <td><strong>&lt;?= htmlspecialchars($job['title']) ?&gt;</strong></td>
                       <td>&lt;?= htmlspecialchars($job['employer_name']) ?&gt;</td>
                       <td>&lt;?= htmlspecialchars($job['category_name']) ?&gt;</td>
                       <td>&lt;?= htmlspecialchars($job['city'] . ', ' . $job['country']) ?&gt;</td>
                       <td><span class="status-badge &lt;?= $job['is_active'] ? 'active' : 'inactive' ?&gt;">
                         &lt;?= $job['is_active'] ? 'Active' : 'Inactive' ?&gt;</span></td>
                       <td>&lt;?= date('M d, Y', strtotime($job['created_at'])) ?&gt;</td>
                       <td><div class="table-actions">
                         <a href="&lt;?= $baseUrl ?&gt;/jobs/detail?id=&lt;?= $job['id'] ?&gt;" title="View">view icon</a>
                         <form method="POST" action="index.php?c=admin&a=removeJob">
                           <input type="hidden" name="job_id" value="&lt;?= $job['id'] ?&gt;">
                           <button class="delete" title="Remove">remove icon</button>
                         </form>
                       </div></td>
                     </tr>
                   &lt;?php endforeach; ?&gt;
              -->
              <tr>
                <td><strong>Forward Security Director</strong></td>
                <td>Bauch, Schuppe Co</td>
                <td>Hotels & Tourism</td>
                <td>New York, USA</td>
                <td><span class="status-badge active">Active</span></td>
                <td>Nov 15, 2024</td>
                <td><div class="table-actions">
                  <button title="View" aria-label="View"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                  <button class="delete" title="Remove" aria-label="Remove"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button>
                </div></td>
              </tr>
              <tr>
                <td><strong>Regional Creative Facilitator</strong></td>
                <td>Wisozk - Becker Co</td>
                <td>Media</td>
                <td>Los Angeles, USA</td>
                <td><span class="status-badge active">Active</span></td>
                <td>Nov 14, 2024</td>
                <td><div class="table-actions">
                  <button title="View" aria-label="View"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                  <button class="delete" title="Remove" aria-label="Remove"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button>
                </div></td>
              </tr>
              <tr style="background:rgba(231,76,60,0.03);">
                <td><strong>⚠️ Suspicious Job Post</strong></td>
                <td>Unknown Corp</td>
                <td>Commerce</td>
                <td>N/A</td>
                <td><span class="status-badge pending">Flagged</span></td>
                <td>Nov 12, 2024</td>
                <td><div class="table-actions">
                  <button title="View" aria-label="View"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                  <button class="delete" title="Remove" aria-label="Remove"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button>
                </div></td>
              </tr>
              <tr>
                <td><strong>Corporate Tactics Facilitator</strong></td>
                <td>Cormier, Turner Inc</td>
                <td>Commerce</td>
                <td>Boston, USA</td>
                <td><span class="status-badge inactive">Inactive</span></td>
                <td>Nov 10, 2024</td>
                <td><div class="table-actions">
                  <button title="View" aria-label="View"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                  <button class="delete" title="Remove" aria-label="Remove"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button>
                </div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script src="<?= $baseUrl ?>/script.js"></script>
</body>
</html>

<!-- BACKEND: Rename to admin-references.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->
<!-- BACKEND: ACCESS GUARD — Admin only:
     if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
       header('Location: login.php'); exit;
     }
-->
<!-- BACKEND: Controller passes these variables:
     - $categories      (array) — SELECT * FROM categories ORDER BY name
     - $jobTitles       (array) — SELECT * FROM job_titles ORDER BY name
     - $skills          (array) — SELECT * FROM skills ORDER BY name
     - $industries      (array) — SELECT * FROM industries ORDER BY name
     - $locations       (array) — SELECT * FROM locations ORDER BY country, city
     - $employmentTypes (array) — SELECT * FROM employment_types ORDER BY name
     - $jobLevels       (array) — SELECT * FROM job_levels ORDER BY name
     - $salaryRanges    (array) — SELECT * FROM salary_ranges ORDER BY min_salary
     
     Each tab's table body should loop its array, e.g.:
     &lt;?php foreach($categories as $cat): ?&gt;
       <tr>
         <td>&lt;?= $cat['id'] ?&gt;</td>
         <td>&lt;?= htmlspecialchars($cat['name']) ?&gt;</td>
         <td><span class="status-badge &lt;?= $cat['is_active'] ? 'active' : 'inactive' ?&gt;">
           &lt;?= $cat['is_active'] ? 'Active' : 'Inactive' ?&gt;</span></td>
         <td><div class="table-actions">
           <button data-modal="add-entry-modal" data-edit-id="&lt;?= $cat['id'] ?&gt;" 
                   data-edit-name="&lt;?= htmlspecialchars($cat['name']) ?&gt;">Edit</button>
           <form method="POST" action="index.php?c=admin&a=deleteRef">
             <input type="hidden" name="table" value="categories">
             <input type="hidden" name="id" value="&lt;?= $cat['id'] ?&gt;">
             <button class="delete">Delete</button>
           </form>
         </div></td>
       </tr>
     &lt;?php endforeach; ?&gt;
     
     CRUD Actions for AdminController::refCRUD():
     - CREATE: POST index.php?c=admin&a=addRef    → INSERT INTO $table (name, is_active) VALUES (?, ?)
     - UPDATE: POST index.php?c=admin&a=updateRef → UPDATE $table SET name=?, is_active=? WHERE id=?
     - DELETE: POST index.php?c=admin&a=deleteRef → Check FK refs first, then DELETE FROM $table WHERE id=?
     
     Modal form should include: <input type="hidden" name="table" value="categories">
     to identify which reference table the CRUD operation targets.
     
     IMPORTANT: Before DELETE, check if the entry is referenced by job_vacancies:
     SELECT COUNT(*) FROM job_vacancies WHERE category_id = ?
     If count > 0, deny delete and show error flash.
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
        <a href="<?= $baseUrl ?>/admin/dashboard"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> Dashboard</a>
        <a href="<?= $baseUrl ?>/admin/references" class="active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4a2 2 0 012-2h8.5L20 7.5V20a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/><polyline points="14 2 14 8 20 8"/></svg> Reference Tables</a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> All Job Postings</a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg> Users</a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg> Settings</a>
        <a href="<?= $baseUrl ?>/login" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Logout</a>
      </nav>
    </aside>

    <main class="dashboard-main" id="dashboard-main">
      <div class="dashboard-header">
        <h1>Reference Tables</h1>
        <button class="btn btn-primary" data-modal="add-modal" id="add-new-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
          Add New Entry
        </button>
      </div>

      <!-- Tabs -->
      <div class="admin-tabs" id="admin-tabs">
        <button class="admin-tab active" data-tab="categories">Job Categories</button>
        <button class="admin-tab" data-tab="titles">Job Titles</button>
        <button class="admin-tab" data-tab="skills">Skills</button>
        <button class="admin-tab" data-tab="industries">Industries</button>
        <button class="admin-tab" data-tab="locations">Locations</button>
        <button class="admin-tab" data-tab="employment">Employment Types</button>
        <button class="admin-tab" data-tab="levels">Job Levels</button>
        <button class="admin-tab" data-tab="salary">Salary Ranges</button>
      </div>

      <!-- Panel: Job Categories -->
      <div class="admin-panel active" id="panel-categories">
        <div class="dashboard-table-card">
          <div class="dashboard-table-header">
            <h2>Job Categories</h2>
            <span style="font-size:13px;color:var(--clr-text-gray);">10 entries</span>
          </div>
          <div style="overflow-x:auto;">
            <table class="dashboard-table">
              <thead><tr><th>#</th><th>Category Name</th><th>Job Count</th><th>Status</th><th>Actions</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>Commerce</td><td>150</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>2</td><td>Telecomunications</td><td>120</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>3</td><td>Hotels & Tourism</td><td>112</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>4</td><td>Education</td><td>200</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>5</td><td>Financial Services</td><td>85</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>6</td><td>Construction</td><td>95</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>7</td><td>Media</td><td>78</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>8</td><td>Agriculture</td><td>120</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>9</td><td>Transport</td><td>67</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>10</td><td>Metal Production</td><td>45</td><td><span class="status-badge active">Active</span></td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Panel: Skills (sample) -->
      <div class="admin-panel" id="panel-skills" style="display:none;">
        <div class="dashboard-table-card">
          <div class="dashboard-table-header"><h2>Skills</h2><span style="font-size:13px;color:var(--clr-text-gray);">15 entries</span></div>
          <div style="overflow-x:auto;">
            <table class="dashboard-table">
              <thead><tr><th>#</th><th>Skill Name</th><th>Used By Jobs</th><th>Actions</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>JavaScript</td><td>42</td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>2</td><td>Python</td><td>38</td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>3</td><td>React</td><td>35</td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>4</td><td>Project Management</td><td>28</td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
                <tr><td>5</td><td>Communication</td><td>25</td><td><div class="table-actions"><button title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="delete" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg></button></div></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Hidden panels for other tabs (same structure) -->
      <div class="admin-panel" id="panel-titles" style="display:none;">
        <div class="dashboard-table-card"><div class="dashboard-table-header"><h2>Job Titles</h2></div><div style="padding:var(--space-xl);text-align:center;color:var(--clr-text-gray);">Job Titles table — Content loaded dynamically from database</div></div>
      </div>
      <div class="admin-panel" id="panel-industries" style="display:none;">
        <div class="dashboard-table-card"><div class="dashboard-table-header"><h2>Industries</h2></div><div style="padding:var(--space-xl);text-align:center;color:var(--clr-text-gray);">Industries table — Content loaded dynamically from database</div></div>
      </div>
      <div class="admin-panel" id="panel-locations" style="display:none;">
        <div class="dashboard-table-card"><div class="dashboard-table-header"><h2>Locations</h2></div><div style="padding:var(--space-xl);text-align:center;color:var(--clr-text-gray);">Locations table — Content loaded dynamically from database</div></div>
      </div>
      <div class="admin-panel" id="panel-employment" style="display:none;">
        <div class="dashboard-table-card"><div class="dashboard-table-header"><h2>Employment Types</h2></div><div style="padding:var(--space-xl);text-align:center;color:var(--clr-text-gray);">Employment Types table — Content loaded dynamically from database</div></div>
      </div>
      <div class="admin-panel" id="panel-levels" style="display:none;">
        <div class="dashboard-table-card"><div class="dashboard-table-header"><h2>Job Levels</h2></div><div style="padding:var(--space-xl);text-align:center;color:var(--clr-text-gray);">Job Levels table — Content loaded dynamically from database</div></div>
      </div>
      <div class="admin-panel" id="panel-salary" style="display:none;">
        <div class="dashboard-table-card"><div class="dashboard-table-header"><h2>Salary Ranges</h2></div><div style="padding:var(--space-xl);text-align:center;color:var(--clr-text-gray);">Salary Ranges table — Content loaded dynamically from database</div></div>
      </div>
    </main>
  </div>

  <!-- Add/Edit Modal -->
  <div class="modal-overlay" id="add-modal">
    <div class="modal">
      <div class="modal-header">
        <h2>Add New Entry</h2>
        <button class="modal-close" aria-label="Close modal">&times;</button>
      </div>
      <form action="<?= $baseUrl ?>/submit" method="POST" id="add-entry-form">
        <div class="form-group">
          <label for="entry-name">Name</label>
          <input type="text" class="form-control" name="entry_name" placeholder="Enter name" required id="entry-name">
        </div>
        <div class="form-group">
          <label for="entry-status">Status</label>
          <select class="form-control" name="entry_status" id="entry-status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <div style="display:flex;gap:var(--space-md);justify-content:flex-end;margin-top:var(--space-lg);">
          <button type="button" class="btn btn-outline modal-close">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Entry</button>
        </div>
      </form>
    </div>
  </div>

  <script src="<?= $baseUrl ?>/script.js"></script>
  <script>
    // Show/hide panels on tab click
    document.querySelectorAll('.admin-tab').forEach(function(tab) {
      tab.addEventListener('click', function() {
        document.querySelectorAll('.admin-tab').forEach(function(t) { t.classList.remove('active'); });
        document.querySelectorAll('.admin-panel').forEach(function(p) { p.style.display = 'none'; p.classList.remove('active'); });
        tab.classList.add('active');
        var panel = document.querySelector('#panel-' + tab.getAttribute('data-tab'));
        if (panel) { panel.style.display = 'block'; panel.classList.add('active'); }
      });
    });
  </script>
</body>
</html>

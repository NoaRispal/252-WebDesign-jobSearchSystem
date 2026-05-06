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
      <a href="<?= $baseUrl ?>/admin/dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <a href="<?= $baseUrl ?>/admin/references">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4a2 2 0 012-2h8.5L20 7.5V20a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/><polyline points="14 2 14 8 20 8"/></svg>
        Reference Tables
      </a>
      <a href="<?= $baseUrl ?>/admin/dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        All Job Postings
      </a>
      <a href="<?= $baseUrl ?>/admin/users" class="active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Users
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
        Settings
      </a>
      <a href="<?= $baseUrl ?>/logout" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </a>
    </nav>
  </aside>

  <main class="dashboard-main" id="dashboard-main">

    <div class="dashboard-header">
      <h1>User Management</h1>
      <div class="dashboard-header-actions">
        <span style="color:var(--clr-text-gray); font-size: 14px;"><?= count($data) ?> Users Total</span>
      </div>
        <button class="btn btn-primary" id="add-new-user-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Add New User
        </button>
    </div>

    <!-- Users Table -->
    <div class="dashboard-table-card" id="users-table-card">
      <div class="dashboard-table-header">
        <h2>System Users</h2>
        <input type="text" class="form-control" placeholder="Search users..." style="width:250px;padding:8px 12px;" id="user-table-search">
      </div>
      <div style="overflow-x:auto;">
        <table class="dashboard-table" id="admin-users-table">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Joined Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data as $user): ?>
              <tr>
                <td class="card-detail" data-label="User ID">#<?= $user['User_ID'] ?></td>
                <td class="card-primary" data-label="Full Name">
                    <strong><?= htmlspecialchars(($user['First_Name'] ?? '') . ' ' . ($user['Last_Name'] ?? '')) ?></strong>
                </td>
                <td class="card-detail" data-label="Email"><?= htmlspecialchars($user['Email'] ?? 'No email') ?></td>
                <td class="card-detail" data-label="Role">
                    <?php 
                        $roleMap = [
                            1 => ['label' => 'Admin',    'class' => 'active'],
                            2 => ['label' => 'Employer', 'class' => 'inactive'],
                            3 => ['label' => 'Seeker',   'class' => 'inactive']
                        ];
                        
                        $roleId = $user['Role_ID'] ?? 0;
                        $roleInfo = $roleMap[$roleId] ?? ['label' => 'Unknown', 'class' => 'inactive'];
                    ?>
                    <span class="status-badge <?= $roleInfo['class'] ?>" style="text-transform: capitalize;">
                        <?= htmlspecialchars($roleInfo['label']) ?>
                    </span>
                </td>
                <td class="card-detail" data-label="Joined"><?= date('M d, Y', strtotime($user['Created_At'] ?? 'now')) ?></td>
                <td class="card-detail" data-label="Actions">
                  <div class="table-actions">
                    <!-- View Profile / Edit -->
                    <!-- <a href="<= $baseUrl ?>/admin/user-detail?id=<= $user['User_ID'] ?>" title="View Profile">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a> -->
                    
                    <!-- Delete User (with confirmation form) -->
                    <form method="POST" action="<?= $baseUrl ?>/admin/removeUser" onsubmit="return confirm('Are you sure you want to delete this user?');">
                      <input type="hidden" name="user_id" value="<?= $user['User_ID'] ?>">
                      <button class="delete" title="Delete User">
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

<!-- Modal: Add User -->
<div id="add-user-modal" class="modal-overlay" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div class="modal modal-content" style="background:white; padding:var(--space-xl); border-radius:var(--radius-lg); width:100%; max-width:500px; box-shadow:var(--shadow-lg);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:var(--space-lg);">
            <h2 style="margin:0;">Create New User</h2>
            <button type="button" class="btn btn-cancel" style="background:none; border:none; cursor:pointer; font-size:20px;">&times;</button>
        </div>

        <form action="<?= $baseUrl ?>/admin/addUser" method="POST">
            <div style="margin-bottom:var(--space-md);">
                <label style="display:block; margin-bottom:5px; font-weight:600;">First Name</label>
                <input type="text" name="first_name" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:var(--radius-md);">
            </div>
            
            <div style="margin-bottom:var(--space-md);">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Last Name</label>
                <input type="text" name="last_name" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:var(--radius-md);">
            </div>

            <div style="margin-bottom:var(--space-md);">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Email Address</label>
                <input type="email" name="email" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:var(--radius-md);">
            </div>

            <div style="margin-bottom:var(--space-md);">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Role</label>
                <select name="role_id" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:var(--radius-md);">
                    <option value="3">Job Seeker</option>
                    <option value="2">Employer</option>
                    <option value="1">Administrator</option>
                </select>
            </div>

            <div style="margin-bottom:var(--space-lg);">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Password</label>
                <input type="password" name="password" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:var(--radius-md);">
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn btn-cancel" style="background:#eee;">Cancel</button>
                <button type="submit" class="btn btn-primary">Save User</button>
            </div>
        </form>
    </div>
</div>
<script src="<?= $baseUrl ?>/script.js"></script>
<script>
    // Open
    document.getElementById('add-new-user-btn').addEventListener('click', function() {
        document.getElementById('add-user-modal').classList.add('active');
    });

    // Close
    document.querySelectorAll('.modal-close, .btn-cancel').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('add-user-modal').classList.remove('active');
        });
    });

    // Close
    window.addEventListener('click', function(event) {
        let modal = document.getElementById('add-user-modal');
        if (event.target == modal) {
            modal.classList.remove('active');
        }
    });
</script>
</body>
</html>
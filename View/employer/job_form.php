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
      <nav class="dashboard-sidebar-nav">
        <a href="<?= $baseUrl ?>/employer/dashboard">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Dashboard
        </a>
        <a href="<?= $baseUrl ?>/employer/job-form" class="active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
          Create Job
        </a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> My Jobs</a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Profile</a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg> Settings</a>
        <a href="<?= $baseUrl ?>/login" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main" id="dashboard-main">
      <div class="dashboard-header">
        <h1>Create New Job</h1>
        <a href="<?= $baseUrl ?>/employer/dashboard" class="btn btn-outline btn-sm" id="back-to-dashboard">← Back to Dashboard</a>
      </div>

      <!-- BACKEND: FORM ACTION CHANGES:
           CREATE mode: action="index.php?c=job&a=create" method="POST"
           EDIT mode:   action="index.php?c=job&a=update" method="POST"
           Add CSRF:    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"> -->

      <form action="<?= $baseUrl ?>/index.php?c=job$a=create" method="POST" data-validate id="job-create-form">
        <!-- Hidden field for edit mode — PHP will populate this with the job ID when editing -->
        <!-- BACKEND: value="<?= isset($job) ? $job['id'] : '' ?>" -->
        <input type="hidden" name="job_id" value="" id="job-id-hidden">

        <!-- Section A: Basic Job Information -->
        <div class="job-form-card" id="basic-info-card">
          <h2>A. Basic Job Information</h2>
          <div class="form-row">
            <div class="form-group">
              <label for="job-title">Job Title *</label>
              <!-- BACKEND: Populate from DB + set selected for EDIT:
                   ↑ Apply this same pattern to ALL <select> elements in this form:
                   job_category, employment_type, industry, job_level, country, city, district,
                   work_arrangement, salary_range, salary_type, min_degree, min_experience
              -->
              <select class="form-control" name="job_title" required id="job-title">
                <option value="">Select job title</option>
                <?php foreach($jobTitles as $jt): ?>
                  <option value="<?= $jt['id'] ?>" <?= (isset($job) && $job['job_title_id'] == $jt['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($jt['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Job title is required</span>
            </div>
            <div class="form-group">
              <label for="job-category">Job Category *</label>
              <select class="form-control" name="job_category" required id="job-category">
                <option value="">Select category</option>
                <?php foreach($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= (isset($job) && $job['job_category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Category is required</span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="employment-type">Employment Type *</label>
              <select class="form-control" name="employment_type" required id="employment-type">
                <option value="">Select type</option>
                <?php foreach($employment as $emp): ?>
                  <option value="<?= $emp['id'] ?>" <?= (isset($job) && $job['job_employment_id'] == $emp['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($emp['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Employment type is required</span>
            </div>
            <div class="form-group">
              <label for="industry">Industry *</label>
              <select class="form-control" name="industry" required id="industry">
                <option value="">Select industry</option>
                <?php foreach($industry as $i): ?>
                  <option value="<?= $i['id'] ?>" <?= (isset($job) && $job['job_industry_id'] == $i['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($i['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Industry is required</span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="job-level">Job Level *</label>
              <select class="form-control" name="job_level" required id="job-level">
                <option value="">Select level</option>
                <?php foreach($levels as $l): ?>
                  <option value="<?= $l['id'] ?>" <?= (isset($job) && $job['job_level_id'] == $l['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($l['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Job level is required</span>
            </div>
            <div class="form-group">
              <label for="num-openings">Number of Openings *</label>
              <input type="number" class="form-control" name="num_openings" placeholder="e.g., 3" min="1" required id="num-openings">
              <span class="form-error">Number of openings is required</span>
            </div>
          </div>
        </div>

        <!-- Section B: Job Location -->
        <div class="job-form-card" id="location-card">
          <h2>B. Job Location</h2>
          <div class="form-row">
            <div class="form-group">
              <label for="country">Country *</label>
              <select class="form-control" name="country" required id="country">
                <option value="">Select country</option>
                <?php foreach($countries as $c): ?>
                  <option value="<?= $c['id'] ?>" <?= (isset($job) && $job['job_country_id'] == $c['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Country is required</span>
            </div>
            <div class="form-group">
              <label for="city">City / Province *</label>
              <select class="form-control" name="city" required id="city">
                <option value="">Select city</option>
                <?php foreach($cities as $c): ?>
                  <option value="<?= $c['id'] ?>" <?= (isset($job) && $job['job_city_id'] == $c['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">City is required</span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="district">District (Optional)</label>
              <select class="form-control" name="district" id="district">
                <option value="">Select district</option>
                <?php foreach($district as $d): ?>
                  <option value="<?= $d['id'] ?>" <?= (isset($job) && $job['job_district_id'] == $d['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="work-arrangement">Work Arrangement *</label>
              <select class="form-control" name="work_arrangement" required id="work-arrangement">
                <option value="">Select arrangement</option>
                <?php foreach($arrangement as $a): ?>
                  <option value="<?= $a['id'] ?>" <?= (isset($job) && $job['job_arrangement_id'] == $a['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Work arrangement is required</span>
            </div>
          </div>
        </div>

        <!-- Section C: Salary & Benefits -->
        <div class="job-form-card" id="salary-card">
          <h2>C. Salary & Benefits</h2>
          <div class="form-row">
            <div class="form-group">
              <label for="salary-range">Salary Range *</label>
              <select class="form-control" name="salary_range" required id="salary-range-select">
              <?php foreach($salary as $s): ?>
                  <option value="<?= $s['id'] ?>" <?= (isset($job) && $job['job_salary_id'] == $s['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Salary range is required</span>
            </div>
            <div class="form-group">
              <label for="salary-type">Salary Type *</label>
              <select class="form-control" name="salary_type" required id="salary-type">
                <option value="">Select type</option>
                <?php foreach($salary_type as $st): ?>
                  <option value="<?= $st['id'] ?>" <?= (isset($job) && $job['job_salary_type_id'] == $st['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($st['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Salary type is required</span>
            </div>
          </div>
          <div class="form-group">
            <label for="benefits">Benefits</label>
            <textarea class="form-control" name="benefits" placeholder="e.g., Health insurance, 401k, Remote work options, Gym membership..." rows="3" id="benefits"></textarea>
          </div>
        </div>

        <!-- Section D: Job Description -->
        <div class="job-form-card" id="description-card">
          <h2>D. Job Description</h2>
          <div class="form-group">
            <label for="responsibilities">Job Responsibilities *</label>
            <textarea class="form-control" name="responsibilities" placeholder="Describe the key responsibilities of this role..." rows="4" required id="responsibilities"></textarea>
            <span class="form-error">Responsibilities are required</span>
          </div>
          <div class="form-group">
            <label for="qualifications">Required Qualifications *</label>
            <textarea class="form-control" name="qualifications" placeholder="List the required qualifications..." rows="4" required id="qualifications"></textarea>
            <span class="form-error">Qualifications are required</span>
          </div>
          <div class="form-group">
            <label for="preferred-skills">Preferred Skills</label>
            <textarea class="form-control" name="preferred_skills" placeholder="List any preferred skills..." rows="3" id="preferred-skills"></textarea>
          </div>
          <div class="form-group">
            <label for="additional-notes">Additional Notes</label>
            <textarea class="form-control" name="additional_notes" placeholder="Any additional information..." rows="3" id="additional-notes"></textarea>
          </div>
        </div>

        <!-- Section E: Required Skills (max 5) -->
        <div class="job-form-card" id="skills-card">
          <h2>E. Required Skills (Up to 5)</h2>
          <p style="font-size:13px;color:var(--clr-text-gray);margin-bottom:var(--space-md);" id="skill-count">0/5 skills selected</p>

          <div class="add-skill-row">
            <div class="form-group" style="margin-bottom:0;">
              <label for="skill-select">Skill</label>
              <select class="form-control" id="skill-select">
                <option value="">Select a skill</option>
                <?php foreach($skills as $s): ?>
                  <option value="<?= $s['id'] ?>" <?= (isset($job) && $job['job_skill_id'] == $s['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group" style="margin-bottom:0;">
              <label for="proficiency-select">Minimum Proficiency</label>
              <select class="form-control" id="proficiency-select">
              <?php foreach($proficiency as $p): ?>
                  <option value="<?= $p['id'] ?>" <?= (isset($job) && $job['job_proficiency_id'] == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="button" class="btn btn-primary" id="add-skill-btn" style="height:44px;margin-top:auto;">Add Skill</button>
          </div>

          <div class="skills-list" id="skills-list">
            <!-- Skills will be added here dynamically -->
          </div>
        </div>

        <!-- Section F: Education & Experience -->
        <div class="job-form-card" id="education-card">
          <h2>F. Education & Experience Requirements</h2>
          <div class="form-row">
            <div class="form-group">
              <label for="min-degree">Minimum Degree Level *</label>
              <select class="form-control" name="min_degree" required id="min-degree">
                <option value="">Select degree</option>
                <?php foreach($degree as $d): ?>
                  <option value="<?= $d['id'] ?>" <?= (isset($job) && $job['job_degree_id'] == $d['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Minimum degree is required</span>
            </div>
            <div class="form-group">
              <label for="min-experience">Minimum Years of Experience *</label>
              <select class="form-control" name="min_experience" required id="min-experience">
                <option value="">Select experience</option>
                <?php foreach($experience as $e): ?>
                  <option value="<?= $e['id'] ?>" <?= (isset($job) && $job['job_experience_id'] == $e['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Minimum experience is required</span>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div style="display:flex;gap:var(--space-md);justify-content:flex-end;" id="form-actions">
          <a href="<?= $baseUrl ?>/employer/dashboard" class="btn btn-outline" id="cancel-btn">Cancel</a>
          <button type="submit" class="btn btn-primary btn-lg" id="publish-job-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Publish Job
          </button>
        </div>
      </form>
    </main>
  </div>

  <script src="<?= $baseUrl ?>/script.js"></script>
</body>
</html>

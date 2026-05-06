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
      <nav class="dashboard-sidebar-nav">
        <a href="<?= $baseUrl ?>/employer/dashboard">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Dashboard
        </a>
        <a href="<?= $baseUrl ?>/employer/job-form" class="active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
          Create Job
        </a>
        <a href="<?= $baseUrl ?>/logout" style="margin-top:var(--space-xl);color:rgba(255,255,255,0.4);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main" id="dashboard-main">
      <div class="dashboard-header">
      <h1><?= $job ? 'Edit Job Posting' : 'Create New Job' ?></h1>
        <a href="<?= $baseUrl ?>/employer/dashboard" class="btn btn-outline btn-sm" id="back-to-dashboard">← Back to Dashboard</a>
      </div>

      <form action="<?= $baseUrl ?>/employer/create" method="POST" data-validate id="job-create-form">
        <?php if ($job): ?>
            <input type="hidden" name="job_id" value="<?= $job['Vacancy_ID'] ?>">
        <?php endif; ?>

        <!-- Section A: Basic Job Information -->
        <div class="job-form-card" id="basic-info-card">
          <h2>A. Basic Job Information</h2>
          <div class="form-row">
            <div class="form-group">
              <label for="job-title">Job Title *</label>
              <select class="form-control" name="job_title" required id="job-title">
                <option value="">Select job title</option>
                <?php foreach($data['titles'] as $jt): ?>
                  <option value="<?= $jt['id'] ?>" <?= (isset($job) && $job['Title_ID'] == $jt['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['categories'] as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= (isset($job) && $job['Category_ID'] == $cat['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['employment'] as $emp): ?>
                  <option value="<?= $emp['id'] ?>" <?= (isset($job) && $job['Emp_Type_ID'] == $emp['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['industries'] as $i): ?>
                  <option value="<?= $i['id'] ?>" <?= (isset($job) && $job['Industry_ID'] == $i['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['levels'] as $l): ?>
                  <option value="<?= $l['id'] ?>" <?= (isset($job) && $job['Level_ID'] == $l['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($l['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Job level is required</span>
            </div>
            <div class="form-group">
              <label for="num-openings">Number of Openings *</label>
              <input type="number" class="form-control" name="num_openings" placeholder="e.g., 3" min="1" required id="num-openings" value="<?= isset($job) ? htmlspecialchars($job['Number_Of_Openings']) : '1' ?>">
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
                <?php foreach($data['countries'] as $c): ?>
                  <option value="<?= $c['id'] ?>" <?= (isset($job) && $job['Country_ID'] == $c['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['cities'] as $c): ?>
                  <option value="<?= $c['id'] ?>" <?= (isset($job) && $job['City_ID'] == $c['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['districts'] as $d): ?>
                  <option value="<?= $d['id'] ?>" <?= (isset($job) && $job['District_ID'] == $d['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="work-arrangement">Work Arrangement *</label>
              <select class="form-control" name="work_arrangement" required id="work-arrangement">
                <option value="">Select arrangement</option>
                <?php foreach($data['arrangement'] as $a): ?>
                  <option value="<?= $a['id'] ?>" <?= (isset($job) && $job['Arrangement_ID'] == $a['id']) ? 'selected' : '' ?>>
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
              <?php foreach($data['salary'] as $s): ?>
                  <option value="<?= $s['id'] ?>" <?= (isset($job) && $job['Salary_Range_ID'] == $s['id']) ? 'selected' : '' ?>>
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
                <?php foreach($data['salary_types'] as $st): ?>
                  <option value="<?= $st['id'] ?>" <?= (isset($job) && $job['Salary_Type_ID'] == $st['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($st['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Salary type is required</span>
            </div>
          </div>
          <div class="form-group">
            <label for="benefits">Benefits</label>
            <textarea class="form-control" name="benefits" placeholder="e.g., Health insurance, 401k, Remote work options, Gym membership..." rows="3" id="benefits"><?= isset($job) ? htmlspecialchars($job['Benefits']) : '' ?></textarea>
          </div>
        </div>

        <!-- Section D: Job Description -->
        <!-- BEFORE FIX:
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
        -->
        <div class="job-form-card" id="description-card">
          <h2>D. Job Description</h2>
          <div class="form-group">
            <label for="job-description">Job Description *</label>
            <p style="font-size: 13px; color: var(--clr-text-gray); margin-bottom: 8px;">Please provide a comprehensive description of the role, including responsibilities, qualifications, and any preferred skills or additional notes.</p>
            <!-- BACKEND: Consider integrating a Rich Text Editor like Quill, TinyMCE, or CKEditor here -->
            <textarea class="form-control" name="job_description" placeholder="Write a detailed job description..." rows="12" required id="job-description"><?= isset($job) ? htmlspecialchars($job['Job_Description']) : '' ?></textarea>
            <span class="form-error">Job description is required</span>
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
                <?php foreach($data['skills'] as $s): ?>
                  <option value="<?= $s['id'] ?>">
                    <?= htmlspecialchars($s['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group" style="margin-bottom:0;">
              <label for="proficiency-select">Minimum Proficiency</label>
              <select class="form-control" id="proficiency-select">
              <?php foreach($data['proficiency'] as $p): ?>
                  <option value="<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="button" class="btn btn-primary" id="add-skill-btn" style="height:44px;margin-top:auto;">Add Skill</button>
          </div>

          <div class="skills-list" id="skills-list">
            <!-- Skills will be added here dynamically (script.js) -->
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
                <?php foreach($data['degrees'] as $d): ?>
                  <option value="<?= $d['id'] ?>" <?= (isset($job) && $job['Min_Degree_ID'] == $d['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="form-error">Minimum degree is required</span>
            </div>
            <div class="form-group">
              <label for="min-experience">Minimum Years of Experience *</label>
              <input type="number" class="form-control" name="min_experience" placeholder="e.g., 2" min="0" required id="min-experience" value="<?= isset($job) ? htmlspecialchars($job['Min_Years_Experience']) : '' ?>">
              <span class="form-error">Minimum experience is required</span>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div style="display:flex;gap:var(--space-md);justify-content:flex-end;" id="form-actions">
          <a href="<?= $baseUrl ?>/employer/dashboard" class="btn btn-outline" id="cancel-btn">Cancel</a>
          <button type="submit" class="btn btn-primary btn-lg" id="publish-job-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <?= $job ? 'Save Changes' : 'Publish Job' ?>
          </button>
        </div>
      </form>
    </main>
  </div>

  <script src="<?= $baseUrl ?>/script.js"></script>
</body>
</html>

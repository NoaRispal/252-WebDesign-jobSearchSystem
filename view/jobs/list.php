<!-- ====== PAGE HERO ====== -->
<section class="page-hero" id="page-hero">
  <h1>Job Search</h1>
</section>

<!-- ====== JOBS LAYOUT ====== -->
<section class="section" id="jobs-listing-section">
  <div class="container">
    <!-- Mobile filter toggle -->
    <button class="sidebar-toggle" id="sidebar-toggle">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 4h18M3 12h18M3 20h18"/></svg>
      Filters
    </button>

    <div class="jobs-layout">
      <!-- ====== LEFT SIDEBAR ====== -->
      <aside class="jobs-sidebar" id="jobs-sidebar">
        <!-- Search by Keywords -->
        <div class="sidebar-section">
          <h3>Search by Keywords</h3>
          <div class="sidebar-search"><input type="text" placeholder="Job Title or Description" id="keyword-input"></div>
          <div id="keyword-tags" style="margin:10px 0;display:flex;flex-wrap:wrap;gap:8px;"></div>
          <p style="font-size:13px;color:var(--clr-text-gray);">(Press Enter to add new keywords)</p>
        </div>

        <!-- Location -->
        <div class="sidebar-section">
          <h3>Location</h3>
          <div style="display: flex; flex-direction: column; gap: 8px;">
            <select class="sidebar-select" name="country" id="sidebar-country">
              <option value="">Choose Country</option>
              <option value="usa">USA</option>
              <option value="canada">Canada</option>
              <option value="uk">UK</option>
            </select>
            <select class="sidebar-select" name="city" id="sidebar-city">
              <option value="">Choose City</option>
              <option value="new-york">New York</option>
              <option value="los-angeles">Los Angeles</option>
              <option value="boston">Boston</option>
            </select>
            <select class="sidebar-select" name="district" id="sidebar-district">
              <option value="">Choose District</option>
              <option value="manhattan">Manhattan</option>
              <option value="brooklyn">Brooklyn</option>
              <option value="queens">Queens</option>
            </select>
          </div>
        </div>

        <!-- Category -->
        <div class="sidebar-section">
          <h3>Category</h3>
          <div class="checkbox-group" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
            <div class="checkbox-item">
              <label><input type="checkbox" name="category" value="commerce"> Commerce</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="category" value="telecomunications"> Telecomunications</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="category" value="hotels-tourism"> Hotels & Tourism</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="category" value="education"> Education</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="category" value="financial-services"> Financial Services</label>
            </div>
            <div class="checkbox-item hidden-item" style="display:none;">
              <label><input type="checkbox" name="category" value="construction"> Construction</label>
            </div>
            <div class="checkbox-item hidden-item" style="display:none;">
              <label><input type="checkbox" name="category" value="media"> Media</label>
            </div>
            <div class="checkbox-item hidden-item" style="display:none;">
              <label><input type="checkbox" name="category" value="transport"> Transport</label>
            </div>
          </div>
        </div>

        <!-- Required Skills -->
        <div class="sidebar-section">
          <h3>Required Skills</h3>
          <div class="checkbox-group" id="skills-filter-list" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
            <div class="checkbox-item" data-skill="javascript">
              <label><input type="checkbox" name="skills[]" value="javascript"> JavaScript</label>
            </div>
            <div class="checkbox-item" data-skill="python">
              <label><input type="checkbox" name="skills[]" value="python"> Python</label>
            </div>
            <div class="checkbox-item" data-skill="react">
              <label><input type="checkbox" name="skills[]" value="react"> React</label>
            </div>
            <div class="checkbox-item" data-skill="project management">
              <label><input type="checkbox" name="skills[]" value="project-management"> Project Management</label>
            </div>
            <div class="checkbox-item" data-skill="communication">
              <label><input type="checkbox" name="skills[]" value="communication"> Communication</label>
            </div>
            <div class="checkbox-item" data-skill="html css">
              <label><input type="checkbox" name="skills[]" value="html-css"> HTML/CSS</label>
            </div>
            <div class="checkbox-item" data-skill="ui ux design">
              <label><input type="checkbox" name="skills[]" value="ui-ux"> UI/UX Design</label>
            </div>
          </div>
        </div>

        <!-- Job Type -->
        <div class="sidebar-section">
          <h3>Job Type</h3>
          <div class="checkbox-group" id="job-type-filters">
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_type" value="full-time"> Full Time</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_type" value="part-time"> Part Time</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_type" value="freelance"> Freelance</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_type" value="seasonal"> Seasonal</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_type" value="fixed-price"> Fixed-Price</label>
            </div>
          </div>
        </div>

        <!-- Job Level -->
        <div class="sidebar-section">
          <h3>Job Level</h3>
          <div class="checkbox-group" id="job-level-filters">
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_level" value="junior"> Junior</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_level" value="mid"> Mid</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="job_level" value="senior"> Senior</label>
            </div>
          </div>
        </div>

        <!-- Work Arrangement -->
        <div class="sidebar-section">
          <h3>Work Arrangement</h3>
          <div class="checkbox-group" id="work-arrangement-filters">
            <div class="checkbox-item">
              <label><input type="checkbox" name="work_arrangement" value="onsite"> Onsite</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="work_arrangement" value="remote"> Remote</label>
            </div>
            <div class="checkbox-item">
              <label><input type="checkbox" name="work_arrangement" value="hybrid"> Hybrid</label>
            </div>
          </div>
        </div>

        <!-- Salary -->
        <div class="sidebar-section">
          <h3>Salary Range</h3>
          <div class="salary-inputs" style="display: flex; gap: var(--space-sm); margin-bottom: var(--space-md); align-items: center;">
            <input type="number" name="salary_min" min="0" placeholder="Min $" class="form-control" style="width: 100%; padding: 8px;">
            <span style="color: var(--clr-text-gray);">-</span>
            <input type="number" name="salary_max" min="0" placeholder="Max $" class="form-control" style="width: 100%; padding: 8px;">
          </div>
        </div>

        <!-- Sort By -->
        <div class="sidebar-section">
          <h3>Sort By</h3>
          <div class="jobs-sort">
            <select id="sort-select">
              <option value="latest">Latest</option>
              <option value="salary-asc">Salary (Low to High)</option>
              <option value="salary-desc">Salary (High to Low)</option>
              <option value="title-asc">Job Title (A-Z)</option>
              <option value="title-desc">Job Title (Z-A)</option>
            </select>
          </div>
        </div>

        <button class="btn btn-primary btn-sm" id="salary-apply-btn" style="width: 100%;">Apply Filter</button>
      </aside>

      <!-- ====== RIGHT - JOB LISTINGS ====== -->
      <div class="jobs-content" id="jobs-content">
        <div class="jobs-results-header">
          <span class="jobs-results-count">Showing 6-6 of 10 results</span>
        </div>

        <!-- Job Card 1 -->
        <div class="job-card" id="jobs-card-1">
          <div class="job-card-header">
            <span class="job-card-time">10 min ago</span>
            <button class="job-card-bookmark" aria-label="Bookmark"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg></button>
          </div>
          <div class="job-card-info">
            <div class="job-card-icon" style="background:#E8F5E9;color:#4CAF50;">FS</div>
            <div>
              <h3 class="job-card-title">Forward Security Director</h3>
              <p class="job-card-company">Bauch, Schuppe and Schulist Co</p>
            </div>
          </div>
          <div class="job-card-footer">
            <div class="job-card-tags">
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> Hotels & Tourism</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Full time</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg> $40000-$42000</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> New-York, USA</span>
            </div>
            <a href="<?= $baseUrl ?>/jobs/detail" class="btn-job-details">Job Details</a>
          </div>
        </div>

        <!-- Job Card 2 -->
        <div class="job-card" id="jobs-card-2">
          <div class="job-card-header">
            <span class="job-card-time">12 min ago</span>
            <button class="job-card-bookmark" aria-label="Bookmark"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg></button>
          </div>
          <div class="job-card-info">
            <div class="job-card-icon" style="background:#FFF3E0;color:#FF9800;">RC</div>
            <div>
              <h3 class="job-card-title">Regional Creative Facilitator</h3>
              <p class="job-card-company">Wisozk - Becker Co</p>
            </div>
          </div>
          <div class="job-card-footer">
            <div class="job-card-tags">
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> Media</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Part time</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg> $28000-$32000</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Los-Angeles, USA</span>
            </div>
            <a href="<?= $baseUrl ?>/jobs/detail" class="btn-job-details">Job Details</a>
          </div>
        </div>

        <!-- Job Card 3 -->
        <div class="job-card" id="jobs-card-3">
          <div class="job-card-header">
            <span class="job-card-time">15 min ago</span>
            <button class="job-card-bookmark" aria-label="Bookmark"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg></button>
          </div>
          <div class="job-card-info">
            <div class="job-card-icon" style="background:#E3F2FD;color:#2196F3;">IP</div>
            <div>
              <h3 class="job-card-title">Internal Integration Planner</h3>
              <p class="job-card-company">Mraz, Quigley and Feest Inc.</p>
            </div>
          </div>
          <div class="job-card-footer">
            <div class="job-card-tags">
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> Construction</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Full time</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg> $48000-$50000</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Texas, USA</span>
            </div>
            <a href="<?= $baseUrl ?>/jobs/detail" class="btn-job-details">Job Details</a>
          </div>
        </div>

        <!-- Job Card 4 -->
        <div class="job-card" id="jobs-card-4">
          <div class="job-card-header">
            <span class="job-card-time">24 min ago</span>
            <button class="job-card-bookmark" aria-label="Bookmark"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg></button>
          </div>
          <div class="job-card-info">
            <div class="job-card-icon" style="background:#FCE4EC;color:#E91E63;">DD</div>
            <div>
              <h3 class="job-card-title">District Intranet Director</h3>
              <p class="job-card-company">VonRueden - Weber Co</p>
            </div>
          </div>
          <div class="job-card-footer">
            <div class="job-card-tags">
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> Commerce</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Full time</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg> $42000-$48000</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Florida, USA</span>
            </div>
            <a href="<?= $baseUrl ?>/jobs/detail" class="btn-job-details">Job Details</a>
          </div>
        </div>

        <!-- Job Card 5 -->
        <div class="job-card" id="jobs-card-5">
          <div class="job-card-header">
            <span class="job-card-time">26 min ago</span>
            <button class="job-card-bookmark" aria-label="Bookmark"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg></button>
          </div>
          <div class="job-card-info">
            <div class="job-card-icon" style="background:#F3E5F5;color:#9C27B0;">CT</div>
            <div>
              <h3 class="job-card-title">Corporate Tactics Facilitator</h3>
              <p class="job-card-company">Cormier, Turner and Flatley Inc</p>
            </div>
          </div>
          <div class="job-card-footer">
            <div class="job-card-tags">
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> Commerce</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Full time</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg> $38000-$40000</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Boston, USA</span>
            </div>
            <a href="<?= $baseUrl ?>/jobs/detail" class="btn-job-details">Job Details</a>
          </div>
        </div>

        <!-- Job Card 6 -->
        <div class="job-card" id="jobs-card-6">
          <div class="job-card-header">
            <span class="job-card-time">30 min ago</span>
            <button class="job-card-bookmark" aria-label="Bookmark"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg></button>
          </div>
          <div class="job-card-info">
            <div class="job-card-icon" style="background:#FFEBEE;color:#F44336;">FA</div>
            <div>
              <h3 class="job-card-title">Forward Accounts Consultant</h3>
              <p class="job-card-company">Miller Group</p>
            </div>
          </div>
          <div class="job-card-footer">
            <div class="job-card-tags">
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg> Financial services</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Full time</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg> $45000-$48000</span>
              <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Boston, USA</span>
            </div>
            <a href="<?= $baseUrl ?>/jobs/detail" class="btn-job-details">Job Details</a>
          </div>
        </div>

        <!-- Pagination -->
        <div class="pagination" id="pagination">
          <span class="active">1</span>
          <a href="#">2</a>
          <a href="#" class="next-btn">Next <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></a>
        </div>
      </div>
    </div>
  </div>
</section>
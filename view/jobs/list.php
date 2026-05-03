<!-- BACKEND: Rename to jobs.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->
<!-- BACKEND: Controller passes these variables to this view:
     - $jobs          (array)  — paginated job listings (filtered + sorted)
     - $totalResults  (int)    — total matching jobs (for "Showing X of Y")
     - $currentPage   (int)    — current page number
     - $totalPages    (int)    — total pages for pagination
     - $categories    (array)  — all active categories (for sidebar checkboxes)
     - $locations     (array)  — all active locations (for sidebar select)
     - $filters       (array)  — currently applied filter values (to keep checkboxes checked)
     
     JobController::index() handles GET params:
     - $_GET['q']                → keyword search (LIKE %q%)
     - $_GET['category'][]       → category filter (IN)
     - $_GET['job_type'][]       → employment type filter (IN)
     - $_GET['job_level'][]      → job level filter (IN)
     - $_GET['work_arrangement'][]→ work arrangement filter (IN)
     - $_GET['location']         → location filter (=)
     - $_GET['salary_max']       → salary range filter (<=)
     - $_GET['sort']             → sort order (latest, salary-asc, etc.)
     - $_GET['page']             → pagination offset (LIMIT 6 OFFSET (page-1)*6)
-->
<!-- ====== PAGE HERO ====== -->
  <section class="page-hero" id="page-hero">
    <h1>Jobs</h1>
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
          <!-- Search by Job Title -->
          <div class="sidebar-section">
            <h3>Search by Job Title</h3>
            <div class="sidebar-search">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
              <input type="text" placeholder="Job title or company" id="sidebar-search-input">
            </div>
          </div>

          <!-- Location -->
          <!-- BACKEND: Populate <option>s from DB:
               &lt;?php foreach($locations as $loc): ?&gt;
                 <option value="&lt;?= $loc['id'] ?&gt;" &lt;?= ($filters['location'] == $loc['id']) ? 'selected' : '' ?&gt;>
                   &lt;?= htmlspecialchars($loc['city'] . ', ' . $loc['country']) ?&gt;
                 </option>
               &lt;?php endforeach; ?&gt;
          -->
          <!-- BEFORE FIX:
          <div class="sidebar-section">
            <h3>Location</h3>
            <select class="sidebar-select" id="sidebar-location">
              <option value="">Choose city</option>
              <option value="new-york">New York, USA</option>
              <option value="los-angeles">Los Angeles, USA</option>
              <option value="boston">Boston, USA</option>
              <option value="texas">Texas, USA</option>
              <option value="florida">Florida, USA</option>
            </select>
          </div>
          -->
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
          <!-- BACKEND: Populate checkboxes from DB:
               &lt;?php foreach($categories as $cat): ?&gt;
                 <div class="checkbox-item">
                   <label><input type="checkbox" name="category[]" value="&lt;?= $cat['id'] ?&gt;"
                     &lt;?= in_array($cat['id'], $filters['category'] ?? []) ? 'checked' : '' ?&gt;>
                     &lt;?= htmlspecialchars($cat['name']) ?&gt;</label>
                   <span class="checkbox-count">&lt;?= $cat['job_count'] ?&gt;</span>
                 </div>
               &lt;?php endforeach; ?&gt;
               Job count SQL: SELECT c.id, c.name, COUNT(jv.id) as job_count
                              FROM categories c LEFT JOIN job_vacancies jv ON c.id = jv.category_id AND jv.is_active=1
                              GROUP BY c.id
          -->
          <div class="sidebar-section">
            <h3>Category</h3>
            <div class="checkbox-group" id="category-filters">
              <div class="checkbox-item">
                <label><input type="checkbox" name="category" value="commerce"> Commerce</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="category" value="telecomunications"> Telecomunications</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="category" value="hotels-tourism"> Hotels & Tourism</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="category" value="education"> Education</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="category" value="financial-services"> Financial Services</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item hidden-item" style="display:none;">
                <label><input type="checkbox" name="category" value="construction"> Construction</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item hidden-item" style="display:none;">
                <label><input type="checkbox" name="category" value="media"> Media</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item hidden-item" style="display:none;">
                <label><input type="checkbox" name="category" value="transport"> Transport</label>
                <span class="checkbox-count">10</span>
              </div>
            </div>
            <button class="btn-show-more" onclick="toggleShowMore(this)" id="category-show-more">Show More</button>
          </div>

          <!-- Required Skills -->
          <!-- BACKEND: Populate from DB 'skills' table. Search functionality is handled via JS matching 'data-skill' attribute -->
          <div class="sidebar-section">
            <h3>Required Skills</h3>
            <div class="sidebar-search" style="margin-bottom: var(--space-sm);">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
              <input type="text" placeholder="Search skills..." id="skills-search-input">
            </div>
            <div class="checkbox-group" id="skills-filter-list" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
              <div class="checkbox-item" data-skill="javascript">
                <label><input type="checkbox" name="skills[]" value="javascript"> JavaScript</label>
                <span class="checkbox-count">42</span>
              </div>
              <div class="checkbox-item" data-skill="python">
                <label><input type="checkbox" name="skills[]" value="python"> Python</label>
                <span class="checkbox-count">38</span>
              </div>
              <div class="checkbox-item" data-skill="react">
                <label><input type="checkbox" name="skills[]" value="react"> React</label>
                <span class="checkbox-count">35</span>
              </div>
              <div class="checkbox-item" data-skill="project management">
                <label><input type="checkbox" name="skills[]" value="project-management"> Project Management</label>
                <span class="checkbox-count">28</span>
              </div>
              <div class="checkbox-item" data-skill="communication">
                <label><input type="checkbox" name="skills[]" value="communication"> Communication</label>
                <span class="checkbox-count">25</span>
              </div>
              <div class="checkbox-item" data-skill="html css">
                <label><input type="checkbox" name="skills[]" value="html-css"> HTML/CSS</label>
                <span class="checkbox-count">20</span>
              </div>
              <div class="checkbox-item" data-skill="ui ux design">
                <label><input type="checkbox" name="skills[]" value="ui-ux"> UI/UX Design</label>
                <span class="checkbox-count">18</span>
              </div>
            </div>
            <p id="skills-no-results" style="display: none; font-size: 13px; color: var(--clr-text-gray); text-align: center; margin-top: 10px;">No skills found.</p>
          </div>

          <!-- Job Type -->
          <div class="sidebar-section">
            <h3>Job Type</h3>
            <div class="checkbox-group" id="job-type-filters">
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_type" value="full-time"> Full Time</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_type" value="part-time"> Part Time</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_type" value="freelance"> Freelance</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_type" value="seasonal"> Seasonal</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_type" value="fixed-price"> Fixed-Price</label>
                <span class="checkbox-count">10</span>
              </div>
            </div>
          </div>

          <!-- Job Level -->
          <div class="sidebar-section">
            <h3>Job Level</h3>
            <div class="checkbox-group" id="job-level-filters">
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_level" value="junior"> Junior</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_level" value="mid"> Mid</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="job_level" value="senior"> Senior</label>
                <span class="checkbox-count">10</span>
              </div>
            </div>
          </div>

          <!-- Work Arrangement -->
          <div class="sidebar-section">
            <h3>Work Arrangement</h3>
            <div class="checkbox-group" id="work-arrangement-filters">
              <div class="checkbox-item">
                <label><input type="checkbox" name="work_arrangement" value="onsite"> Onsite</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="work_arrangement" value="remote"> Remote</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="checkbox" name="work_arrangement" value="hybrid"> Hybrid</label>
                <span class="checkbox-count">10</span>
              </div>
            </div>
          </div>

          <!-- Date Posted -->
          <div class="sidebar-section">
            <h3>Date Posted</h3>
            <div class="checkbox-group" id="date-filters">
              <div class="checkbox-item">
                <label><input type="radio" name="date_posted" value="all" checked> All</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="radio" name="date_posted" value="last-hour"> Last Hour</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="radio" name="date_posted" value="last-24h"> Last 24 Hours</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="radio" name="date_posted" value="last-7d"> Last 7 Days</label>
                <span class="checkbox-count">10</span>
              </div>
              <div class="checkbox-item">
                <label><input type="radio" name="date_posted" value="last-30d"> Last 30 Days</label>
                <span class="checkbox-count">10</span>
              </div>
            </div>
          </div>

          <!-- Salary -->
          <!-- BEFORE FIX:
          <div class="sidebar-section">
            <h3>Salary</h3>
            <div class="salary-range">
              <input type="range" min="0" max="9999" value="9999" id="salary-range">
              <div class="salary-range-info">
                <span id="salary-display">Salary: $0 - $9,999</span>
                <button class="btn btn-primary btn-sm" id="salary-apply-btn">Apply</button>
              </div>
            </div>
          </div>
          -->
          <div class="sidebar-section">
            <h3>Salary Range</h3>
            <div class="salary-inputs" style="display: flex; gap: var(--space-sm); margin-bottom: var(--space-md); align-items: center;">
              <input type="number" name="salary_min" min="0" placeholder="Min $" class="form-control" style="width: 100%; padding: 8px;">
              <span style="color: var(--clr-text-gray);">-</span>
              <input type="number" name="salary_max" min="0" placeholder="Max $" class="form-control" style="width: 100%; padding: 8px;">
            </div>
            <button class="btn btn-primary btn-sm" id="salary-apply-btn" style="width: 100%;">Apply Filter</button>
          </div>

          <!-- Tags -->
          <div class="sidebar-section">
            <h3>Tags</h3>
            <div class="tags-cloud" id="tags-cloud">
              <span class="tag-item">engineering</span>
              <span class="tag-item">design</span>
              <span class="tag-item">ui/ux</span>
              <span class="tag-item">marketing</span>
              <span class="tag-item">management</span>
              <span class="tag-item">soft</span>
              <span class="tag-item">construction</span>
            </div>
          </div>

          <!-- Hiring Banner -->
          <div class="hiring-banner" id="hiring-banner">
            <h3>WE ARE HIRING</h3>
            <p>Apply Today!</p>
          </div>
        </aside>

        <!-- ====== RIGHT - JOB LISTINGS ====== -->
        <div class="jobs-content" id="jobs-content">
          <div class="jobs-results-header">
            <span class="jobs-results-count">Showing 6-6 of 10 results</span>
            <div class="jobs-sort">
              <select id="sort-select">
                <option value="latest">Sort by latest</option>
                <option value="salary-asc">Salary (Low to High)</option>
                <option value="salary-desc">Salary (High to Low)</option>
                <option value="title-asc">Title (A-Z)</option>
                <option value="title-desc">Title (Z-A)</option>
              </select>
            </div>
          </div>

          <!-- BACKEND: Replace static job cards with PHP loop:
               &lt;?php foreach($jobs as $job): ?&gt;
                 <div class="job-card">
                   ... same structure as below, with:
                   &lt;?= htmlspecialchars($job['title']) ?&gt;
                   &lt;?= htmlspecialchars($job['company_name']) ?&gt;
                   <a href="&lt;?= $baseUrl ?&gt;/jobs/detail?id=&lt;?= $job['id'] ?&gt;">
                 </div>
               &lt;?php endforeach; ?&gt;
               
               If no results: &lt;?php if(empty($jobs)): ?&gt;
                 <p style="text-align:center;padding:40px;">No jobs found matching your criteria.</p>
               &lt;?php endif; ?&gt;
          -->

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
          <!-- BACKEND: Generate dynamic pagination:
               &lt;?php if($totalPages > 1): ?&gt;
                 <div class="pagination">
                   &lt;?php for($i = 1; $i <= $totalPages; $i++): ?&gt;
                     &lt;?php if($i == $currentPage): ?&gt;
                       <span class="active">&lt;?= $i ?&gt;</span>
                     &lt;?php else: ?&gt;
                       <a href="?page=&lt;?= $i ?&gt;&&lt;?= http_build_query($filters) ?&gt;">&lt;?= $i ?&gt;</a>
                     &lt;?php endif; ?&gt;
                   &lt;?php endfor; ?&gt;
                   &lt;?php if($currentPage < $totalPages): ?&gt;
                     <a href="?page=&lt;?= $currentPage+1 ?&gt;&&lt;?= http_build_query($filters) ?&gt;" class="next-btn">Next ></a>
                   &lt;?php endif; ?&gt;
                 </div>
               &lt;?php endif; ?&gt;
               
               SQL: SELECT ... LIMIT 6 OFFSET &lt;?= ($currentPage - 1) * 6 ?&gt;
               COUNT: SELECT COUNT(*) FROM job_vacancies WHERE ... (same filters)
          -->
          <div class="pagination" id="pagination">
            <span class="active">1</span>
            <a href="#">2</a>
            <a href="#" class="next-btn">Next <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== TOP COMPANY ====== -->
  <section class="section" id="top-company" style="background:var(--clr-bg-light);">
    <div class="container">
      <h2 class="section-title">Top Company</h2>
      <p class="section-subtitle">Browse opportunities across a wide range of industries and find the perfect fit for your career</p>

      <div class="top-companies-grid">
        <div class="company-card">
          <div class="company-card-logo">📸</div>
          <h3>Instagram</h3>
          <p>Discover exciting roles in the fast-growing commerce industry, from retail management to supply chain operations</p>
          <a href="#" class="open-jobs">8 open jobs</a>
        </div>
        <div class="company-card">
          <div class="company-card-logo">🚗</div>
          <h3>Tesla</h3>
          <p>Connect with leading telco companies offering competitive packages and cutting-edge technology projects</p>
          <a href="#" class="open-jobs">18 open jobs</a>
        </div>
        <div class="company-card">
          <div class="company-card-logo">🍔</div>
          <h3>McDonald's</h3>
          <p>Find rewarding positions in the hospitality sector, from luxury hotels to adventure tourism operators</p>
          <a href="#" class="open-jobs">12 open jobs</a>
        </div>
        <div class="company-card">
          <div class="company-card-logo">🍎</div>
          <h3>Apple</h3>
          <p>Shape the future of learning with teaching, research, and administrative roles at top institutions</p>
          <a href="#" class="open-jobs">9 open jobs</a>
        </div>
      </div>
    </div>
  </section>

  
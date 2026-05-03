<!-- BACKEND: Rename this file to index.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->
<!-- BACKEND: &lt;?php require_once '../Config/database.php'; ?&gt; -->
<!-- BACKEND: &lt;?php require_once '../Helpers/session.php'; ?&gt; -->
<!-- BACKEND: Controller passes these variables to this view:
     - $recentJobs     (array)  — latest 6 job postings for homepage cards
     - $jobCount       (int)    — total active job vacancies
     - $companyCount   (int)    — total unique employers
     - $categories     (array)  — all active categories from DB
     - $locations       (array)  — all active locations from DB
-->
<!-- ====== HERO SECTION ====== -->
  <section class="hero" id="hero">
    <div class="container">
      <h1 class="hero-title">Find Your Dream Job Today!</h1>
      <p class="hero-subtitle">Connecting talented professionals with leading companies worldwide</p>

      <form class="hero-search" action="<?= $baseUrl ?>/jobs" method="GET" id="hero-search-form">
        <div class="hero-search-field">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          <input type="text" name="q" placeholder="Job title or company" id="hero-search-input">
        </div>
        <div class="hero-search-field">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <!-- BACKEND: Populate from DB locations table:
               <select name="location" id="hero-location-select">
                 <option value="">Choose city</option>
                 &lt;?php foreach($locations as $loc): ?&gt;
                   <option value="&lt;?= $loc['id'] ?&gt;">&lt;?= htmlspecialchars($loc['city'] . ', ' . $loc['country']) ?&gt;</option>
                 &lt;?php endforeach; ?&gt;
               </select>
          -->
          <select name="location" id="hero-location-select">
            <option value="">Choose city</option>
            <option value="new-york">New York, USA</option>
            <option value="los-angeles">Los Angeles, USA</option>
            <option value="boston">Boston, USA</option>
            <option value="texas">Texas, USA</option>
            <option value="florida">Florida, USA</option>
          </select>
        </div>
        <div class="hero-search-field">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
          <!-- BACKEND: Populate from DB categories table:
               &lt;?php foreach($categories as $cat): ?&gt;
                 <option value="&lt;?= $cat['id'] ?&gt;">&lt;?= htmlspecialchars($cat['name']) ?&gt;</option>
               &lt;?php endforeach; ?&gt;
          -->
          <select name="category" id="hero-category-select">
            <option value="">Choose category</option>
            <option value="commerce">Commerce</option>
            <option value="telecomunications">Telecomunications</option>
            <option value="hotels-tourism">Hotels & Tourism</option>
            <option value="education">Education</option>
            <option value="financial-services">Financial Services</option>
            <option value="construction">Construction</option>
            <option value="media">Media</option>
            <option value="transport">Transport</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" id="hero-search-btn">Search</button>
      </form>

      <!-- BACKEND: Replace hardcoded stats with DB counts:
           $jobCount    = SELECT COUNT(*) FROM job_vacancies WHERE is_active = 1;
           $companyCount = SELECT COUNT(DISTINCT employer_id) FROM job_vacancies;
           Then output: &lt;?= number_format($jobCount) ?&gt; and &lt;?= number_format($companyCount) ?&gt;
      -->
      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-number">
            <svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            25,850
          </div>
          <div class="hero-stat-label">Jobs</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-number">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            10,250
          </div>
          <div class="hero-stat-label">Startups</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-number">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
            18,400
          </div>
          <div class="hero-stat-label">Companies</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== COMPANY LOGOS ====== -->
  <section class="logos-bar" id="logos-bar">
    <div class="container">
      <div class="logo-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="4"/><circle cx="6" cy="6" r="2"/><circle cx="18" cy="6" r="2"/><circle cx="6" cy="18" r="2"/></svg>
        Spotify
      </div>
      <div class="logo-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="2" width="8" height="8" rx="1"/><rect x="14" y="2" width="8" height="8" rx="1"/><rect x="2" y="14" width="8" height="8" rx="1"/><circle cx="18" cy="18" r="4"/></svg>
        Slack
      </div>
      <div class="logo-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 22,22 2,22"/></svg>
        Adobe
      </div>
      <div class="logo-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="3"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
        Asana
      </div>
      <div class="logo-item">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16M4 12h16M4 18h10"/></svg>
        Linear
      </div>
    </div>
  </section>

  <!-- ====== RECENT JOBS AVAILABLE ====== -->
  <section class="section jobs-section" id="recent-jobs">
    <div class="container">
      <div class="section-header">
        <div>
          <h2 class="section-title">Recent Jobs Available</h2>
          <p class="section-subtitle" style="text-align:left;margin:0;">Explore the latest opportunities from top companies hiring right now</p>
        </div>
        <a href="<?= $baseUrl ?>/jobs" class="view-all-link">View all →</a>
      </div>

      <!-- BACKEND: Replace static cards below with a PHP loop:
           &lt;?php foreach($recentJobs as $job): ?&gt;
             <div class="job-card reveal">
               <div class="job-card-header">
                 <span class="job-card-time">&lt;?= time_ago($job['created_at']) ?&gt;</span>
                 <button class="job-card-bookmark">...</button>
               </div>
               <div class="job-card-info">
                 <div class="job-card-icon">...</div>
                 <div>
                   <h3 class="job-card-title">&lt;?= htmlspecialchars($job['title']) ?&gt;</h3>
                   <p class="job-card-company">&lt;?= htmlspecialchars($job['company_name']) ?&gt;</p>
                 </div>
               </div>
               <div class="job-card-footer">
                 <div class="job-card-tags">
                   <span class="job-tag">&lt;?= htmlspecialchars($job['category_name']) ?&gt;</span>
                   <span class="job-tag">&lt;?= htmlspecialchars($job['employment_type_name']) ?&gt;</span>
                   <span class="job-tag">&lt;?= htmlspecialchars($job['salary_label']) ?&gt;</span>
                   <span class="job-tag">&lt;?= htmlspecialchars($job['city'] . ', ' . $job['country']) ?&gt;</span>
                 </div>
                 <a href="&lt;?= $baseUrl ?&gt;/jobs/detail?id=&lt;?= $job['id'] ?&gt;" class="btn-job-details">Job Details</a>
               </div>
             </div>
           &lt;?php endforeach; ?&gt;

           SQL Query: SELECT jv.*, jt.name AS title, c.name AS category_name,
                      et.name AS employment_type_name, sr.label AS salary_label,
                      l.city, l.country
                      FROM job_vacancies jv
                      JOIN job_titles jt ON jv.job_title_id = jt.id
                      JOIN categories c ON jv.category_id = c.id
                      JOIN employment_types et ON jv.employment_type_id = et.id
                      JOIN salary_ranges sr ON jv.salary_range_id = sr.id
                      JOIN locations l ON jv.location_id = l.id
                      WHERE jv.is_active = 1
                      ORDER BY jv.created_at DESC LIMIT 6;
      -->

      <!-- Job Card 1 -->
      <div class="job-card reveal" id="job-card-1">
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
      <div class="job-card reveal" id="job-card-2">
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
      <div class="job-card reveal" id="job-card-3">
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
      <div class="job-card reveal" id="job-card-4">
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
      <div class="job-card reveal" id="job-card-5">
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
    </div>
  </section>

  <!-- ====== BROWSE BY CATEGORY ====== -->
  <section class="section category-section" id="browse-category">
    <div class="container">
      <h2 class="section-title">Browse by Category</h2>
      <p class="section-subtitle">Browse opportunities across a wide range of industries and find the perfect fit for your career</p>

      <div class="category-grid">
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg></div>
          <h3>Agriculture</h3>
          <span class="job-count">120 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
          <h3>Metal Production</h3>
          <span class="job-count">78 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg></div>
          <h3>Commerce</h3>
          <span class="job-count">150 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 20h20M4 20V8l8-6 8 6v12"/><path d="M9 20v-5h6v5"/></svg></div>
          <h3>Construction</h3>
          <span class="job-count">95 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
          <h3>Hotels & Tourism</h3>
          <span class="job-count">112 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg></div>
          <h3>Education</h3>
          <span class="job-count">200 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
          <h3>Financial Services</h3>
          <span class="job-count">85 open positions</span>
        </div>
        <div class="category-card reveal">
          <div class="category-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
          <h3>Transport</h3>
          <span class="job-count">67 open positions</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== GOOD LIFE SECTION ====== -->
  <section class="section good-life-section" id="good-life">
    <div class="container">
      <div class="good-life-grid">
        <div class="good-life-image reveal">
          <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&q=80" alt="Team working together" loading="lazy">
        </div>
        <div class="good-life-content reveal">
          <h2>Good Life Begins With A Good Company</h2>
          <p>We believe that the right job can transform your life. Our platform connects talented professionals with companies that value their skills and ambitions.</p>
          <div class="good-life-buttons">
            <a href="<?= $baseUrl ?>/jobs" class="btn btn-primary">Search Job</a>
            <a href="<?= $baseUrl ?>/about" class="btn btn-outline">Learn More</a>
          </div>
        </div>
      </div>

      <div class="stats-row reveal">
        <div class="stat-item">
          <h3>12k+</h3>
          <p>Clients worldwide</p>
        </div>
        <div class="stat-item">
          <h3>20k+</h3>
          <p>Active resume</p>
        </div>
        <div class="stat-item">
          <h3>18k+</h3>
          <p>Companies</p>
        </div>
        <div class="stat-item">
          <h3>14k+</h3>
          <p>Open Jobs</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== CTA BANNER ====== -->
  <section class="cta-banner" id="cta-banner">
    <div class="container">
      <h2>Create A Better Future<br>For Yourself</h2>
      <p>Simple steps to land your next great opportunity</p>
      <a href="<?= $baseUrl ?>/jobs" class="btn btn-primary btn-lg">Search Job</a>
    </div>
  </section>

  <!-- ====== TESTIMONIALS ====== -->
  <section class="section" id="testimonials">
    <div class="container">
      <h2 class="section-title">Testimonials</h2>
      <p class="section-subtitle">Follow these easy steps to find and apply for your dream job in minutes</p>

      <div class="testimonials-grid">
        <div class="testimonial-card reveal">
          <div class="testimonial-stars">
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <h4>"Great platform for job seekers"</h4>
          <p>Create a free account in minutes. Choose whether you're a job seeker looking for opportunities or an employer ready to hire top talent.</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar">JD</div>
            <div class="testimonial-author-info">
              <h5>John Doe</h5>
              <span>Software Developer</span>
            </div>
          </div>
        </div>

        <div class="testimonial-card reveal">
          <div class="testimonial-stars">
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <h4>"Easy to find the right talent"</h4>
          <p>Use our powerful search filters to find jobs that match your skills, location, salary expectations, and career goals.</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar">SA</div>
            <div class="testimonial-author-info">
              <h5>Sarah Anderson</h5>
              <span>HR Manager</span>
            </div>
          </div>
        </div>

        <div class="testimonial-card reveal">
          <div class="testimonial-stars">
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <h4>"Streamlined our hiring process"</h4>
          <p>Submit your application directly through our platform. Track your progress and get notified when employers respond.</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar">MK</div>
            <div class="testimonial-author-info">
              <h5>Mike Karlsson</h5>
              <span>CEO, TechStart</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ====== NEWS AND BLOG ====== -->
  <section class="section" id="news-blog">
    <div class="container">
      <h2 class="section-title">News and Blog</h2>
      <p class="section-subtitle">Hear from professionals who found their dream jobs through Job Portal</p>

      <div class="blog-grid">
        <div class="blog-card reveal">
          <div class="blog-card-image">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&q=80" alt="Team Meeting" loading="lazy">
            <span class="blog-card-badge">Tips</span>
          </div>
          <div class="blog-card-content">
            <span class="blog-card-date">Nov 17, 2024</span>
            <h3>The best ways to land your dream job in 2024</h3>
            <a href="#" class="blog-read-more">Read more →</a>
          </div>
        </div>
        <div class="blog-card reveal">
          <div class="blog-card-image">
            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=600&q=80" alt="Professional Interview" loading="lazy">
            <span class="blog-card-badge">Career</span>
          </div>
          <div class="blog-card-content">
            <span class="blog-card-date">Nov 12, 2024</span>
            <h3>How to prepare for a technical interview: A complete guide</h3>
            <a href="#" class="blog-read-more">Read more →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  
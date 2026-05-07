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
          <select name="location" id="hero-location-select">
            <option value="">Choose category</option>
            <?php foreach($locations as $city): ?>
                <option value="<?= $city['id'] ?>"><?= htmlspecialchars($city['name']) ?></option>
            <?php endforeach; ?>
        </select>
        </div>
        <div class="hero-search-field">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
          <select name="category" id="hero-category-select">
              <option value="">Choose category</option>
              <?php foreach($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" id="hero-search-btn">Search</button>
      </form>

      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-number">
            <svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <?= number_format($jobCount) ?>
          </div>
          <div class="hero-stat-label">Jobs</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-number">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
            <?= number_format($companyCount) ?>
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
      <!-- Job Card  -->
      <?php foreach($recentJobs as $job): ?>
        <div class="job-card reveal">
            <div class="job-card-info">
                <div class="job-card-icon"><?= substr($job['title_name'], 0, 2) ?></div>
                <div>
                    <h3 class="job-card-title"><?= htmlspecialchars($job['title_name']) ?></h3>
                    <p class="job-card-company"><?= htmlspecialchars($job['company_name']) ?></p>
                </div>
            </div>
            <div class="job-card-footer">
                <div class="job-card-tags">
                    <span class="job-tag"><?= htmlspecialchars($job['category_name']) ?></span>
                    <span class="job-tag"><?= htmlspecialchars($job['type_name']) ?></span>
                    <span class="job-tag"><?= htmlspecialchars($job['range_description']) ?></span>
                    <span class="job-tag"><?= htmlspecialchars($job['city_name'] . ', ' . $job['country_name']) ?></span>
                </div>
                <a href="<?= $baseUrl ?>/jobs/detail?id=<?= $job['vacancy_id'] ?>" class="btn-job-details">Job Details</a>
            </div>
        </div>
        <?php endforeach; ?>
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
    </div>
  </section>

  
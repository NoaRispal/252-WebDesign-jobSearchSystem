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
        <form id="job-filter-form">
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
                <?php foreach(JobseekerController::get_countries($db) as [$id, $value]) { ?>
                  <option value='<?=$id?>'><?=htmlspecialchars($value)?></option>
                <?php } ?>
              </select>
              <select class="sidebar-select" name="city" id="sidebar-city">
                <option value="">Choose City</option>
              </select>
              <select class="sidebar-select" name="district" id="sidebar-district">
                <option value="">Choose District</option>
              </select>
            </div>
          </div>

          <!-- Category -->
          <div class="sidebar-section">
            <h3>Category</h3>
            <div class="checkbox-group" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
              <?php foreach(JobseekerController::get_categories($db) as [$id, $value]) { ?>
                <div class="checkbox-item" data-category="<?=$id?>">
                  <label><input type="checkbox" name="category[]" value="<?=$id?>"> <?=htmlspecialchars($value)?></label>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Required Skills -->
          <div class="sidebar-section">
            <h3>Required Skills</h3>
            <div class="checkbox-group" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
              <?php foreach(JobseekerController::get_required_skills($db) as [$id, $value]) { ?>
                <div class="checkbox-item" data-skill="<?=$id?>">
                  <label><input type="checkbox" name="skills[]" value="<?=$id?>"> <?=htmlspecialchars($value)?></label>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Job Type -->
          <div class="sidebar-section">
            <h3>Job Type</h3>
            <div class="checkbox-group">
              <?php foreach(JobseekerController::get_job_types($db) as [$id, $value]) { ?>
                <div class="checkbox-item" data-jobtype="<?=$id?>">
                  <label><input type="checkbox" name="job_type[]" value="<?=$id?>"> <?=htmlspecialchars($value)?></label>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Job Level -->
          <div class="sidebar-section">
            <h3>Job Level</h3>
            <div class="checkbox-group">
              <?php foreach(JobseekerController::get_job_levels($db) as [$id, $value]) { ?>
                <div class="checkbox-item" data-joblevel="<?=$id?>">
                  <label><input type="checkbox" name="job_level[]" value="<?=$id?>"> <?=htmlspecialchars($value)?></label>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Work Arrangement -->
          <div class="sidebar-section">
            <h3>Work Arrangement</h3>
            <div class="checkbox-group">
              <?php foreach(JobseekerController::get_work_arrangements($db) as [$id, $value]) { ?>
                <div class="checkbox-item" data-arrangement="<?=$id?>">
                  <label><input type="checkbox" name="work_arrangement[]" value="<?=$id?>"> <?=htmlspecialchars($value)?></label>
                </div>
              <?php } ?>
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
              <select id="sort-select" name="sort-select">
                <option value="latest">Latest</option>
                <option value="salary-asc">Salary (Low to High)</option>
                <option value="salary-desc">Salary (High to Low)</option>
                <option value="title-asc">Job Title (A-Z)</option>
                <option value="title-desc">Job Title (Z-A)</option>
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-sm" id="salary-apply-btn" style="width: 100%;">Apply Filter</button>
        </form>
      </aside>

      <!-- ====== RIGHT - JOB LISTINGS ====== -->
      <div class="jobs-content">
        <div class="jobs-results-header"><span class="jobs-results-count" id="jobs-results-count"></span></div>
        <div id="job-result-content"></div>
        <div class="pagination" id="pagination"></div>
      </div>
    </div>
  </div>
</section>
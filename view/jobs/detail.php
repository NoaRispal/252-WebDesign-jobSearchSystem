<!-- ====== PAGE HERO ====== -->
  <section class="page-hero" id="page-hero">
    <h1>Job Details</h1>
  </section>

  <!-- ====== JOB DETAILS CONTENT ====== -->
  <section class="section">
    <div class="container">
      <?php if (!$response) { ?>
        <p style='color:var(--clr-text-gray);font-size:16px;text-align:center;margin:var(--space-3xl) 0;'>Job not found.</p>
      <?php } else { ?>
      <div class="job-details-layout">
        <!-- ====== LEFT MAIN ====== -->
        <div class="job-details-main">
          <!-- Job Header -->
          <div class="job-card" style="border:none;padding:0;">
            <div class="job-card-header">
              <span class="job-card-time" id="job-card-time"></span>
            </div>
            <script>
              const postTime = new Date('<?=date('c', strtotime($response['posting_date']))?>');
              document.getElementById('job-card-time').textContent = `Posted on ${postTime.toLocaleDateString()}`;
            </script>

            <div class="job-card-info" style="margin-bottom:var(--space-lg);">
              <script>document.write(generateJobListIcon("<?=htmlspecialchars($response['title_name'])?>", "<?=$response['vacancy_id']?>"));</script>
              <div>
                <h2 class="job-card-title" style="font-size:24px;"><?=htmlspecialchars($response['title_name'])?></h2>
                <p class="job-card-company"><?=htmlspecialchars($response['company_name'])?></p>
              </div>
            </div>

            <?php
            $location = implode(', ', array_filter([$response['city_name'], $response['district_name'], $response['country_name']]));
            $salary = "$".number_format($response['min_salary'])." - $".number_format($response['max_salary']);
            ?>

            <div class="job-card-footer">
              <div class="job-card-tags">
                <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg><?=htmlspecialchars($response['category_name'])?></span>
                <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg><?=htmlspecialchars($response['type_name'])?></span>
                <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/></svg><?=htmlspecialchars($salary)?></span>
                <span class="job-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><?=htmlspecialchars($location)?></span>
              </div>
            </div>
          </div>

          <!-- Job Description -->
          <div class="job-description" id="job-description">
            <h3>Job Description</h3>
            <?=nl2br(htmlspecialchars($response['job_description']))?>

            <h3>Professional Skills</h3>
            <ul class="checklist">
              <?php foreach ($response['skills'] as $skill) { ?>
                <li>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <?=htmlspecialchars($skill['skill_name'])?> (<?=htmlspecialchars($skill['proficiency_name'])?>)
                </li>
              <?php } ?>
            </ul>

            <h3>Benefits</h3>
            <?=nl2br(htmlspecialchars($response['benefits']))?>
          </div>
        </div>

        <!-- ====== RIGHT SIDEBAR ====== -->
        <aside id="job-detail-sidebar">
          <!-- Apply Button (mobile) -->
          <a href="#" class="btn btn-primary btn-lg" style="width:100%;margin-bottom:var(--space-lg);display:none;" id="apply-job-mobile">Apply Job</a>

          <!-- Job Overview Card -->
          <div class="job-overview-card" id="job-overview-card">
            <h3>Job Overview</h3>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
              <div><span class="label">Job Title</span><br><span class="value"><?=htmlspecialchars($response['title_name'])?></span></div>
            </div>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              <div><span class="label">Job Type</span><br><span class="value"><?=htmlspecialchars($response['type_name'])?></span></div>
            </div>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
              <div><span class="label">Category</span><br><span class="value"><?=htmlspecialchars($response['category_name'])?></span></div>
            </div>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
              <div><span class="label">Experience</span><br><span class="value"><?=htmlspecialchars($response['min_years_experience'])?> yrs</span></div>
            </div>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 3.3 4 6 4s6-2 6-4v-5"/></svg>
              <div><span class="label">Degree</span><br><span class="value"><?=htmlspecialchars($response['degree_name'])?></span></div>
            </div>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
              <div><span class="label">Offered Salary</span><br><span class="value"><?=htmlspecialchars($salary)?></span></div>
            </div>
            <div class="overview-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <div><span class="label">Location</span><br><span class="value"><?=htmlspecialchars($location)?></span></div>
            </div>

            <div class="overview-map">
              <iframe src="https://maps.google.com/maps?q=<?=urlencode($location)?>&t=&z=13&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" title="Job Location Map"></iframe>
            </div>
          </div>
        </aside>
      </div>
      <?php } ?>
    </div>
  </section>

  
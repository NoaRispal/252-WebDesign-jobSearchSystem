/* ============================================
   JOB PORTAL — JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
  initMobileNav();
  initFAQ();
  initSalarySlider();
  initSidebarToggle();
  initScrollReveal();
  initDashboardSidebar();
  initAdminTabs();
  initSkillsManager();
  initRoleSelector();
  initModals();
  initFormValidation();
  initDeleteConfirm();
  initCardExpand();
  initJobKeywordTags();
  initJobLocation();
  initSubmitJobFilter();
});

/* ============================================
   MOBILE NAVIGATION
   ============================================ */
function initMobileNav() {
  const hamburger = document.querySelector('.navbar-hamburger');
  const mobileMenu = document.querySelector('.mobile-menu');
  
  if (!hamburger || !mobileMenu) return;
  
  hamburger.addEventListener('click', function() {
    mobileMenu.classList.toggle('active');
    hamburger.classList.toggle('active');
    
    // Animate hamburger to X
    const spans = hamburger.querySelectorAll('span');
    if (hamburger.classList.contains('active')) {
      spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
      spans[1].style.opacity = '0';
      spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
      document.body.style.overflow = 'hidden';
    } else {
      spans[0].style.transform = '';
      spans[1].style.opacity = '';
      spans[2].style.transform = '';
      document.body.style.overflow = '';
    }
  });
  
  // Close menu when clicking a link
  mobileMenu.querySelectorAll('a').forEach(function(link) {
    link.addEventListener('click', function() {
      mobileMenu.classList.remove('active');
      hamburger.classList.remove('active');
      const spans = hamburger.querySelectorAll('span');
      spans[0].style.transform = '';
      spans[1].style.opacity = '';
      spans[2].style.transform = '';
      document.body.style.overflow = '';
    });
  });
}

/* ============================================
   FAQ ACCORDION
   ============================================ */
function initFAQ() {
  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;
  
  faqItems.forEach(function(item) {
    const question = item.querySelector('.faq-question');
    if (!question) return;
    
    question.addEventListener('click', function() {
      const isActive = item.classList.contains('active');
      
      // Close all
      faqItems.forEach(function(faq) {
        faq.classList.remove('active');
      });
      
      // Open clicked if it was closed
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
}

/* ============================================
   SALARY RANGE SLIDER
   ============================================ */
function initSalarySlider() {
  const slider = document.querySelector('#salary-range');
  const display = document.querySelector('#salary-display');
  
  if (!slider || !display) return;
  
  slider.addEventListener('input', function() {
    display.textContent = 'Salary: $0 - $' + Number(slider.value).toLocaleString();
  });
}

/* ============================================
   SIDEBAR TOGGLE (Jobs page)
   ============================================ */
function initSidebarToggle() {
  const toggleBtn = document.querySelector('.sidebar-toggle');
  const sidebar = document.querySelector('.jobs-sidebar');
  
  if (!toggleBtn || !sidebar) return;
  
  toggleBtn.addEventListener('click', function() {
    sidebar.classList.toggle('active');
    
    if (sidebar.classList.contains('active')) {
      toggleBtn.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg> Hide Filters';
    } else {
      toggleBtn.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 4h18M3 12h18M3 20h18"/></svg> Filters';
    }
  });
}

/* ============================================
   SCROLL REVEAL
   ============================================ */
function initScrollReveal() {
  const reveals = document.querySelectorAll('.reveal');
  if (!reveals.length) return;
  
  function checkReveal() {
    reveals.forEach(function(el) {
      const windowHeight = window.innerHeight;
      const elementTop = el.getBoundingClientRect().top;
      const revealPoint = 100;
      
      if (elementTop < windowHeight - revealPoint) {
        el.classList.add('visible');
      }
    });
  }
  
  window.addEventListener('scroll', checkReveal);
  checkReveal(); // Check on load
}

/* ============================================
   DASHBOARD SIDEBAR
   ============================================ */
function initDashboardSidebar() {
  const toggle = document.querySelector('.dashboard-sidebar-toggle');
  const sidebar = document.querySelector('.dashboard-sidebar');
  
  if (!toggle || !sidebar) return;
  
  toggle.addEventListener('click', function() {
    sidebar.classList.toggle('active');
  });
}

/* ============================================
   ADMIN TABS
   ============================================ */
function initAdminTabs() {
  const tabs = document.querySelectorAll('.admin-tab');
  const panels = document.querySelectorAll('.admin-panel');
  
  if (!tabs.length) return;
  
  tabs.forEach(function(tab) {
    tab.addEventListener('click', function() {
      const target = tab.getAttribute('data-tab');
      
      tabs.forEach(function(t) { t.classList.remove('active'); });
      panels.forEach(function(p) { p.classList.remove('active'); });
      
      tab.classList.add('active');
      var panel = document.querySelector('#panel-' + target);
      if (panel) panel.classList.add('active');
    });
  });
}

/* ============================================
   SKILLS MANAGER (Job Form)
   ============================================ */
// Need global in case you remove and re-add a skill 
// (other case since selectedSkills is not updated you will have the "skills already added")
let selectedSkills = []; 
const maxSkills = 5;

function initSkillsManager() {
  const addBtn = document.querySelector('#add-skill-btn');
  const skillSelect = document.querySelector('#skill-select');
  const profSelect = document.querySelector('#proficiency-select');
  const skillsList = document.querySelector('#skills-list');
  const skillCount = document.querySelector('#skill-count');
  
  if (!addBtn || !skillSelect || !skillsList) return;
  
  addBtn.addEventListener('click', function() {
    if (selectedSkills.length >= maxSkills) {
      alert('Maximum ' + maxSkills + ' skills allowed.');
      return;
    }
    
    var skill = skillSelect.value;
    var proficiency = profSelect ? profSelect.value : 'Intermediate';
    
    if (!skill) {
      alert('Please select a skill.');
      return;
    }
    if (selectedSkills.includes(skill)) {
      console.log(selectedSkills);
      alert('Skill already added.');
      return;
    }
    
    selectedSkills.push(skill);
    var index = selectedSkills.length - 1;
    
    // Create visual badge with hidden inputs for form submission
    var badge = document.createElement('div');
    badge.className = 'skill-badge';
    badge.setAttribute('data-skill', skill);
    badge.innerHTML =
      '<input type="hidden" name="skills[' + index + '][name]" value="' + skill + '">' +
      '<input type="hidden" name="skills[' + index + '][proficiency]" value="' + proficiency + '">' +
      skill + ' (' + proficiency + ') ' +
      '<button type="button" onclick="removeSkill(this, \'' + skill + '\')">&times;</button>';
    skillsList.appendChild(badge);
    
    if (skillCount) {
      skillCount.textContent = selectedSkills.length + '/' + maxSkills + ' skills selected';
    }
    
    skillSelect.value = '';
    if (profSelect) profSelect.value = 'Intermediate';
  });
}

function removeSkill(btn, skill) {
  var badge = btn.parentElement;
  badge.remove();
  const remainingBadges = document.querySelectorAll('.skill-badge');
  selectedSkills = Array.from(remainingBadges).map(b => b.getAttribute('data-skill'));
  // Re-index all remaining hidden inputs so skills[] array is sequential
  var badges = document.querySelectorAll('.skill-badge');
  badges.forEach(function(b, i) {
    var inputs = b.querySelectorAll('input[type="hidden"]');
    inputs.forEach(function(input) {
      var name = input.getAttribute('name');
      if (name.indexOf('[name]') > -1) {
        input.setAttribute('name', 'skills[' + i + '][name]');
      } else if (name.indexOf('[proficiency]') > -1) {
        input.setAttribute('name', 'skills[' + i + '][proficiency]');
      }
    });
  });
  
  var countEl = document.querySelector('#skill-count');
  var remaining = badges.length;
  if (countEl) {
    countEl.textContent = remaining + '/5 skills selected';
  }
}

/* ============================================
   ROLE SELECTOR (Auth pages)
   ============================================ */
function initRoleSelector() {
  var options = document.querySelectorAll('.role-option');
  if (!options.length) return;
  
  options.forEach(function(option) {
    option.addEventListener('click', function() {
      options.forEach(function(o) { o.classList.remove('active'); });
      option.classList.add('active');
      
      var radio = option.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;
    });
  });
}

/* ============================================
   MODALS
   ============================================ */
function initModals() {
  // Open modal
  document.querySelectorAll('[data-modal]').forEach(function(trigger) {
    trigger.addEventListener('click', function() {
      var target = document.querySelector('#' + trigger.getAttribute('data-modal'));
      if (target) {
        target.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  
  // Close modal
  document.querySelectorAll('.modal-close').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var overlay = btn.closest('.modal-overlay');
      if (overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  });
  
  // Close on overlay click
  document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  });
}

/* ============================================
   FORM VALIDATION (Client-side)
   ============================================ */
function initFormValidation() {
  var forms = document.querySelectorAll('form[data-validate]');
  
  forms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
      var isValid = true;
      var requiredFields = form.querySelectorAll('[required]');
      
      requiredFields.forEach(function(field) {
        var group = field.closest('.form-group');
        if (!group) return;
        
        if (!field.value.trim()) {
          group.classList.add('error');
          isValid = false;
        } else {
          group.classList.remove('error');
        }
        
        // Email validation
        if (field.type === 'email' && field.value.trim()) {
          var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(field.value)) {
            group.classList.add('error');
            isValid = false;
          }
        }
      });
      
      if (!isValid) {
        e.preventDefault();
      }
    });
  });
  
  // Clear error on input
  document.querySelectorAll('.form-control').forEach(function(input) {
    input.addEventListener('input', function() {
      var group = input.closest('.form-group');
      if (group) group.classList.remove('error');
    });
  });
}

/* ============================================
   DELETE CONFIRMATION
   ============================================ */
function initDeleteConfirm() {
  // Attach confirm dialogs to all delete action buttons
  document.querySelectorAll('.table-actions .delete, .table-actions button[title="Delete"]').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        e.preventDefault();
        e.stopPropagation();
      }
    });
  });
}

/* ============================================
   RESPONSIVE CARD EXPAND/COLLAPSE
   Toggles .is-expanded on dashboard table rows
   for the mobile stacked-card pattern.
   Only active on screens < 768px.
   ============================================ */
function initCardExpand() {
  var rows = document.querySelectorAll('.dashboard-table tbody tr');
  if (!rows.length) return;

  var mobileQuery = window.matchMedia('(max-width: 768px)');

  rows.forEach(function(row) {
    row.addEventListener('click', function(e) {
      // Only toggle on mobile
      if (!mobileQuery.matches) return;

      // Don't toggle if clicking inside action buttons, links, or forms
      var target = e.target;
      if (target.closest('.table-actions') || target.closest('a') || target.closest('button') || target.closest('form')) {
        return;
      }

      row.classList.toggle('is-expanded');
    });
  });
}

/* ============================================
  JOB KEYWORD TAGS (view/jobs/list.php)
  Handles adding and removing keyword tags.
  ============================================ */
const keywords = new Set();
function initJobKeywordTags() {
  const input = document.getElementById('keyword-input');
  const tags = document.getElementById('keyword-tags');
  if (!input || !tags) return;

  input.addEventListener('keyup', (e) => {
    if (e.key !== 'Enter') return;
    e.preventDefault();

    const value = input.value.trim().toLowerCase();
    input.value = '';

    if (!value || keywords.has(value)) return;
    keywords.add(value);

    const tag = document.createElement('span');
    tag.className = 'tag-item';
    tag.textContent = value;
    tag.addEventListener('click', () => { keywords.delete(value); tag.remove(); });
    tags.appendChild(tag);
  });
}

/* ============================================
  LOAD JOB LOCATION OPTIONS (view/jobs/list.php)
  Loads city and district options based on selected country and city.
  ============================================ */
function initJobLocation() {
  const countrySelect = document.getElementById('sidebar-country');
  const citySelect = document.getElementById('sidebar-city');
  const districtSelect = document.getElementById('sidebar-district');
  if (!countrySelect || !citySelect || !districtSelect) return;

  countrySelect.addEventListener('change', async function() {
    citySelect.innerHTML = '<option value="">Choose City</option>';
    districtSelect.innerHTML = '<option value="">Choose District</option>';
    const countryId = this.value;
    if (countryId) try {
      const response = await fetch(`/252-WebDesign-jobSearchSystem/public/jobs/api/get-cities/?country_id=${encodeURIComponent(countryId)}`);
      const cities = await response.json();
      
      cities.forEach(([id, value]) => {
        const option = document.createElement('option');
        option.value = id;
        option.textContent = value;
        citySelect.appendChild(option);
      });
    } catch (error) { console.error('Error loading cities:', error); }
  });

  citySelect.addEventListener('change', async function() {
    districtSelect.innerHTML = '<option value="">Choose District</option>';
    const cityId = this.value;
    if (cityId) try {
      const response = await fetch(`/252-WebDesign-jobSearchSystem/public/jobs/api/get-districts/?city_id=${encodeURIComponent(cityId)}`);
      const districts = await response.json();

      districts.forEach(([id, value]) => {
        const option = document.createElement('option');
        option.value = id;
        option.textContent = value;
        districtSelect.appendChild(option);
      });
    } catch (error) { console.error('Error loading districts:', error); }
  });
}

/* ============================================
  INITIALIZE JOB FILTER SUBMISSION (view/jobs/list.php)
  - Prevents default Enter-key submit behavior
  - Collects form fields and keyword tags
  - Triggers first load
  ============================================ */
let formData = null;
function initSubmitJobFilter() {
  const form = document.getElementById('job-filter-form');
  if (!form) return;

  form.addEventListener('keydown', (e) => { if (e.key === 'Enter') e.preventDefault(); });
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    formData = new FormData(form);
    keywords.forEach((keyword) => { formData.append('keywords[]', keyword); });
    submitJobFilter();
  });

  form.requestSubmit();
}

/* ============================================
  SUBMIT JOB FILTER REQUEST (view/jobs/list.php)
  Sends filter data to the backend API and updates frontend.
  ============================================ */
async function submitJobFilter() {
  try {
    const response = await fetch("/252-WebDesign-jobSearchSystem/public/jobs/api/job-filter-form", {method: "POST", body: formData});
    const result = await response.json();
    generateJobListCount(result);
    generateJobListResultContent(result);
    generateJobListPagination(result);
  } catch (err) { console.error("Error processing form:", err); }
}

/* ============================================
  RENDER JOB RESULTS COUNT (view/jobs/list.php)
  ============================================ */
function generateJobListCount(result) {
  document.getElementById('jobs-results-count').textContent = `(${result.total} results)`;
}

/* ============================================
  ESCAPE HTML TEXT (Utility)
  ============================================ */
function htmlEscape(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}
/* ============================================
  GENERATE JOB CARD ICON (view/jobs/list.php)
  ============================================ */
function generateJobListIcon(title, index) {
  const colors = ['#E8F5E9', '#FFF3E0', '#F3E5F5', '#E3F2FD', '#FCE4EC', '#E0F2F1'];
  const textColors = ['#4CAF50', '#FF9800', '#9C27B0', '#2196F3', '#E91E63', '#009688'];

  const initials = title.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2);
  const bgColor = colors[index % colors.length];
  const textColor = textColors[index % textColors.length];
  return `<div class="job-card-icon" style="background:${bgColor};color:${textColor};">${initials}</div>`;
}

/* ============================================
  RENDER JOB RESULT CARDS (view/jobs/list.php)
  ============================================ */
function generateJobListResultContent(result) {
  const jobsContent = document.getElementById('job-result-content');
  jobsContent.innerHTML = '';
  result.jobs.forEach((job, index) => {
    const jobCard = document.createElement('div');
    jobCard.className = 'job-card';
    jobCard.innerHTML = `
      <div class="job-card-header">
        <span class="job-card-time">Posted on ${(new Date(job.Posting_Date)).toLocaleDateString()}</span>
        <button class="job-card-bookmark" aria-label="Bookmark">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/>
          </svg>
        </button>
      </div>
      <div class="job-card-info">
        ${generateJobListIcon(job.Title_Name, job.Vacancy_ID)}
        <div>
          <h3 class="job-card-title">${htmlEscape(job.Title_Name)}</h3>
          <p class="job-card-company">${htmlEscape(job.Company_Name)}</p>
        </div>
      </div>
      <div class="job-card-footer">
        <div class="job-card-tags">
          <span class="job-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
            </svg>
            ${htmlEscape(job.Category_Name)}
          </span>
          <span class="job-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
            ${htmlEscape(job.Type_Name)}
          </span>
          <span class="job-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 10h20"/>
            </svg>
            $${Number(job.Min_Salary).toLocaleString()}-$${Number(job.Max_Salary).toLocaleString()}
          </span>
          <span class="job-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            ${htmlEscape(job.City_Name)}, ${htmlEscape(job.District_Name)}, ${htmlEscape(job.Country_Name)}
          </span>
        </div>
        <a href="/252-WebDesign-jobSearchSystem/public/jobs/detail?id=${job.Vacancy_ID}" class="btn-job-details">Job Details</a>
      </div>
    `;
    jobsContent.appendChild(jobCard);
  });
}

/* ============================================
  RENDER RESULTS PAGINATION (view/jobs/list.php)
  Builds page number controls.
  ============================================ */
function generateJobListPagination(result) {
  const paginationContainer = document.getElementById('pagination');
  paginationContainer.innerHTML = '';

  // Previous button
  if (result.page > 1) {
    const prevLink = document.createElement('a');
    prevLink.href = '#';
    prevLink.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg> Prev';
    prevLink.addEventListener('click', (e) => {
      e.preventDefault();
      formData.set('page', result.page - 1);
      submitJobFilter();
    });
    paginationContainer.appendChild(prevLink);
  }

  // Page number buttons (show up to 5 pages)
  const maxButtonsShown = 5;
  let startPage = Math.max(1, result.page - Math.floor(maxButtonsShown / 2));
  let endPage = Math.min(result.numPage, startPage + maxButtonsShown - 1);
  if (endPage - startPage + 1 < maxButtonsShown) {
    startPage = Math.max(1, endPage - maxButtonsShown + 1);
  }

  for (let page = startPage; page <= endPage; page++) {
    const link = document.createElement(page === result.page ? 'span' : 'a');
    link.textContent = page;
    if (page === result.page) link.className = 'active';
    else {
      link.href = '#';
      link.addEventListener('click', (e) => {
        e.preventDefault();
        formData.set('page', page);
        submitJobFilter();
      });
    }
    paginationContainer.appendChild(link);
  }

  // Next button
  if (result.page < result.numPage) {
    const nextLink = document.createElement('a');
    nextLink.href = '#';
    nextLink.className = 'next-btn';
    nextLink.innerHTML = 'Next <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>';
    nextLink.addEventListener('click', (e) => {
      e.preventDefault();
      formData.set('page', result.page + 1);
      submitJobFilter();
    });
    paginationContainer.appendChild(nextLink);
  }
}
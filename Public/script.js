/* ============================================
   JOB PORTAL — JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
  // ---- Mobile Navigation ----
  initMobileNav();
  
  // ---- FAQ Accordion ----
  initFAQ();
  
  // ---- Salary Range Slider ----
  initSalarySlider();
  
  // ---- Sidebar Toggle (Jobs page) ----
  initSidebarToggle();
  
  // ---- Scroll Reveal Animations ----
  initScrollReveal();
  
  // ---- Dashboard Sidebar Toggle ----
  initDashboardSidebar();
  
  // ---- Admin Tabs ----
  initAdminTabs();
  
  // ---- Skills Management ----
  initSkillsManager();
  
  // ---- Role Selector (Auth) ----
  initRoleSelector();
  
  // ---- Modal ----
  initModals();
  
  // ---- Form Validation ----
  initFormValidation();
  
  // ---- Delete Confirmations ----
  initDeleteConfirm();
  
  // ---- Responsive Card Expand (Mobile) ----
  initCardExpand();
  
  // ---- Skills Sidebar Filter ----
  initSkillsFilter();
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
function initSkillsManager() {
  const addBtn = document.querySelector('#add-skill-btn');
  const skillSelect = document.querySelector('#skill-select');
  const profSelect = document.querySelector('#proficiency-select');
  const skillsList = document.querySelector('#skills-list');
  const skillCount = document.querySelector('#skill-count');
  
  if (!addBtn || !skillSelect || !skillsList) return;
  
  let selectedSkills = [];
  const maxSkills = 5;
  
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
   UTILITY: Show More / Less for checkboxes
   ============================================ */
function toggleShowMore(btn) {
  var parent = btn.parentElement;
  var hidden = parent.querySelectorAll('.hidden-item');
  
  hidden.forEach(function(item) {
    item.style.display = item.style.display === 'none' ? 'flex' : 'none';
  });
  
  btn.textContent = btn.textContent === 'Show More' ? 'Show Less' : 'Show More';
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
   SKILLS FILTER (Sidebar)
   ============================================ */
function initSkillsFilter() {
  const searchInput = document.getElementById('skills-search-input');
  const skillsList = document.getElementById('skills-filter-list');
  const noResults = document.getElementById('skills-no-results');
  
  if (!searchInput || !skillsList || !noResults) return;

  const skillItems = skillsList.querySelectorAll('.checkbox-item');

  searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase().trim();
    let matchCount = 0;

    skillItems.forEach(item => {
      const skillName = item.querySelector('label').textContent.toLowerCase();
      
      if (skillName.includes(searchTerm)) {
        item.style.display = 'flex'; // Restore default flex display
        matchCount++;
      } else {
        item.style.display = 'none';
      }
    });

    if (matchCount === 0) {
      noResults.style.display = 'block';
    } else {
      noResults.style.display = 'none';
    }
  });
}

<!-- ====== PAGE HERO ====== -->
  <section class="page-hero" id="page-hero">
    <h1>Contact Us</h1>
  </section>

  <!-- ====== CONTACT LAYOUT ====== -->
  <section class="section" id="contact-section">
    <div class="container">
      <div class="contact-layout">
        <!-- Left: Contact Info -->
        <div class="contact-info" id="contact-info">
          <h2>You Will Grow, You Will Succeed. We Promise That</h2>
          <p>Our dedicated team is ready to help you with any questions about job listings, employer accounts, or partnership opportunities.</p>

          <div class="contact-details">
            <div class="contact-detail-item" id="contact-call">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
              <h4>Call for inquiry</h4>
              <p>+257 388-6895</p>
            </div>
            <div class="contact-detail-item" id="contact-email">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <h4>Send us email</h4>
              <p>kramulous@sbcglobal.net</p>
            </div>
            <div class="contact-detail-item" id="contact-hours">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              <h4>Opening hours</h4>
              <p>Mon - Fri: 10AM - 10PM</p>
            </div>
            <div class="contact-detail-item" id="contact-office">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <h4>Office</h4>
              <p>19 North Road Piscataway, NY 08854</p>
            </div>
          </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="contact-form-card" id="contact-form-card">
          <h3>Contact Info</h3>
          <p>Fill out the form below and we'll get back to you shortly</p>

<!-- BACKEND: Rename to contact.php -->
<!-- BACKEND: &lt;?php session_start(); ?&gt; -->

          <!-- BACKEND: Change action to: action="index.php?c=page&a=contact" method="POST"
               Add CSRF token.
               PageController::contact() should:
               1. Validate: first_name, last_name, email (FILTER_VALIDATE_EMAIL), message (not empty)
               2. Sanitize: htmlspecialchars(trim()) on all fields
               3. Store in DB or send email (optional for Assignment 2)
               4. Set flash: $_SESSION['flash_success'] = 'Message sent successfully!'
               5. Redirect back to contact.php
               
               Display flash after submit:
               &lt;?php if(isset($_SESSION['flash_success'])): ?&gt;
                 <div class="alert alert-success">&lt;?= $_SESSION['flash_success'] ?&gt;</div>
                 &lt;?php unset($_SESSION['flash_success']); ?&gt;
               &lt;?php endif; ?&gt;
          -->
          <form action="<?= $baseUrl ?>/submit" method="POST" data-validate id="contact-form">
            <div class="form-row">
              <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="Your name" required id="first-name">
                <span class="form-error">First name is required</span>
              </div>
              <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Your last name" required id="last-name">
                <span class="form-error">Last name is required</span>
              </div>
            </div>
            <div class="form-group">
              <label for="contact-email-input">Email Address</label>
              <input type="email" class="form-control" name="email" placeholder="Your E-mail address" required id="contact-email-input">
              <span class="form-error">Please enter a valid email</span>
            </div>
            <div class="form-group">
              <label for="contact-message">Message</label>
              <textarea class="form-control" name="message" placeholder="Your message..." rows="5" required id="contact-message"></textarea>
              <span class="form-error">Please enter a message</span>
            </div>
            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;" id="contact-submit">Send Message</button>
          </form>
        </div>
      </div>

      <!-- Map -->
      <div class="contact-map" id="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12095.521695058773!2d-73.8288611!3d40.7230685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2600472e50e2b%3A0x82e6954e1feddd28!2sForest%20Hills%2C%20Queens%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1" allowfullscreen="" loading="lazy" title="Office Location Map"></iframe>
      </div>

      <!-- Company Logos -->
      <div class="logos-bar" style="border:none;padding:var(--space-xl) 0;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <div class="logo-item" style="font-size:28px;">zoom</div>
          <div class="logo-item" style="font-size:28px;">🔥 tinder</div>
          <div class="logo-item" style="font-size:28px;">dribbble</div>
          <div class="logo-item" style="font-size:28px;">✦ asana</div>
        </div>
      </div>
    </div>
  </section>

  
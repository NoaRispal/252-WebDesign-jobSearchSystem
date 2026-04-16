<!-- ====== FOOTER ====== -->
  <footer class="footer" id="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <div class="footer-brand">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            <span>Job</span>
          </div>
          <p>Connecting talented professionals with leading companies worldwide. Your next career move starts here.</p>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <ul>
            <li><a href="<?= $baseUrl ?>/about">About Us</a></li>
            <li><a href="#">Our Team</a></li>
            <li><a href="#">Partners</a></li>
            <li><a href="#">For Candidates</a></li>
            <li><a href="#">For Employers</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Job Categories</h4>
          <ul>
            <li><a href="<?= $baseUrl ?>/jobs">Telecomunications</a></li>
            <li><a href="<?= $baseUrl ?>/jobs">Hotels & Tourism</a></li>
            <li><a href="<?= $baseUrl ?>/jobs">Construction</a></li>
            <li><a href="<?= $baseUrl ?>/jobs">Education</a></li>
            <li><a href="<?= $baseUrl ?>/jobs">Financial Services</a></li>
          </ul>
        </div>
        <div class="footer-col footer-newsletter">
          <h4>Newsletter</h4>
          <p>Subscribe to get the latest job listings and career tips delivered to your inbox</p>
          <form class="footer-newsletter-form" action="<?= $baseUrl ?>/submit" method="POST" id="newsletter-form">
            <input type="email" name="email" placeholder="Email Address" required id="newsletter-email">
            <button type="submit" class="btn btn-primary" id="newsletter-submit">Subscribe now</button>
          </form>
        </div>
      </div>

      <div class="footer-bottom">
        <span>© Copyright Job Portal 2024. Designed by Figma.guru</span>
        <div class="footer-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms & Conditions</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="<?= $baseUrl ?>/script.js"></script>
</body>
</html>

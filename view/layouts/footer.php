<?php
  $isFooterDashboard = (strpos($urlParam, 'admin') === 0) || (strpos($urlParam, 'employer') === 0);
?>

<?php if (!$isFooterDashboard): ?>
<!-- ====== FOOTER ====== -->
<footer class="footer" id="footer" style="padding-top: 60px; padding-bottom: 30px;">
    <div class="container">
      <div class="footer-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid rgba(0,0,0,0.1);">
        
        <div class="footer-col">
          <div class="footer-brand" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; font-weight: bold; font-size: 1.5rem; color: #2d3436;">
            <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#007bff" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            <span>JobPortal</span>
          </div>
          <p style="line-height: 1.6; color: #636e72; max-width: 300px;">Connecting talented professionals with leading companies worldwide. Your next career move starts here.</p>
          <div class="social-links" style="display: flex; gap: 15px; margin-top: 20px;">
            <a href="#" style="color: #636e72; transition: color 0.3s;" onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#636e72'"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
            <a href="#" style="color: #636e72; transition: color 0.3s;" onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#636e72'"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg></a>
          </div>
        </div>

        <div class="footer-col">
          <h4 style="margin-bottom: 25px; font-size: 1.1rem; color: #2d3436;">Quick Links</h4>
          <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 12px;"><a href="<?= $baseUrl ?>/home" style="text-decoration: none; color: #636e72; font-size: 0.95rem;">Home</a></li>
            <li style="margin-bottom: 12px;"><a href="<?= $baseUrl ?>/jobs" style="text-decoration: none; color: #636e72; font-size: 0.95rem;">Browse Jobs</a></li>
            <li style="margin-bottom: 12px;"><a href="<?= $baseUrl ?>/login" style="text-decoration: none; color: #636e72; font-size: 0.95rem;">Employer Login</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4 style="margin-bottom: 25px; font-size: 1.1rem; color: #2d3436;">Support</h4>
          <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 12px;"><a href="<?= $baseUrl ?>/about" style="text-decoration: none; color: #636e72; font-size: 0.95rem;">About Us</a></li>
            <li style="margin-bottom: 12px;"><a href="<?= $baseUrl ?>/contact" style="text-decoration: none; color: #636e72; font-size: 0.95rem;">Contact Support</a></li>
            <li style="margin-bottom: 12px;"><a href="<?= $baseUrl ?>/about" style="text-decoration: none; color: #636e72; font-size: 0.95rem;">Questions</a></li>
          </ul>
        </div>

      </div> 

      <div class="footer-bottom" style="padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <span style="color: #b2bec3; font-size: 0.85rem;">© Copyright Job Portal 2024. Designed by Figma.guru. Implemented for Web Programming Project</span>
        <div class="footer-links" style="display: flex; gap: 25px;">
          <a href="#" style="text-decoration: none; color: #b2bec3; font-size: 0.85rem;">Privacy Policy</a>
          <a href="#" style="text-decoration: none; color: #b2bec3; font-size: 0.85rem;">Terms & Conditions</a>
        </div>
      </div>
    </div>
</footer>
<?php endif; ?>

  <script src="<?= $baseUrl ?>/script.js"></script>
</body>
</html>

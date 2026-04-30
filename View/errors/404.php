<!-- BEFORE FIX:
<section class="section">
    <div class="container" style="text-align: center; padding: 100px 0;">
        <h1 style="font-size: 6rem; color: #309689; margin-bottom: 20px;">404</h1>
        <h2>Oops! Page Not Found</h2>
        <p style="margin-bottom: 40px; color: #666;">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="<?= $baseUrl ?>/home" class="btn btn-primary" style="display: inline-block; padding: 12px 24px;">Return to Home</a>
    </div>
</section>
-->
<section class="section">
    <div class="container" style="text-align: center; padding: 100px 0;">
        <h1 style="font-size: 6rem; color: #309689; margin-bottom: 20px;">404</h1>
        <h2>Oops! Page Not Found</h2>
        <p style="margin-bottom: 40px; color: #666;">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <div style="display: flex; justify-content: center; gap: 16px;">
            <button onclick="window.history.back()" class="btn btn-outline" style="padding: 12px 24px;">Go Back</button>
            <a href="<?= $baseUrl ?>/home" class="btn btn-primary" style="display: inline-block; padding: 12px 24px;">Return to Home</a>
        </div>
    </div>
</section>

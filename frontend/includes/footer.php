<?php
// includes/footer.php
$site_settings = function_exists('get_all_site_settings') ? get_all_site_settings() : [];
$fb = $site_settings['facebook_url'] ?? 'https://www.facebook.com/ngosakshambharti/';
$tw = $site_settings['twitter_url'] ?? 'https://x.com/bhartisaksham';
$ig = $site_settings['instagram_url'] ?? 'https://www.instagram.com/ngosakshambharti/';
$li = $site_settings['linkedin_url'] ?? 'https://in.linkedin.com/in/sakshambharti';
$address = $site_settings['address'] ?? 'E-36/13, UG Floor, Rajouri Garden, New Delhi-110027';
$phone = $site_settings['contact_phone'] ?? '+91 98765 43210';
$email = $site_settings['contact_email'] ?? 'info@sakshambharti.org';
?>
</main>
<footer>
    <div class="container py-4">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <h4 class="fw-bold text-white mb-3">Saksham Bharti</h4>
                <p>Empowering marginalized communities through skill development, education, and livelihood programs. Celebrating 25 Years of Impact.</p>
                <div class="d-flex gap-3 mt-3">
                    <?php if ($fb): ?><a href="<?= htmlspecialchars($fb) ?>" target="_blank" class="text-white"><i class="fab fa-facebook fa-lg"></i></a><?php endif; ?>
                    <?php if ($tw): ?><a href="<?= htmlspecialchars($tw) ?>" target="_blank" class="text-white"><i class="fab fa-twitter fa-lg"></i></a><?php endif; ?>
                    <?php if ($ig): ?><a href="<?= htmlspecialchars($ig) ?>" target="_blank" class="text-white"><i class="fab fa-instagram fa-lg"></i></a><?php endif; ?>
                    <?php if ($li): ?><a href="<?= htmlspecialchars($li) ?>" target="_blank" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a><?php endif; ?>
                    <?php if ($phone): ?><a href="https://wa.me/<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $phone)) ?>" target="_blank" class="text-white"><i class="fab fa-whatsapp fa-lg"></i></a><?php endif; ?>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <h5 class="text-white mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="programs.php">Programs</a></li>
                    <li><a href="impact.php">Impact</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <h5 class="text-white mb-3">Resources</h5>
                <ul class="list-unstyled">
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="collaborators.php">Collaborators</a></li>
                    <li><a href="annual-report.php">Annual Report</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <h5 class="text-white mb-3">Get Involved</h5>
                <ul class="list-unstyled">
                    <li><a href="volunteer.php">Volunteer</a></li>
                    <li><a href="get-involved.php">Donate</a></li>
                    <li><a href="scholarship.php">Scholarship</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="https://www.google.com/maps/search/?api=1&query=Saksham+Bharti" target="_blank" class="text-light text-decoration-none"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <?= htmlspecialchars($address) ?></a></li>
                    <li class="mb-2"><a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="text-light text-decoration-none"><i class="fas fa-phone me-2 text-secondary"></i> <?= htmlspecialchars($phone) ?></a></li>
                    <li class="mb-2"><a href="mailto:<?= htmlspecialchars($email) ?>" class="text-light text-decoration-none"><i class="fas fa-envelope me-2 text-secondary"></i> <?= htmlspecialchars($email) ?></a></li>
                </ul>
            </div>
        </div>
        <hr class="mt-4 border-secondary">
        <div class="text-center pt-2">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> <a href="index.php" class="text-light text-decoration-none hover-white">Saksham Bharti</a>. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
<!-- Chatbot JS -->
<script src="assets/js/chatbot.js"></script>

<!-- WhatsApp Floating Button -->
<?php 
// Clean the phone number for WhatsApp URL (only numbers)
$wa_number = preg_replace('/[^0-9]/', '', $phone); 
?>
<a href="https://wa.me/<?= htmlspecialchars($wa_number) ?>" target="_blank" class="whatsapp-float bg-success text-white rounded-circle shadow-lg d-flex align-items-center justify-content-center" title="Chat with us on WhatsApp" style="position: fixed; bottom: 105px; right: 30px; width: 60px; height: 60px; z-index: 9999; font-size: 35px; text-decoration: none; transition: transform 0.3s ease;">
    <i class="fab fa-whatsapp"></i>
</a>
<style>
.whatsapp-float:hover {
    transform: scale(1.1);
    background-color: #128C7E !important;
}
</style>
</body>
</html>

<!-- =============================================
     GLOBAL: Scroll Animations + Back To Top
     Applies to every page via footer.php
============================================== -->
<style>
/* Scroll animation base states */
.sb-fade-up {
    opacity: 0;
    transform: translateY(32px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.sb-fade-up.sb-visible {
    opacity: 1;
    transform: translateY(0);
}
/* Staggered delay for grid children */
.sb-fade-up:nth-child(1) { transition-delay: 0s; }
.sb-fade-up:nth-child(2) { transition-delay: 0.1s; }
.sb-fade-up:nth-child(3) { transition-delay: 0.2s; }
.sb-fade-up:nth-child(4) { transition-delay: 0.3s; }
.sb-fade-up:nth-child(5) { transition-delay: 0.35s; }
.sb-fade-up:nth-child(6) { transition-delay: 0.4s; }

/* Back to Top Button */
#sb-back-top {
    position: fixed;
    bottom: 175px;
    right: 30px;
    width: 46px;
    height: 46px;
    background: #1f327f;
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 1.1rem;
    cursor: pointer;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.3s ease, transform 0.3s ease, background 0.2s;
    z-index: 9998;
    box-shadow: 0 4px 16px rgba(31,50,127,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
}
#sb-back-top.visible {
    opacity: 1;
    transform: translateY(0);
}
#sb-back-top:hover {
    background: #f4a020;
}
</style>

<button id="sb-back-top" title="Back to top" aria-label="Back to top">
    <i class="fas fa-chevron-up"></i>
</button>

<script>
(function () {
    // ── 1. Scroll Animations ──────────────────────────
    // Target cards, col items, stat blocks, and section headings
    const selectors = [
        '.card',
        '.col-md-3',
        '.col-md-4',
        '.col-md-6',
        '.col-lg-3',
        '.col-lg-4',
        '.col-lg-6',
        '.impact-badge',
        '.counter',
    ].join(',');

    document.querySelectorAll(selectors).forEach(function (el) {
        // Skip elements inside hero sections
        if (el.closest('section') && el.closest('section').querySelector('h1')) return;
        el.classList.add('sb-fade-up');
    });

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('sb-visible');
                observer.unobserve(entry.target); // animate once only
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.sb-fade-up').forEach(function (el) {
        observer.observe(el);
    });

    // ── 2. Back to Top Button ─────────────────────────
    const btn = document.getElementById('sb-back-top');
    if (btn) {
        window.addEventListener('scroll', function () {
            btn.classList.toggle('visible', window.scrollY > 300);
        }, { passive: true });
        btn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
})();
</script>

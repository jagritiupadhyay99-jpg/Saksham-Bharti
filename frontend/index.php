<?php
// index.php
$page_title       = 'Saksham Bharti | Empowering Youth Through Skill & Education';
$page_description = 'Saksham Bharti empowers underprivileged youth aged 17-23 through free vocational training in IT, beauty culture, and stitching across 5 centers in New Delhi. 50,000+ lives touched in 25 years.';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="hero-title mb-4">Empowering Youth Through Skill & Education</h1>
                <p class="lead mb-5 opacity-75">From Incompetence to Competence — Aksham se Saksham. We provide vocational training and support to underprivileged youth to help them build a dignified future.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="programs.php" class="btn btn-secondary btn-lg rounded-pill px-5 py-3 shadow">Our Programs</a>
                    <a href="get-involved.php" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3">Donate Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Brief -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="assets/images/about_who_we_are.png" class="w-100 rounded-5 shadow-lg" alt="About Saksham Bharti">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="display-5 fw-bold text-primary mb-4">Bridging the Gap Between Skill & Opportunity</h2>
                <p class="lead text-muted mb-4">For over 25 years, Saksham Bharti has been dedicated to transforming lives. We believe that skill development is the key to economic independence.</p>
                <ul class="list-unstyled mb-5">
                    <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-secondary me-3 fa-lg"></i> <span>250+ Dedicated Volunteers</span></li>
                    <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-secondary me-3 fa-lg"></i> <span>Need-cum-Merit Scholarships</span></li>
                    <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-secondary me-3 fa-lg"></i> <span>Direct Industry Placement Links</span></li>
                </ul>
                <a href="about.php" class="btn btn-primary rounded-pill px-4">Learn More About Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Our Core Programs -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary">Our Core Programs</h2>
            <p class="lead text-muted">Specialized vocational training for youth aged 17 to 23.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card program-card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="assets/images/it.png" class="card-img-top program-img" alt="IT Training">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold text-primary mb-3">IT & Computer Skills</h4>
                        <p class="text-muted">Empowering youth with market-relevant digital literacy and advanced IT skills for the modern economy.</p>
                        <a href="programs.php" class="text-secondary text-decoration-none fw-bold">Explore Program <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card program-card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="assets/images/beauty.png" class="card-img-top program-img" alt="Beauty Culture">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold text-primary mb-3">Beauty Culture</h4>
                        <p class="text-muted">Professional training in beauty and wellness, enabling young women to start their own businesses or find employment.</p>
                        <a href="programs.php" class="text-secondary text-decoration-none fw-bold">Explore Program <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card program-card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="assets/images/stitching.png" class="card-img-top program-img" alt="Stitching & Tailoring">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold text-primary mb-3">Stitching & Tailoring</h4>
                        <p class="text-muted">Mastering the art of garment construction and design to foster self-reliance and entrepreneurship.</p>
                        <a href="programs.php" class="text-secondary text-decoration-none fw-bold">Explore Program <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Numbers -->
<section class="impact-section text-center">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h1 class="counter" data-target="25">0</h1>
                <p class="mb-0 text-uppercase fw-bold opacity-75">Years of Legacy</p>
            </div>
            <div class="col-md-3">
                <h1 class="counter" data-target="50000">0</h1>
                <p class="mb-0 text-uppercase fw-bold opacity-75">Lives Touched</p>
            </div>
            <div class="col-md-3">
                <h1 class="counter" data-target="5">0</h1>
                <p class="mb-0 text-uppercase fw-bold opacity-75">Key Training Centers</p>
            </div>
            <div class="col-md-3">
                <h1 class="counter" data-target="250">0</h1>
                <p class="mb-0 text-uppercase fw-bold opacity-75">Active Volunteers</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-5 bg-primary text-white p-5 text-center position-relative overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background: radial-gradient(circle at 20% 50%, #f4a020 0%, transparent 50%); z-index: 0;"></div>
                    <div class="position-relative" style="z-index: 1;">
                        <h2 class="display-6 fw-bold mb-4">Be the Change You Wish to See</h2>
                        <p class="lead mb-5 px-lg-5">Your support can help an underprivileged youth break the cycle of poverty. Join us as a volunteer or contribute to our cause.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="get-involved.php" class="btn btn-secondary btn-lg rounded-pill px-5">Get Involved</a>
                            <a href="contact.php" class="btn btn-outline-light btn-lg rounded-pill px-5">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

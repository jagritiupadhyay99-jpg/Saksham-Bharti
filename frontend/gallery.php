<?php
// gallery.php
$page_title       = 'Gallery | Saksham Bharti';
$page_description = 'View photos and memories of Saksham Bharti\'s center events, student activities, job fairs, and summer camps.';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #1f327f 0%, #0f1c4a 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index:0; opacity:0.15;">
        <div class="position-absolute rounded-circle bg-white" style="width:400px;height:400px;top:-100px;right:-60px;filter:blur(65px);"></div>
        <div class="position-absolute rounded-circle bg-white" style="width:280px;height:280px;bottom:-50px;left:-60px;filter:blur(55px);"></div>
    </div>
    <div class="container text-center py-5 position-relative" style="z-index:1;">
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill mb-4 border border-white border-opacity-25" style="backdrop-filter:blur(10px);">
            <i class="fas fa-images me-2" style="color:#f4a020;"></i>
            <span class="small fw-semibold">MEMORIES &amp; MOMENTS — SAKSHAM BHARTI IN ACTION</span>
        </div>
        <h1 class="display-3 fw-bolder mb-3 text-white">Our Photo Gallery</h1>
        <p class="lead text-light opacity-75 mx-auto" style="max-width:680px;">Capturing moments of growth, learning, and celebration across our vocational training centers in Delhi.</p>
    </div>
</section>

<!-- Coming Soon Content Section -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="p-5 bg-white rounded-4 shadow-sm border border-light">
                    <div class="bg-primary bg-opacity-10 text-primary p-4 rounded-circle d-inline-block mb-4" style="width: 100px; height: 100px; line-height: 50px;">
                        <i class="fas fa-images fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-3">Gallery Coming Soon</h2>
                    <p class="text-muted mb-4">We are currently curating a collection of our most inspiring student stories, community activities, and event photos. Please check back soon to see our impact in action.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="index.php" class="btn btn-primary rounded-pill px-4">Go to Home Page</a>
                        <a href="contact.php" class="btn btn-outline-secondary rounded-pill px-4">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

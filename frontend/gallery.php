<?php
// gallery.php
$page_title       = 'Gallery | Saksham Bharti';
$page_description = 'View photos and memories of Saksham Bharti\'s center events, student activities, job fairs, and summer camps.';
require_once 'includes/header.php';
?>

<!-- Hero Header Section -->
<section class="page-hero bg-primary text-white py-5" style="background: linear-gradient(135deg, #1f327f 0%, #0f1c4a 100%);">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold mb-3">Our Photo Gallery</h1>
        <p class="lead max-w-2xl mx-auto opacity-75">Capturing moments of growth, learning, and celebration across our vocational training centers.</p>
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

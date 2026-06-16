<?php
// contact.php
$page_title       = 'Contact Us | Saksham Bharti';
$page_description = 'Get in touch with Saksham Bharti. Visit our 5 training centers across New Delhi or send us a message. We are here to answer your questions about volunteering, donations, and programs.';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/includes/functions.php';

// Fetch dynamic site settings for contact info
$site = get_all_site_settings();
if (empty($site)) {
    $site = [
        'contact_email'    => 'info@sakshambharti.org',
        'contact_phone'    => '+91 98765 43210',
        'address'          => 'E-36/13, UG Floor, Rajouri Garden, New Delhi-110027',
        'facebook_url'     => 'https://www.facebook.com/ngosakshambharti/',
        'twitter_url'      => 'https://x.com/bhartisaksham',
        'instagram_url'    => 'https://www.instagram.com/ngosakshambharti/',
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash_message('error', 'Invalid security token.');
        header("Location: contact.php");
        exit;
    }

    // Rate Limiting: Max 3 requests per minute
    if (!check_rate_limit('contact', 3, 60)) {
        set_flash_message('error', 'Too many requests. Please wait a minute before trying again.');
        header("Location: contact.php");
        exit;
    }

    // reCAPTCHA v3 Validation
    $recaptcha_response = $_POST['recaptcha_response'] ?? '';
    if (!verify_recaptcha($recaptcha_response)) {
        set_flash_message('error', 'Spam protection check failed. Please try again.');
        header("Location: contact.php");
        exit;
    }

    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        set_flash_message('error', 'All fields are required.');
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        set_flash_message('error', 'Full Name should only contain alphabets and spaces.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash_message('error', 'Invalid email format.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            
            // Send email notification to admin
            $subject = "New Contact Message from $name";
            $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Message:</strong><br>" . nl2br($message);
            send_notification_email($subject, $body);

            // Send confirmation to user
            $user_subject = "We received your message - Saksham Bharti";
            $user_body = "<p>Thank you for reaching out to us. We have received your message and our team will get back to you shortly.</p>
                          <p><strong>Your Message:</strong><br>" . nl2br($message) . "</p>";
            send_user_email($email, $name, $user_subject, $user_body);

            set_flash_message('success', 'Message sent successfully!');
        } catch (PDOException $e) {
            set_flash_message('error', 'Error sending message.');
        }
    }
    header("Location: contact.php");
    exit;
}

require_once 'includes/header.php';

$csrf_token = generate_csrf_token();
$error = get_flash_message('error');
$success = get_flash_message('success');
?>

<section class="py-5 bg-light border-bottom">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold text-primary display-4">Get in Touch</h1>
            <p class="lead text-muted">Have questions? We're here to help and would love to hear from you.</p>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-5">
            <h2 class="fw-bold text-primary mb-4">Contact Information</h2>
            <p class="text-muted mb-5">Reach out to us through any of these channels or visit our registered office.</p>

            <div class="d-flex mb-4">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                    <i class="fas fa-map-marker-alt fa-fw fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Registered Office</h5>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($site['address'] ?: 'E-36/13, UG Floor, Rajouri Garden, New Delhi-110027') ?></p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                    <i class="fas fa-phone-alt fa-fw fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Phone</h5>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($site['contact_phone'] ?: '+91 98765 43210') ?></p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                    <i class="fas fa-envelope fa-fw fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Email</h5>
                    <p class="text-muted small mb-0"><a href="mailto:<?= htmlspecialchars($site['contact_email']) ?>" class="text-muted text-decoration-none"><?= htmlspecialchars($site['contact_email'] ?: 'info@sakshambharti.org') ?></a></p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                    <i class="fas fa-clock fa-fw fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Office Hours</h5>
                    <p class="text-muted small mb-0">Mon - Sat: 10:00 AM - 06:00 PM<br>Sunday: Closed</p>
                </div>
            </div>

            <div class="d-flex mb-5">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                    <i class="fas fa-share-alt fa-fw fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-2">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <?php if (!empty($site['facebook_url'])): ?>
                        <a href="<?= htmlspecialchars($site['facebook_url']) ?>" target="_blank" class="text-primary fs-5"><i class="fab fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site['twitter_url'])): ?>
                        <a href="<?= htmlspecialchars($site['twitter_url']) ?>" target="_blank" class="text-primary fs-5"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site['instagram_url'])): ?>
                        <a href="<?= htmlspecialchars($site['instagram_url']) ?>" target="_blank" class="text-primary fs-5"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site['linkedin_url'])): ?>
                        <a href="<?= htmlspecialchars($site['linkedin_url']) ?>" target="_blank" class="text-primary fs-5"><i class="fab fa-linkedin"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr class="mb-5">

            <h4 class="fw-bold text-primary mb-4">Frequently Asked Questions</h4>
            <div class="accordion accordion-flush" id="faqAccordion">
                <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent fw-bold px-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How can I join as a student?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body px-0 text-muted small">
                            You can visit any of our centers directly or fill out the contact form. We focus on youth aged 17-23 from marginalized backgrounds.
                        </div>
                    </div>
                </div>
                <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent fw-bold px-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Is there any fee for the courses?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body px-0 text-muted small">
                            Our primary mission is to empower the underprivileged. While most courses are free, some have a nominal registration fee to ensure commitment.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                <h3 class="fw-bold text-primary mb-4">Send us a Message</h3>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?= $success ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="contact.php" id="contactForm">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                    <input type="hidden" name="recaptcha_response" id="recaptcha_response">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-4">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="John Doe" required pattern="[A-Za-z\s]+" title="Full Name should only contain alphabets and spaces">
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3 border-light bg-light shadow-none focus-primary" placeholder="name@example.com" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Message</label>
                        <textarea name="message" class="form-control rounded-3 border-light bg-light shadow-none focus-primary" rows="6" placeholder="How can we help you?" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Map and Center Locations -->
    <div class="mt-5 pt-5">
        <h2 class="fw-bold text-primary mb-4 text-center">Our Training Centers</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-primary mb-2">Raghubir Nagar Center</h6>
                        <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>Basti Vikas Kender, R-block, Raghubir Nagar, New Delhi-110027</p>
                        <a href="https://www.google.com/maps/search/?api=1&query=Saksham+Bharti+Raghubir+Nagar" target="_blank" class="btn btn-link p-0 text-decoration-none small fw-bold">View on Maps <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-primary mb-2">Vikas Nagar Center</h6>
                        <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>B-21/22, Vikas Kunj (extn), Vikas Nagar, New Delhi-110059</p>
                        <a href="https://www.google.com/maps/search/?api=1&query=Saksham+Bharti+Vikas+Nagar" target="_blank" class="btn btn-link p-0 text-decoration-none small fw-bold">View on Maps <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-primary mb-2">Dwarka Center</h6>
                        <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>Plot No. 1, Dwarka Sector 2, New Delhi-110075</p>
                        <a href="https://www.google.com/maps/search/?api=1&query=Saksham+Pratibha+Kendra+Dwarka" target="_blank" class="btn btn-link p-0 text-decoration-none small fw-bold">View on Maps <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-primary mb-2">Aya Nagar Center</h6>
                        <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>B-27, phase 2, Aya Nagar, New Delhi-110047</p>
                        <a href="https://www.google.com/maps/search/?api=1&query=Saksham+Bharti+Aya+Nagar" target="_blank" class="btn btn-link p-0 text-decoration-none small fw-bold">View on Maps <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-primary mb-2">Nangloi Center</h6>
                        <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>Nangloi, New Delhi (Recently Opened Training Center)</p>
                        <a href="https://www.google.com/maps/search/?api=1&query=Saksham+Bharti+Nangloi" target="_blank" class="btn btn-link p-0 text-decoration-none small fw-bold">View on Maps <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .focus-primary:focus {
        border-color: var(--primary-color) !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(31, 50, 127, 0.1) !important;
    }
</style>

<?php require_once 'includes/footer.php'; ?>

<!-- Google reCAPTCHA v3 JS -->
<script src="https://www.google.com/recaptcha/api.js?render=6LeIxAcTAAAAAJcZVRqySaR7VqICljfrEE_amzQC"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    var form = this;
    if (form.checkValidity()) {
        // Localhost bypass for robust local testing
        var isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1' || window.location.hostname === '';
        if (isLocalhost) {
            console.log('Localhost detected: bypassing reCAPTCHA.');
            return; // Submit natively
        }

        if (typeof grecaptcha !== 'undefined') {
            e.preventDefault();
            
            // Safety timeout: if reCAPTCHA hangs for > 3s, submit anyway
            var submitted = false;
            var safetyTimeout = setTimeout(function() {
                if (!submitted) {
                    submitted = true;
                    console.warn('reCAPTCHA timed out, submitting form.');
                    form.submit();
                }
            }, 3000);

            grecaptcha.ready(function() {
                grecaptcha.execute('6LeIxAcTAAAAAJcZVRqySaR7VqICljfrEE_amzQC', {action: 'contact'}).then(function(token) {
                    clearTimeout(safetyTimeout);
                    if (!submitted) {
                        submitted = true;
                        document.getElementById('recaptcha_response').value = token;
                        form.submit();
                    }
                }).catch(function(err) {
                    clearTimeout(safetyTimeout);
                    console.error('reCAPTCHA execution error, falling back to direct submit:', err);
                    if (!submitted) {
                        submitted = true;
                        form.submit();
                    }
                });
            });
        }
    }
});
</script>



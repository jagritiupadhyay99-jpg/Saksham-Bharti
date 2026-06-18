<?php
// volunteer.php
$page_title       = 'Become a Volunteer | Saksham Bharti';
$page_description = 'Join 250+ volunteers at Saksham Bharti. Sign up to make a difference in the lives of underprivileged youth through teaching, mentoring, and community outreach in New Delhi.';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/includes/functions.php';

// Handle Volunteer Form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'volunteer') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash_message('volunteer_error', 'Invalid security token.');
        header("Location: volunteer.php");
        exit;
    }

    // Rate Limiting: Max 3 requests per minute
    if (!check_rate_limit('volunteer', 3, 60)) {
        set_flash_message('volunteer_error', 'Too many requests. Please wait a minute before trying again.');
        header("Location: volunteer.php");
        exit;
    }

    // reCAPTCHA v3 Validation
    $recaptcha_response = $_POST['recaptcha_response'] ?? '';
    if (!verify_recaptcha($recaptcha_response)) {
        set_flash_message('volunteer_error', 'Spam protection check failed. Please try again.');
        header("Location: volunteer.php");
        exit;
    }

    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $interest = sanitize_input($_POST['interest'] ?? '');

    if (empty($name) || empty($email) || empty($phone) || empty($interest)) {
        set_flash_message('volunteer_error', 'Please fill all required volunteer fields.');
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        set_flash_message('volunteer_error', 'Full Name should only contain alphabets and spaces.');
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        set_flash_message('volunteer_error', 'Phone Number must be exactly 10 digits.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash_message('volunteer_error', 'Invalid email format.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO volunteers (name, email, phone, interest) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $interest]);
            
            // Send email notification to admin
            $subject = "New Volunteer Signup: $name";
            $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Phone:</strong> $phone<br><strong>Interest:</strong> $interest";
            send_notification_email($subject, $body);

            // Send confirmation email to the volunteer
            send_user_email(
                $email,
                $name,
                'Welcome to Saksham Bharti — Thank You for Volunteering!',
                '<p>Thank you for registering as a volunteer with <strong>Saksham Bharti</strong>! We are thrilled to have you join our community of changemakers.</p>
                <p>Here is a summary of your registration:</p>
                <table style="border-collapse:collapse;width:100%;margin:10px 0;">
                    <tr><td style="padding:8px;border:1px solid #eee;color:#666;width:40%;">Area of Interest</td><td style="padding:8px;border:1px solid #eee;font-weight:bold;">' . htmlspecialchars($interest) . '</td></tr>
                    <tr><td style="padding:8px;border:1px solid #eee;color:#666;">Phone</td><td style="padding:8px;border:1px solid #eee;font-weight:bold;">' . htmlspecialchars($phone) . '</td></tr>
                </table>
                <p>Our team will get in touch with you soon with the next steps. In the meantime, feel free to explore our programs at our website.</p>'
            );

            set_flash_message('volunteer_success', 'Thank you for signing up to volunteer!');
        } catch (PDOException $e) {
            set_flash_message('volunteer_error', 'Database error: ' . $e->getMessage());
        }
    }
    header("Location: volunteer.php");
    exit;
}

require_once 'includes/header.php';

$csrf_token = generate_csrf_token();
$vol_err = get_flash_message('volunteer_error');
$vol_succ = get_flash_message('volunteer_success');
?>

<!-- Hero Section -->
<section class="position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #1f327f 0%, #0f1c4a 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index:0; opacity:0.15;">
        <div class="position-absolute rounded-circle bg-white" style="width:400px;height:400px;top:-100px;right:-60px;filter:blur(65px);"></div>
        <div class="position-absolute rounded-circle bg-white" style="width:280px;height:280px;bottom:-50px;left:-60px;filter:blur(55px);"></div>
    </div>
    <div class="container text-center py-5 position-relative" style="z-index:1;">
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill mb-4 border border-white border-opacity-25" style="backdrop-filter:blur(10px);">
            <i class="fas fa-hands-helping me-2" style="color:#ffc107;"></i>
            <span class="small fw-semibold">JOIN 250+ CHANGEMAKERS — GET INVOLVED TODAY</span>
        </div>
        <h1 class="display-3 fw-bolder mb-3 text-white">Become a Volunteer</h1>
        <p class="lead text-light opacity-75 mx-auto" style="max-width:680px;">Give your time, share your skills, and help us transform the lives of underprivileged youth. Every hour you give creates a ripple of lasting change.</p>
    </div>
</section>

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold text-primary mb-4">Why Volunteer with Us?</h2>
                    <p class="mb-4">At Saksham Bharti, our volunteers are the backbone of our operations. By giving your time, you're directly contributing to the empowerment of underprivileged youth.</p>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-graduation-cap fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Impact Lives</h5>
                            <p class="text-muted small mb-0">Help students transition from aksham (incompetent) to saksham (competent).</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-network-wired fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Professional Growth</h5>
                            <p class="text-muted small mb-0">Network with 250+ professionals from diverse backgrounds.</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-heart fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Personal Satisfaction</h5>
                            <p class="text-muted small mb-0">Experience the joy of selfless service and community building.</p>
                        </div>
                    </div>

                    <div class="card border-0 bg-light rounded-4 p-4 mt-4 shadow-sm border-start border-4 border-secondary">
                        <div class="d-flex align-items-start">
                            <div class="me-3 text-secondary">
                                <i class="fas fa-id-card fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-primary mb-1">Lifetime Membership</h5>
                                <p class="small text-muted mb-0">Individuals who share our mission and wish to support our operational framework can become lifetime members of Saksham Bharti by paying a nominal one-time membership fee of <strong>₹1,000</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 border-top border-5 border-primary">
                        <h3 class="fw-bold text-primary mb-4 text-center">Join the Mission</h3>
                        
                        <?php if ($vol_err): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $vol_err ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <?php if ($vol_succ): ?>
                            <div class="alert alert-success alert-dismissible fade show text-center">
                                <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"></i>
                                <?= $vol_succ ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="volunteer.php" id="volunteerForm">
                            <input type="hidden" name="action" value="volunteer">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                            <input type="hidden" name="recaptcha_response" id="recaptcha_response">
                            
                            <div class="mb-4">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg rounded-3" placeholder="John Doe" required pattern="[A-Za-z\s]+" title="Full Name should only contain alphabets and spaces">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg rounded-3" placeholder="john@example.com" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control form-control-lg rounded-3" placeholder="10-digit mobile number" required pattern="[0-9]{10}" maxlength="10" title="Phone Number must be exactly 10 digits">
                        </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Area of Interest</label>
                                <select name="interest" class="form-select form-select-lg rounded-3" required>
                                    <option value="" selected disabled>Select an option</option>
                                    <option value="IT Training">IT Training</option>
                                    <option value="Vocational Skills">Vocational Skills</option>
                                    <option value="Soft Skills">Soft Skills</option>
                                    <option value="Mentorship">Mentorship</option>
                                    <option value="Job Placement">Job Placement</option>
                                    <option value="Fundraising">Fundraising</option>
                                    <option value="Event Management">Event Management</option>
                                    <option value="Social Outreach">Social Outreach</option>
                                    <option value="Green Initiatives">Green Initiatives</option>
                                    <option value="Admin Support">Admin Support</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">Sign Up to Volunteer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<!-- Google reCAPTCHA v3 JS -->
<script src="https://www.google.com/recaptcha/api.js?render=6LeIxAcTAAAAAJcZVRqySaR7VqICljfrEE_amzQC"></script>
<script>
document.getElementById('volunteerForm').addEventListener('submit', function(e) {
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
                grecaptcha.execute('6LeIxAcTAAAAAJcZVRqySaR7VqICljfrEE_amzQC', {action: 'volunteer'}).then(function(token) {
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



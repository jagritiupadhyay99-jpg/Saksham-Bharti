<?php
// get-involved.php (Donation Page)
$page_title       = 'Donate & Support | Saksham Bharti';
$page_description = 'Support Saksham Bharti with a donation. Your contribution funds free vocational training for underprivileged youth in New Delhi. Every rupee helps a young person build a dignified future.';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/includes/functions.php';

// Handle Donation Form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'donate') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash_message('donate_error', 'Invalid security token.');
        header("Location: get-involved.php");
        exit;
    }

    // Rate Limiting: Max 3 requests per minute
    if (!check_rate_limit('donate', 3, 60)) {
        set_flash_message('donate_error', 'Too many requests. Please wait a minute before trying again.');
        header("Location: get-involved.php");
        exit;
    }

    // reCAPTCHA v3 Validation
    $recaptcha_response = $_POST['recaptcha_response'] ?? '';
    if (!verify_recaptcha($recaptcha_response)) {
        set_flash_message('donate_error', 'Spam protection check failed. Please try again.');
        header("Location: get-involved.php");
        exit;
    }

    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $amount = filter_var($_POST['amount'] ?? 0, FILTER_VALIDATE_FLOAT);
    $message = sanitize_input($_POST['message'] ?? '');

    if (empty($name) || empty($email) || !$amount) {
        set_flash_message('donate_error', 'Please fill all required donation fields correctly.');
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        set_flash_message('donate_error', 'Full Name should only contain alphabets and spaces.');
    } elseif ($amount <= 0) {
        set_flash_message('donate_error', 'Amount must be a positive number.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash_message('donate_error', 'Invalid email format.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO donations (name, email, amount, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $amount, $message]);
            
            // Send email notification to admin
            $subject = "New Donation Intent from $name";
            $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Amount:</strong> ₹$amount<br><strong>Message:</strong><br>" . nl2br($message);
            send_notification_email($subject, $body);

            // Send thank-you email to the donor
            send_user_email(
                $email,
                $name,
                'Thank You for Your Donation — Saksham Bharti',
                '<p>Your generous contribution of <strong>₹' . number_format($amount, 2) . '</strong> has been received and will go directly towards empowering underprivileged youth through skill development.</p>
                <p style="background:#f0f7f0;border-left:4px solid #28a745;padding:12px 16px;border-radius:4px;">
                    <strong>Every rupee you give helps a young person build a dignified future.</strong>
                </p>
                <p>Your donation details:</p>
                <table style="border-collapse:collapse;width:100%;margin:10px 0;">
                    <tr><td style="padding:8px;border:1px solid #eee;color:#666;width:40%;">Amount</td><td style="padding:8px;border:1px solid #eee;font-weight:bold;color:#28a745;">₹' . number_format($amount, 2) . '</td></tr>
                    ' . (!empty($message) ? '<tr><td style="padding:8px;border:1px solid #eee;color:#666;">Your Message</td><td style="padding:8px;border:1px solid #eee;">' . htmlspecialchars($message) . '</td></tr>' : '') . '
                </table>
                <p>We will share an official receipt and utilization report with you. Thank you for being part of the Saksham Bharti family!</p>'
            );

            set_flash_message('donate_success', 'Thank you for your generous donation!');
        } catch (PDOException $e) {
            set_flash_message('donate_error', 'Database error: ' . $e->getMessage());
        }
    }
    header("Location: get-involved.php");
    exit;
}

require_once 'includes/header.php';

$csrf_token = generate_csrf_token();
$donate_err = get_flash_message('donate_error');
$donate_succ = get_flash_message('donate_success');
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="fw-bold text-primary display-4">Support Our Cause</h1>
                <p class="lead text-muted">Your contribution helps us provide free vocational training to those who need it most.</p>
            </div>

            <div class="row g-5">
                <!-- Donation Form Column -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 border-top border-5 border-secondary bg-white">
                        <h3 class="fw-bold text-primary mb-4"><i class="fas fa-hand-holding-heart text-secondary me-2"></i>Make a Donation</h3>
                        
                        <?php if ($donate_err): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $donate_err ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <?php if ($donate_succ): ?>
                            <div class="alert alert-success alert-dismissible fade show text-center">
                                <i class="fas fa-heart fa-3x mb-3 d-block text-danger"></i>
                                <?= $donate_succ ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="get-involved.php" id="donateForm">
                            <input type="hidden" name="action" value="donate">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                            <input type="hidden" name="recaptcha_response" id="recaptcha_response">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control form-control-lg rounded-3 border-light bg-light shadow-none" placeholder="John Doe" required pattern="[A-Za-z\s]+" title="Full Name should only contain alphabets and spaces">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3 border-light bg-light shadow-none" placeholder="john@example.com" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Amount (INR)</label>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden border border-light">
                                    <span class="input-group-text border-0 bg-light">₹</span>
                                    <input type="number" name="amount" id="donation_amount" class="form-control border-0 bg-light" placeholder="500" required min="1" step="1" pattern="[0-9]+" title="Amount should only contain digits">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Message (Optional)</label>
                                <textarea name="message" class="form-control rounded-3 border-light bg-light shadow-none" rows="3" placeholder="A brief message..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-secondary btn-lg w-100 rounded-pill shadow-sm">Donate Now</button>
                        </form>
                    </div>
                </div>

                <!-- Info and Sponsorship Cards Column -->
                <div class="col-lg-7">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-success bg-opacity-25 text-success rounded-pill px-3 py-2 me-3 fw-bold border border-success border-opacity-50">
                                <i class="fas fa-percent me-1"></i> Section 80G
                            </span>
                            <span class="text-success fw-bold">Tax Exempt</span>
                        </div>
                        <h2 class="fw-bold text-primary mb-3">Sponsor a Student (6 Months)</h2>
                        <p class="text-muted">Click a sponsorship tier below to automatically populate the donation amount in the form. Every contribution is tax-deductible.</p>
                    </div>

                    <!-- Tiers Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border border-light shadow-sm rounded-4 p-3 hover-lift cursor-pointer tier-card" data-amount="2500">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary rounded-pill px-3">School Education</span>
                                    <h4 class="fw-bold text-primary mb-0">₹2,500</h4>
                                </div>
                                <h6 class="fw-bold mb-1">Scholarship (Up to 10th Class)</h6>
                                <p class="text-muted small mb-0">Covers tuition, school books, and basic school kit support for 1 child.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100 border border-light shadow-sm rounded-4 p-3 hover-lift cursor-pointer tier-card" data-amount="5000">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-secondary rounded-pill px-3">Vocational</span>
                                    <h4 class="fw-bold text-secondary mb-0">₹5,000</h4>
                                </div>
                                <h6 class="fw-bold mb-1">Stitching & Tailoring Course</h6>
                                <p class="text-muted small mb-0">Sponsor vocational tailoring and sewing classes for one female student.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border border-light shadow-sm rounded-4 p-3 hover-lift cursor-pointer tier-card" data-amount="5000">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-info text-white rounded-pill px-3">Digital</span>
                                    <h4 class="fw-bold text-info mb-0">₹5,000</h4>
                                </div>
                                <h6 class="fw-bold mb-1">IT & Computer Training</h6>
                                <p class="text-muted small mb-0">Sponsor specialized computer and data entry training in affiliation with NIIT.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border border-light shadow-sm rounded-4 p-3 hover-lift cursor-pointer tier-card" data-amount="5000">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-warning text-dark rounded-pill px-3">Higher Ed</span>
                                    <h4 class="fw-bold text-warning mb-0">₹5,000</h4>
                                </div>
                                <h6 class="fw-bold mb-1">Higher Education Support</h6>
                                <p class="text-muted small mb-0">Scholarship for college students (after 12th) to enable higher career paths.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Handcrafted Token Appreciation -->
                    <div class="card border-0 bg-light rounded-4 p-4 mb-4 border-start border-4 border-secondary shadow-sm">
                        <div class="d-flex">
                            <div class="me-3 text-secondary">
                                <i class="fas fa-gift fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-primary mb-1">Handcrafted Token of Gratitude</h5>
                                <p class="small text-muted mb-0">As a gesture of thanks, all our donors will receive a handcrafted token of appreciation created with love by Saksham Bharti's vocational trainees.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            
            <script>
                // Dynamic amount selection script
                document.querySelectorAll('.tier-card').forEach(function(card) {
                    card.addEventListener('click', function() {
                        var amount = this.getAttribute('data-amount');
                        var amountInput = document.getElementById('donation_amount');
                        if (amountInput) {
                            amountInput.value = amount;
                            // Add flash animation
                            amountInput.style.backgroundColor = '#d1e7dd';
                            setTimeout(function() {
                                amountInput.style.backgroundColor = '#f8f9fa';
                            }, 500);
                        }
                    });
                });
            </script>
            <style>
                .cursor-pointer {
                    cursor: pointer;
                }
                .tier-card:hover {
                    border-color: var(--secondary-color) !important;
                    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
                }
            </style>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<!-- Google reCAPTCHA v3 JS -->
<script src="https://www.google.com/recaptcha/api.js?render=6LeIxAcTAAAAAJcZVRqySaR7VqICljfrEE_amzQC"></script>
<script>
document.getElementById('donateForm').addEventListener('submit', function(e) {
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
                grecaptcha.execute('6LeIxAcTAAAAAJcZVRqySaR7VqICljfrEE_amzQC', {action: 'donate'}).then(function(token) {
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



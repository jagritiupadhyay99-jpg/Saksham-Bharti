<?php
// get-involved.php (Donation Page)
$page_title       = 'Donate & Support | Saksham Bharti Foundation';
$page_description = 'Support Saksham Bharti Foundation with a donation. Your contribution funds free vocational training for underprivileged youth in New Delhi. Every rupee helps a young person build a dignified future.';
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
                'Thank You for Your Donation — Saksham Bharti Foundation',
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
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 h-100 border-top border-5 border-secondary">
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
                    <input type="text" name="name" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="John Doe" required pattern="[A-Za-z\s]+" title="Full Name should only contain alphabets and spaces">
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="john@example.com" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Amount (INR)</label>
                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text border-0 bg-white">₹</span>
                        <input type="number" name="amount" class="form-control border-0" placeholder="500" required min="1" step="1" pattern="[0-9]+" title="Amount should only contain digits">
                    </div>
                </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Message (Optional)</label>
                                <textarea name="message" class="form-control rounded-3" rows="3" placeholder="A brief message..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-lg w-100 rounded-pill shadow-sm">Donate Now</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="h-100 d-flex flex-column justify-content-center">
                        <h2 class="fw-bold text-primary mb-4">Every Rupee Counts</h2>
                        <p class="mb-4">Saksham Bharti Foundation is registered under the Registration of Societies Act. We maintain full transparency in our financial records, which are audited annually.</p>
                        
                        <div class="bg-light p-4 rounded-4 mb-4 border-start border-4 border-primary">
                            <h5 class="fw-bold mb-2">Scholarship Impact</h5>
                            <p class="small text-muted mb-0">₹2,000 can support the basic vocational training of one student for a month.</p>
                        </div>
                        
                        <div class="bg-light p-4 rounded-4 mb-4 border-start border-4 border-secondary">
                            <h5 class="fw-bold mb-2">Skill Kits</h5>
                            <p class="small text-muted mb-0">₹5,000 can provide stitching kits or beauty kits to 5 trainees to help them start their own small businesses.</p>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-muted small">Looking to contribute in other ways? <a href="volunteer.php" class="fw-bold text-primary">Become a Volunteer</a> instead.</p>
                        </div>
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



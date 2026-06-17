<?php
// scholarship.php
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash_message('error', 'Invalid security token.');
        header("Location: scholarship.php");
        exit;
    }

    if (!check_rate_limit('scholarship', 3, 60)) {
        set_flash_message('error', 'Too many requests. Please wait a minute before trying again.');
        header("Location: scholarship.php");
        exit;
    }

    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');

    if (empty($name) || empty($email) || empty($phone)) {
        set_flash_message('error', 'All fields are required.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash_message('error', 'Invalid email format.');
    } else {
        $message = "Scholarship Inquiry (2026-27)\nPhone: $phone";
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            
            // Send email notification to admin
            $subject = "New Scholarship Inquiry from $name";
            $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Phone:</strong> $phone<br><strong>Message:</strong><br>" . nl2br($message);
            send_notification_email($subject, $body);

            // Send confirmation to user
            $user_subject = "Scholarship Inquiry Received - Saksham Bharti";
            $user_body = "<p>Thank you for your interest in the Uthaan Scholarship Program. We have received your details and will notify you when the application cycle begins.</p>
                          <p><strong>Your Details:</strong><br>Name: $name<br>Phone: $phone</p>";
            send_user_email($email, $name, $user_subject, $user_body);

            set_flash_message('success', 'Your interest has been registered successfully! We will notify you.');
        } catch (PDOException $e) {
            set_flash_message('error', 'Error submitting your request.');
        }
    }
    header("Location: scholarship.php");
    exit;
}

$page_title       = 'Scholarship Program | Saksham Bharti';
$page_description = 'Learn about Saksham Bharti\'s Uthaan Scholarship Program supporting the higher education and training of underprivileged students.';
require_once 'includes/header.php';
$csrf_token = generate_csrf_token();
$error = get_flash_message('error');
$success = get_flash_message('success');
?>

<section class="page-hero position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #0a1128 0%, #1f327f 100%);">
    <!-- Abstract background shapes -->
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0; opacity: 0.1;">
        <div class="position-absolute rounded-circle bg-white" style="width: 400px; height: 400px; top: -100px; right: -50px; filter: blur(50px);"></div>
        <div class="position-absolute rounded-circle" style="background-color: var(--accent-color); width: 300px; height: 300px; bottom: -50px; left: -100px; filter: blur(60px);"></div>
    </div>
    
    <div class="container text-center py-5 position-relative" style="z-index: 1;">
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill mb-4 border border-white border-opacity-25" style="backdrop-filter: blur(10px);">
            <i class="fas fa-graduation-cap text-warning me-2"></i>
            <span class="small fw-semibold letter-spacing-1">UTHAAN SCHOLARSHIP PROGRAM</span>
        </div>
        <h1 class="display-3 fw-bolder mb-3 text-white">Empowering Academic Excellence</h1>
        <p class="lead max-w-2xl mx-auto text-light opacity-75 fw-light" style="max-width: 800px;">At Saksham Bharti, we believe that financial constraints should never be a barrier to academic excellence. The Uthaan Scholarship Program is here to support bright and deserving students who aspire to pursue higher education.</p>
    </div>
</section>

<!-- Introduction Section -->
<section class="py-5 mt-n5 position-relative" style="z-index: 2;">
    <div class="container">
        <div class="row align-items-center g-5 py-4 bg-white shadow-lg rounded-4 p-4 p-md-5">
            <div class="col-lg-6">
                <h6 class="text-secondary fw-bold text-uppercase tracking-wider mb-2">Welcome Applicants</h6>
                <h2 class="fw-bold text-primary mb-4">Empowering Your Educational Journey</h2>
                <p class="text-muted lead">The Scholarship Distribution Program is designed exclusively for deserving trainees and students who aspire to pursue higher education but face financial hurdles.</p>
                <p class="text-muted">If you have the dedication to succeed, we want to help you reach your goals. Scholarships are awarded strictly on a <strong>need-cum-merit basis</strong>, ensuring that financial constraints do not stand in the way of your career.</p>
                
                <div class="d-flex align-items-center mt-4 p-3 bg-light rounded-3 border-start border-4 border-primary">
                    <i class="fas fa-shield-alt fa-2x text-primary me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Direct Bank Transfer</h6>
                        <p class="small text-muted mb-0">If selected, your scholarship amount will be disbursed directly to your verified bank account to pay for your admission or tuition fees.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative rounded-4 overflow-hidden shadow-sm">
                    <img src="assets/images/about_who_we_are.png" alt="Students studying" class="img-fluid w-100" style="object-fit: cover; height: 400px;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                        <h5 class="text-white fw-bold mb-0">Apply to Build Your Future</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Eligibility & Evaluation Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-secondary fw-bold text-uppercase">Criteria</h6>
            <h2 class="fw-bold text-primary">Eligibility & Evaluation</h2>
            <p class="text-muted max-w-2xl mx-auto">We look beyond just grades. Our selection panel evaluates students based on a holistic framework.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-elevate">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-book-reader fa-xl"></i>
                    </div>
                    <h5 class="fw-bold">Academic Excellence</h5>
                    <p class="text-muted small">Candidates must demonstrate a strong academic record and a clear commitment to their chosen field of higher education or vocational training.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-elevate">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-wallet fa-xl"></i>
                    </div>
                    <h5 class="fw-bold">Financial Need</h5>
                    <p class="text-muted small">The program specifically targets individuals from marginalized communities who face genuine economic constraints in pursuing education.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-elevate">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-hands-helping fa-xl"></i>
                    </div>
                    <h5 class="fw-bold">Leadership & Social Impact</h5>
                    <p class="text-muted small">We value leadership potential and a demonstrable commitment to creating positive change within their local communities and society.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Selection Process Timeline -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-secondary fw-bold text-uppercase">How It Works</h6>
            <h2 class="fw-bold text-primary">The Selection Process</h2>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline position-relative ps-4 ps-md-0">
                    <!-- Vertical Line for Desktop -->
                    <div class="position-absolute top-0 start-50 translate-middle-x h-100 bg-light d-none d-md-block" style="width: 4px;"></div>
                    
                    <!-- Step 1 -->
                    <div class="row align-items-center mb-5 position-relative">
                        <div class="col-md-5 text-md-end mb-3 mb-md-0">
                            <h5 class="fw-bold text-primary">Application Submission</h5>
                            <p class="text-muted small mb-0">Students submit their applications along with academic records and proof of admission.</p>
                        </div>
                        <div class="col-md-2 text-center position-absolute start-0 start-md-50 translate-middle-x">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px; z-index: 2;">1</div>
                        </div>
                        <div class="col-md-5 ps-5 ps-md-3">
                            <div class="p-3 bg-light rounded-3 text-muted small"><i class="far fa-calendar-alt me-2"></i>Usually begins in May</div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="row align-items-center mb-5 position-relative">
                        <div class="col-md-5 text-md-end order-3 order-md-1 mb-3 mb-md-0 ps-5 ps-md-3">
                            <div class="p-3 bg-light rounded-3 text-muted small"><i class="fas fa-users-cog me-2"></i>Panel of educational experts</div>
                        </div>
                        <div class="col-md-2 text-center position-absolute start-0 start-md-50 translate-middle-x order-2">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px; z-index: 2;">2</div>
                        </div>
                        <div class="col-md-5 order-1 order-md-3">
                            <h5 class="fw-bold text-primary">Expert Panel Interviews</h5>
                            <p class="text-muted small mb-0">From June onwards, shortlisted candidates undergo in-depth interactions with our expert panel to share aspirations and showcase skills.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="row align-items-center position-relative">
                        <div class="col-md-5 text-md-end mb-3 mb-md-0">
                            <h5 class="fw-bold text-primary">Verification & Disbursement</h5>
                            <p class="text-muted small mb-0">Upon admission confirmation, the scholarship amount is transferred directly to the student's bank account.</p>
                        </div>
                        <div class="col-md-2 text-center position-absolute start-0 start-md-50 translate-middle-x">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px; z-index: 2;">3</div>
                        </div>
                        <div class="col-md-5 ps-5 ps-md-3">
                            <div class="p-3 bg-light rounded-3 text-muted small"><i class="fas fa-check-circle me-2"></i>Transparent DBT Process</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Required Documents Section -->
<section class="py-5 bg-primary text-white" style="background: linear-gradient(135deg, #1f327f 0%, #0a1128 100%);">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <h6 class="text-secondary fw-bold text-uppercase">Before You Apply</h6>
                <h2 class="fw-bold mb-4">Required Documents</h2>
                <p class="opacity-75 mb-4">Please keep the following documents ready when submitting your application. Applications with incomplete documentation will not be processed by the interview panel.</p>
                <div class="bg-white bg-opacity-10 rounded-3 p-3 border border-white border-opacity-25">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-warning fa-2x me-3"></i>
                        <p class="small mb-0">All documents must be clear, readable photocopies. Original documents will be checked during the final interview stage.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-4 rounded-4 h-100 border border-white border-opacity-10 transform-hover">
                            <i class="fas fa-id-card fa-2x text-secondary mb-3"></i>
                            <h6 class="fw-bold">Identity Proof</h6>
                            <p class="small opacity-75 mb-0">Aadhar Card or any valid government-issued ID proof.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-4 rounded-4 h-100 border border-white border-opacity-10 transform-hover">
                            <i class="fas fa-file-invoice-dollar fa-2x text-secondary mb-3"></i>
                            <h6 class="fw-bold">Income Proof</h6>
                            <p class="small opacity-75 mb-0">Valid Income Certificate or Salary Slip of parents/guardians to verify financial need.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-4 rounded-4 h-100 border border-white border-opacity-10 transform-hover">
                            <i class="fas fa-graduation-cap fa-2x text-secondary mb-3"></i>
                            <h6 class="fw-bold">Academic Records</h6>
                            <p class="small opacity-75 mb-0">Marksheets of previous examinations (10th, 12th, or last college semester).</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-4 rounded-4 h-100 border border-white border-opacity-10 transform-hover">
                            <i class="fas fa-university fa-2x text-secondary mb-3"></i>
                            <h6 class="fw-bold">Admission & Bank Details</h6>
                            <p class="small opacity-75 mb-0">Fee receipt/admission proof for the current course, and your personal bank account details (Passbook/Cancelled Cheque).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action / Inquiry Form -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5 bg-secondary text-white p-5 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-3">Apply for 2026-27</h3>
                            <p class="opacity-75 small mb-4">Leave your details to get notified when the new application cycle begins. We will share the application forms, eligibility criteria, and guidelines directly with you.</p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone-alt me-3 opacity-50"></i>
                                    <span class="small">+91 98765 43210</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope me-3 opacity-50"></i>
                                    <span class="small">scholarships@sakshambharti.org</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 p-5 bg-white">
                            <h4 class="fw-bold text-primary mb-4">Register Interest</h4>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                                    <?= htmlspecialchars($error) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($success): ?>
                                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <form action="scholarship.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Full Name</label>
                                    <input type="text" name="name" class="form-control form-control-sm bg-light border-0 shadow-none px-3 py-2" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-sm bg-light border-0 shadow-none px-3 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control form-control-sm bg-light border-0 shadow-none px-3 py-2" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">Notify Me</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .letter-spacing-1 { letter-spacing: 1px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .max-w-2xl { max-width: 42rem; }
    
    .transform-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transform-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    
    .hover-elevate {
        transition: all 0.3s ease;
    }
    .hover-elevate:hover {
        background-color: var(--primary-bg) !important;
        color: white !important;
    }
    .hover-elevate:hover .text-muted {
        color: rgba(255,255,255,0.7) !important;
    }
    .hover-elevate:hover h5 {
        color: var(--accent-color) !important;
    }
</style>

<?php require_once 'includes/footer.php'; ?>

<?php
// programs.php
$page_title       = 'Our Programs | Saksham Bharti';
$page_description = 'Explore Saksham Bharti\'s vocational training programs: IT & Computer Skills, Beauty Culture, Fashion & Dress Designing, Soft Skills, and the Uthaan Scholarship. Free training for youth aged 17-23.';
require_once __DIR__ . '/../backend/config/db.php';
require_once 'includes/header.php';

// Fetch dynamic programs
$programs = [];
try {
    $programs_stmt = $pdo->query("SELECT * FROM programs ORDER BY created_at ASC");
    if ($programs_stmt) {
        $programs = $programs_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "<div class='container my-5 alert alert-danger'><strong>Database Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<!-- Hero Section -->
<section class="position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #1f327f 0%, #0f1c4a 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index:0; opacity:0.15;">
        <div class="position-absolute rounded-circle bg-white" style="width:400px;height:400px;top:-100px;right:-60px;filter:blur(65px);"></div>
        <div class="position-absolute rounded-circle bg-white" style="width:280px;height:280px;bottom:-50px;left:-60px;filter:blur(55px);"></div>
    </div>
    <div class="container text-center py-5 position-relative" style="z-index:1;">
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill mb-4 border border-white border-opacity-25" style="backdrop-filter:blur(10px);">
            <i class="fas fa-graduation-cap me-2" style="color:#f4a020;"></i>
            <span class="small fw-semibold">SKILL DEVELOPMENT — FREE VOCATIONAL TRAINING</span>
        </div>
        <h1 class="display-3 fw-bolder mb-3 text-white">Our Programs</h1>
        <p class="lead text-light opacity-75 mx-auto" style="max-width:680px;">Industry-aligned vocational training in IT, Beauty Culture, Fashion Design, and Soft Skills — empowering youth aged 17–23 to build careers and transform lives.</p>
    </div>
</section>

<div class="container py-5 mt-4">

    <div class="row g-4">
        <?php foreach ($programs as $program): ?>
        <div class="col-md-6">
            <div class="card program-card border-0 shadow-sm h-100 rounded-4 overflow-hidden <?= empty($program['image']) ? 'bg-light' : '' ?>">
                <?php if (!empty($program['image'])): ?>
                <img src="<?= htmlspecialchars(resolve_image_path($program['image'], false)) ?>" class="card-img-top program-img object-fit-cover" alt="<?= htmlspecialchars($program['title']) ?>">
                <?php endif; ?>
                <div class="card-body p-4 p-lg-5">
                    <h3 class="card-title fw-bold text-primary mb-3">
                        <i class="<?= htmlspecialchars($program['icon'] ?? 'fas fa-star') ?> me-2"></i><?= htmlspecialchars($program['title']) ?>
                    </h3>
                    <p class="card-text text-muted mb-4"><?= nl2br(htmlspecialchars($program['description'])) ?></p>
                    
                    <?php if (!empty($program['features'])): ?>
                    <ul class="list-unstyled text-muted small">
                        <?php 
                        $features = explode("\n", trim($program['features']));
                        foreach ($features as $feature): 
                            if (trim($feature)):
                        ?>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i><?= htmlspecialchars(trim($feature)) ?></li>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <?php if (empty($programs)): ?>
        <div class="col-12 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm border">
                <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                <h3 class="fw-bold">Programs are being updated</h3>
                <p class="text-muted">Please check back later for our list of vocational training programs.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Uthaan Scholarship Program -->
    <div class="row mt-5 pt-4">
        <div class="col-12">
            <div class="p-5 bg-white border border-primary border-opacity-25 rounded-4 shadow-sm">
                <h2 class="fw-bold text-primary mb-3 text-center">Uthaan: A Scholarship Program</h2>
                <p class="text-muted text-center mb-4">Helping our trainees pursue higher education and overcome financial barriers.</p>
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h4 class="fw-bold mb-3">Supporting Bright Futures</h4>
                        <p>The Scholarship Distribution Program is designed to support deserving trainees who aspire for higher education. The initiative aims to recognize academic achievements and encourage students to continue their educational journey with confidence.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Awarded on need-cum-merit basis across all centers.</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Evaluation through interviews and academic records.</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Direct transfer of scholarship amounts to bank accounts.</li>
                        </ul>
                    </div>
                    <div class="col-md-5 text-center">
                        <div class="bg-light p-4 rounded-4 border-top border-5 border-success">
                            <h1 class="display-4 fw-bold text-success mb-0">345</h1>
                            <p class="text-uppercase fw-bold text-muted small">Students Selected (2024-25)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Community Outreach & Additional Activities -->
    <div class="row mt-5 g-4">
        <div class="col-lg-6">
            <div class="p-4 h-100 bg-light rounded-4 border">
                <h3 class="fw-bold text-primary mb-4"><i class="fas fa-bullhorn me-2"></i>Community Outreach</h3>
                <div class="mb-3">
                    <h6 class="fw-bold text-secondary mb-1">Annual Drawing Competitions 2025</h6>
                    <p class="small text-muted">Engaging students from schools, NGOs, and colleges to showcase artistic talent.</p>
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold text-secondary mb-1">Bridal Makeup Inter-center Competition</h6>
                    <p class="small text-muted">Platform for trainees to showcase professional skills in bridal artistry.</p>
                </div>
                <div>
                    <h6 class="fw-bold text-secondary mb-1">Ulaas: Summer Camps</h6>
                    <p class="small text-muted">A hub of fun and learning for 450+ children across all centers.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="p-4 h-100 bg-light rounded-4 border">
                <h3 class="fw-bold text-primary mb-4"><i class="fas fa-plus-circle me-2"></i>Additional Activities</h3>
                <div class="mb-3">
                    <h6 class="fw-bold text-secondary mb-1">On-Job-Training (OJT)</h6>
                    <p class="small text-muted">Focusing on Class 12 students to strengthen foundation-level skills in Computer, Beauty, and Stitching.</p>
                </div>
                <div>
                    <h6 class="fw-bold text-secondary mb-1">Guest Lectures</h6>
                    <p class="small text-muted">Industry exposure through practical insights from experts in Retail, IT, and Fashion.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Annual Report Section -->
<div class="container py-5 mb-5 border-top pt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Annual Report</h2>
        <p class="lead text-muted">Transparency and accountability are our core values.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <div class="card border-0 shadow-lg rounded-4 p-5 text-center bg-light border-top border-5 border-primary">
                <i class="fas fa-file-pdf display-1 text-danger mb-4"></i>
                <h3 class="fw-bold mb-3">Saksham Bharti Annual Report 2024-25</h3>
                <p class="text-muted mb-4 px-md-5">Read about our achievements, financial statements, and the progress we've made towards our goals over the past year.</p>
                <a href="assets/reports/Saksham_Bharti_Annual_Report_2024-25.pdf" target="_blank" class="btn btn-primary rounded-pill px-4 me-2"><i class="fas fa-eye me-2"></i> View Report</a>
                <a href="assets/reports/Saksham_Bharti_Annual_Report_2024-25.pdf" download class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-download me-2"></i> Download PDF</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<?php
// annual-report.php
$page_title       = 'Annual Reports | Saksham Bharti';
$page_description = 'Access and download official annual reports of Saksham Bharti, detailing our financials, operations, and social impact.';
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
            <i class="fas fa-file-pdf me-2" style="color:#f4a020;"></i>
            <span class="small fw-semibold">TRANSPARENCY &amp; ACCOUNTABILITY — 2024-25</span>
        </div>
        <h1 class="display-3 fw-bolder mb-3 text-white">Annual Reports</h1>
        <p class="lead text-light opacity-75 mx-auto" style="max-width:680px;">Maintaining transparency, accountability, and governance excellence through annual financial and impact reporting.</p>
    </div>
</section>

<!-- Content Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Current Annual Report Card -->
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white mb-5">
                    <div class="text-danger mb-4">
                        <i class="fas fa-file-pdf fa-5x"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-3">Annual Report 2024-25</h2>
                    <p class="text-muted mb-4 px-md-5">Read about our Silver Jubilee milestones, student placement summaries, volunteer network metrics, and audited balance sheets for the 2024-25 financial year.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="assets/reports/Saksham_Bharti_Annual_Report_2024-25.pdf" target="_blank" class="btn btn-primary rounded-pill px-4"><i class="fas fa-eye me-2"></i> View Report</a>
                        <a href="assets/reports/Saksham_Bharti_Annual_Report_2024-25.pdf" download class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-download me-2"></i> Download PDF</a>
                    </div>
                </div>

                <!-- Past Reports Archives Placeholder -->
                <div class="p-5 bg-white rounded-4 shadow-sm border border-light text-center">
                    <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-archive fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-primary mb-2">Previous Reports Archive</h4>
                    <p class="text-muted small mb-0">Archives of annual reports for preceding years (2020-2023) are currently being digitized and will be published here soon.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<?php
// annual-report.php
$page_title       = 'Annual Reports | Saksham Bharti';
$page_description = 'Access and download official annual reports of Saksham Bharti, detailing our financials, operations, and social impact.';
require_once 'includes/header.php';
?>

<!-- Hero Header Section -->
<section class="page-hero bg-primary text-white py-5" style="background: linear-gradient(135deg, #1f327f 0%, #0f1c4a 100%);">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold mb-3">Annual Reports</h1>
        <p class="lead max-w-2xl mx-auto opacity-75">Maintaining transparency, accountability, and governance excellence through annual financial and impact reporting.</p>
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

<?php
// blog-single.php
require_once __DIR__ . '/../backend/config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: blog.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header("Location: blog.php");
    exit;
}

$page_title = htmlspecialchars($blog['title']) . " - Saksham Bharti Blog";
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero bg-primary text-white py-5" style="background-color: var(--primary-color);">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold"><?= htmlspecialchars($blog['title']) ?></h1>
        <p class="lead"><i class="fas fa-calendar-alt me-2 text-secondary"></i> Published on <?= date('F j, Y', strtotime($blog['created_at'])) ?></p>
    </div>
</section>

<!-- Blog Content -->
<section class="py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                    <img src="../<?= htmlspecialchars($blog['image']) ?>" class="img-fluid w-100" alt="<?= htmlspecialchars($blog['title']) ?>" onerror="this.src='https://via.placeholder.com/1200x600?text=Blog+Image'">
                </div>

                <div class="blog-content fs-5" style="line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($blog['description'])) ?>
                </div>

                <hr class="my-5">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="blog.php" class="btn btn-outline-primary fw-bold rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i> Back to Blog</a>

                    <div>
                        <span class="fw-bold me-3">Share:</span>
                        <a href="https://www.facebook.com/ngosakshambharti/" target="_blank" class="btn btn-light btn-sm rounded-circle me-1" style="width: 35px; height: 35px; line-height: 22px;"><i class="fab fa-facebook-f text-primary"></i></a>
                        <a href="https://x.com/bhartisaksham" target="_blank" class="btn btn-light btn-sm rounded-circle me-1" style="width: 35px; height: 35px; line-height: 22px;"><i class="fab fa-twitter text-primary"></i></a>
                        <a href="https://in.linkedin.com/in/sakshambharti" target="_blank" class="btn btn-light btn-sm rounded-circle" style="width: 35px; height: 35px; line-height: 22px;"><i class="fab fa-linkedin-in text-primary"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
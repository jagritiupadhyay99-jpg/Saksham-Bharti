<?php
// blog.php
$page_title       = 'Blog & News | Saksham Bharti';
$page_description = 'Read the latest blog posts, news, and impact stories from Saksham Bharti. Stay updated on our programs, events, student success stories, and community initiatives.';
require_once 'includes/header.php';

// Fetch all blog posts from the activities table
$stmt = $pdo->query("SELECT * FROM activities ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<section class="page-hero bg-primary text-white py-5" style="background-color: var(--primary-color);">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Our Blog & Activities</h1>
        <p class="lead">Stay updated with the latest news, events, and impact stories from Saksham Bharti.</p>
    </div>
</section>

<!-- Blog Listing -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift overflow-hidden">
                        <div class="overflow-hidden">
                            <img src="../<?= htmlspecialchars($blog['image']) ?>" class="card-img-top rounded-top-4 blog-card-img" alt="<?= htmlspecialchars($blog['title']) ?>" onerror="this.src='https://via.placeholder.com/600x400?text=Blog+Image'">
                        </div>
                        <div class="card-body p-4">
                            <span class="text-secondary fw-bold small mb-2 d-block"><i class="fas fa-calendar-alt me-1"></i> <?= date('F j, Y', strtotime($blog['created_at'])) ?></span>
                            <h4 class="card-title fw-bold mb-3"><?= htmlspecialchars($blog['title']) ?></h4>
                            <p class="card-text text-muted">
                                <?= htmlspecialchars(mb_strimwidth($blog['description'], 0, 120, "...")) ?>
                            </p>
                            <a href="blog-single.php?id=<?= $blog['id'] ?>" class="btn btn-outline-primary fw-bold rounded-pill px-4 mt-auto">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($blogs)): ?>
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-4 shadow-sm">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h3 class="fw-bold">No posts available yet</h3>
                        <p class="text-muted">Check back later for exciting updates and stories.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-lift:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(0,0,0,.15)!important; border-bottom: 4px solid var(--secondary-color)!important; }
.blog-card-img {
    height: 250px;
    width: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.hover-lift:hover .blog-card-img {
    transform: scale(1.1);
}
</style>

<?php require_once 'includes/footer.php'; ?>

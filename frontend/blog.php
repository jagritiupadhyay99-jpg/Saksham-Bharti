<?php
// blog.php
$page_title       = 'Blog & News | Saksham Bharti';
$page_description = 'Read the latest blog posts, news, and impact stories from Saksham Bharti. Stay updated on our programs, events, student success stories, and community initiatives.';
require_once 'includes/header.php';

// Fetch all blog posts from the blogs table
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug: Log database fetch confirmation to browser console
echo "<script>console.log('Database connection OK. Fetched " . count($blogs) . " blog posts from the database:', " . json_encode($blogs) . ");</script>";
?>

<!-- Hero Section -->
<section class="position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #1f327f 0%, #0f1c4a 100%);">
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index:0; opacity:0.15;">
        <div class="position-absolute rounded-circle bg-white" style="width:400px;height:400px;top:-100px;right:-60px;filter:blur(65px);"></div>
        <div class="position-absolute rounded-circle bg-white" style="width:280px;height:280px;bottom:-50px;left:-60px;filter:blur(55px);"></div>
    </div>
    <div class="container text-center py-5 position-relative" style="z-index:1;">
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill mb-4 border border-white border-opacity-25" style="backdrop-filter:blur(10px);">
            <i class="fas fa-newspaper me-2" style="color:#f4a020;"></i>
            <span class="small fw-semibold">NEWS, EVENTS & IMPACT STORIES</span>
        </div>
        <h1 class="display-3 fw-bolder mb-3 text-white">Our Blog & Activities</h1>
        <p class="lead text-light opacity-75 mx-auto" style="max-width:680px;">Stay updated with the latest news, events, and impact stories from Saksham Bharti.</p>
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
                            <img src="<?= htmlspecialchars(resolve_image_path($blog['image'], false)) ?>" class="card-img-top rounded-top-4 blog-card-img" alt="<?= htmlspecialchars($blog['title']) ?>" onerror="this.src='https://via.placeholder.com/600x400?text=Blog+Image'">
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

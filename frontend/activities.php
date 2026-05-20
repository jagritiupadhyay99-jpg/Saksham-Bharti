<?php
// activity.php
$page_title       = 'Activities & Events | Saksham Bharti Foundation';
$page_description = 'Explore the latest activities, events, and community initiatives by Saksham Bharti Foundation — from job fairs and competitions to summer camps and green drives across New Delhi.';
require_once 'includes/header.php';

// Fetch all activities
$stmt = $pdo->query("SELECT * FROM activities ORDER BY created_at DESC");
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<section class="page-hero bg-primary text-white py-5" style="background-color: var(--primary-color);">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Our Activity</h1>
        <p class="lead">Stay updated with the latest news, events, and impact stories from Saksham Bharti.</p>
    </div>
</section>

<!-- Activity Listing -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4">
            <?php foreach ($activities as $activity): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift overflow-hidden">
                        <div class="overflow-hidden">
                            <img src="../<?= htmlspecialchars($activity['image']) ?>" class="card-img-top rounded-top-4 activity-card-img" alt="<?= htmlspecialchars($activity['title']) ?>" onerror="this.src='https://via.placeholder.com/600x400?text=Activity+Image'">
                        </div>
                        <div class="card-body p-4">
                            <span class="text-secondary fw-bold small mb-2 d-block"><i class="fas fa-calendar-alt me-1"></i> <?= date('F j, Y', strtotime($activity['created_at'])) ?></span>
                            <h4 class="card-title fw-bold mb-3"><?= htmlspecialchars($activity['title']) ?></h4>
                            <p class="card-text text-muted">
                                <?= htmlspecialchars(mb_strimwidth($activity['description'], 0, 120, "...")) ?>
                            </p>
                            <a href="activity-single.php?id=<?= $activity['id'] ?>" class="btn btn-outline-primary fw-bold rounded-pill px-4 mt-auto">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($activities)): ?>
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
.activity-card-img {
    height: 250px;
    width: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.hover-lift:hover .activity-card-img {
    transform: scale(1.1);
}
</style>

<?php require_once 'includes/footer.php'; ?>

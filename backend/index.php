<?php
// admin/index.php
require_once 'config/db.php';
require_once 'includes/header.php';

// Fetch counts
$donations_count    = $pdo->query("SELECT COUNT(*) FROM donations")->fetchColumn();
$volunteers_count   = $pdo->query("SELECT COUNT(*) FROM volunteers")->fetchColumn();
$contacts_count     = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$unread_count       = $pdo->query("SELECT COUNT(*) FROM contacts WHERE read_status = 0")->fetchColumn();
$blogs_count        = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
$activities_count   = $pdo->query("SELECT COUNT(*) FROM activities")->fetchColumn();
$programs_count     = $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn();

// Fetch latest data
$recent_donations  = $pdo->query("SELECT * FROM donations ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recent_volunteers = $pdo->query("SELECT * FROM volunteers ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary">Dashboard Overview</h2>
    <span class="text-muted">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></span>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <a href="donations.php" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center border-top border-4 border-primary hover-lift">
                <div class="mb-3"><i class="fas fa-hand-holding-heart fa-3x text-primary opacity-25"></i></div>
                <h1 class="display-4 fw-bold text-primary"><?= $donations_count ?></h1>
                <p class="text-muted text-uppercase fw-bold mb-0">Total Donations</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="volunteers.php" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center border-top border-4 border-success hover-lift">
                <div class="mb-3"><i class="fas fa-users fa-3x text-success opacity-25"></i></div>
                <h1 class="display-4 fw-bold text-success"><?= $volunteers_count ?></h1>
                <p class="text-muted text-uppercase fw-bold mb-0">Registered Volunteers</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="contacts.php" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center border-top border-4 border-warning hover-lift position-relative">
                <?php if ($unread_count > 0): ?>
                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="margin-top:12px;margin-right:12px;"><?= $unread_count ?> New</span>
                <?php endif; ?>
                <div class="mb-3"><i class="fas fa-envelope fa-3x text-warning opacity-25"></i></div>
                <h1 class="display-4 fw-bold text-warning"><?= $contacts_count ?></h1>
                <p class="text-muted text-uppercase fw-bold mb-0">Contact Messages</p>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="blogs.php" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center border-top border-4 border-info hover-lift">
                <div class="mb-3"><i class="fas fa-blog fa-3x text-info opacity-25"></i></div>
                <h1 class="display-4 fw-bold text-info"><?= $blogs_count ?></h1>
                <p class="text-muted text-uppercase fw-bold mb-0">Blog Posts</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="activities.php" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center border-top border-4 border-secondary hover-lift">
                <div class="mb-3"><i class="fas fa-calendar-alt fa-3x text-secondary opacity-25"></i></div>
                <h1 class="display-4 fw-bold text-secondary"><?= $activities_count ?></h1>
                <p class="text-muted text-uppercase fw-bold mb-0">Activities</p>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="programs.php" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center border-top border-4 border-primary hover-lift">
                <div class="mb-3"><i class="fas fa-graduation-cap fa-3x text-primary opacity-25"></i></div>
                <h1 class="display-4 fw-bold text-primary"><?= $programs_count ?></h1>
                <p class="text-muted text-uppercase fw-bold mb-0">Programs</p>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold">Recent Donations</h5>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_donations as $d): ?>
                            <tr>
                                <td><?= htmlspecialchars($d['name']) ?></td>
                                <td class="fw-bold text-success">₹<?= number_format($d['amount'], 2) ?></td>
                                <td><?= date('M d, Y', strtotime($d['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recent_donations)): ?>
                            <tr><td colspan="3" class="text-center text-muted">No donations yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold">Recent Volunteers</h5>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Interest</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_volunteers as $v): ?>
                            <tr>
                                <td><?= htmlspecialchars($v['name']) ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($v['interest']) ?></span></td>
                                <td><?= date('M d, Y', strtotime($v['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recent_volunteers)): ?>
                            <tr><td colspan="3" class="text-center text-muted">No volunteers yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

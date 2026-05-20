<?php
// admin/donations.php
require_once 'config/db.php';
require_once 'includes/header.php';

// ── Search + Pagination ─────────────────────────────────────
$search   = trim($_GET['search'] ?? '');
$page     = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset   = ($page - 1) * $per_page;

$where_clauses = [];
$params        = [];

if ($search !== '') {
    $where_clauses[] = "(name LIKE ? OR email LIKE ?)";
    $like = '%' . $search . '%';
    $params = array_merge($params, [$like, $like]);
}

$where_sql = $where_clauses ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM donations $where_sql");
$count_stmt->execute($params);
$total       = (int)$count_stmt->fetchColumn();
$total_pages = max(1, ceil($total / $per_page));
$page        = min($page, $total_pages);

// Total donation amount (filtered)
$sum_stmt = $pdo->prepare("SELECT COALESCE(SUM(amount), 0) FROM donations $where_sql");
$sum_stmt->execute($params);
$total_amount = (float)$sum_stmt->fetchColumn();

$data_stmt = $pdo->prepare("SELECT * FROM donations $where_sql ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
$data_stmt->execute($params);
$donations = $data_stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold text-primary mb-0">Donation Management</h2>
        <small class="text-muted">Total collected: <strong class="text-success">₹<?= number_format($total_amount, 2) ?></strong></small>
    </div>
    <span class="badge bg-primary px-3 py-2 rounded-pill">Records: <?= $total ?></span>
</div>

<!-- Search Bar -->
<form method="GET" class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                           placeholder="Search by donor name or email..." value="<?= htmlspecialchars($search) ?>">
                </div>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                <a href="donations.php" class="btn btn-outline-secondary rounded-pill">Reset</a>
            </div>
        </div>
    </div>
</form>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Donor Name</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Message</th>
                        <th class="pe-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donations as $i => $d): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $offset + $i + 1 ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($d['name']) ?></td>
                        <td><a href="mailto:<?= htmlspecialchars($d['email']) ?>" class="text-decoration-none text-muted small"><?= htmlspecialchars($d['email']) ?></a></td>
                        <td><span class="fw-bold text-success fs-6">₹<?= number_format($d['amount'], 2) ?></span></td>
                        <td><small class="text-muted"><?= htmlspecialchars($d['message'] ?? '—') ?></small></td>
                        <td class="pe-4 text-muted small"><?= date('M d, Y', strtotime($d['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($donations)): ?>
                    <tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-hand-holding-heart fa-3x mb-3 d-block opacity-25"></i>No donations found.
                    </td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<nav class="mt-4 d-flex justify-content-center">
    <ul class="pagination pagination-sm">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link rounded-start-pill" href="donations.php?<?= http_build_query(array_filter(['search'=>$search,'page'=>$page-1])) ?>">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
            <a class="page-link" href="donations.php?<?= http_build_query(array_filter(['search'=>$search,'page'=>$p])) ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
            <a class="page-link rounded-end-pill" href="donations.php?<?= http_build_query(array_filter(['search'=>$search,'page'=>$page+1])) ?>">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
<p class="text-center text-muted small">Showing page <?= $page ?> of <?= $total_pages ?> (<?= $total ?> total records)</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>

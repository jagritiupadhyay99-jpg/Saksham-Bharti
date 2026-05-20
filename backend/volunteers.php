<?php
// admin/volunteers.php
require_once 'config/db.php';
require_once 'includes/header.php';

// ── Search + Pagination ─────────────────────────────────────
$search   = trim($_GET['search'] ?? '');
$interest = trim($_GET['interest'] ?? '');
$page     = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset   = ($page - 1) * $per_page;

$where_clauses = [];
$params        = [];

if ($search !== '') {
    $where_clauses[] = "(name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $like = '%' . $search . '%';
    $params = array_merge($params, [$like, $like, $like]);
}
if ($interest !== '') {
    $where_clauses[] = "interest = ?";
    $params[] = $interest;
}

$where_sql = $where_clauses ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM volunteers $where_sql");
$count_stmt->execute($params);
$total       = (int)$count_stmt->fetchColumn();
$total_pages = max(1, ceil($total / $per_page));
$page        = min($page, $total_pages);

$data_stmt = $pdo->prepare("SELECT * FROM volunteers $where_sql ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
$data_stmt->execute($params);
$volunteers = $data_stmt->fetchAll();

// Fetch unique interests for filter dropdown
$interests = $pdo->query("SELECT DISTINCT interest FROM volunteers ORDER BY interest")->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="fw-bold text-primary mb-0">Volunteer Network</h2>
    <span class="badge bg-success px-3 py-2 rounded-pill">Total: <?= $total ?></span>
</div>

<!-- Search + Filter Bar -->
<form method="GET" class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                           placeholder="Search by name, email or phone..." value="<?= htmlspecialchars($search) ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="interest" class="form-select">
                    <option value="">All Interests</option>
                    <?php foreach ($interests as $int): ?>
                    <option value="<?= htmlspecialchars($int) ?>" <?= $interest === $int ? 'selected' : '' ?>>
                        <?= htmlspecialchars($int) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Filter</button>
                <a href="volunteers.php" class="btn btn-outline-secondary rounded-pill">Reset</a>
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
                        <th>Volunteer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Interest</th>
                        <th class="pe-4">Signed Up</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($volunteers as $i => $v): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $offset + $i + 1 ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($v['name']) ?></td>
                        <td><a href="mailto:<?= htmlspecialchars($v['email']) ?>" class="text-decoration-none text-muted small"><?= htmlspecialchars($v['email']) ?></a></td>
                        <td class="small"><?= htmlspecialchars($v['phone']) ?></td>
                        <td><span class="badge bg-light text-primary border border-primary"><?= htmlspecialchars($v['interest']) ?></span></td>
                        <td class="pe-4 text-muted small"><?= date('M d, Y', strtotime($v['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($volunteers)): ?>
                    <tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-3x mb-3 d-block opacity-25"></i>No volunteers found.
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
            <a class="page-link rounded-start-pill" href="volunteers.php?<?= http_build_query(array_filter(['search'=>$search,'interest'=>$interest,'page'=>$page-1])) ?>">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
            <a class="page-link" href="volunteers.php?<?= http_build_query(array_filter(['search'=>$search,'interest'=>$interest,'page'=>$p])) ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
            <a class="page-link rounded-end-pill" href="volunteers.php?<?= http_build_query(array_filter(['search'=>$search,'interest'=>$interest,'page'=>$page+1])) ?>">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
<p class="text-center text-muted small">Showing page <?= $page ?> of <?= $total_pages ?> (<?= $total ?> total volunteers)</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>

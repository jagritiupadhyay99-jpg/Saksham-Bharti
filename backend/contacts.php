<?php
// admin/contacts.php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// ── Toggle Read/Unread ──────────────────────────────────────
if (isset($_GET['toggle_read'])) {
    $id = (int)$_GET['toggle_read'];
    $stmt = $pdo->prepare("SELECT read_status FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    $current = $stmt->fetchColumn();
    $new_status = $current ? 0 : 1;
    $pdo->prepare("UPDATE contacts SET read_status = ? WHERE id = ?")->execute([$new_status, $id]);
    // Preserve query params on redirect
    $redirect = 'contacts.php';
    $params = array_intersect_key($_GET, array_flip(['search', 'page', 'filter']));
    unset($params['toggle_read']);
    if ($params) $redirect .= '?' . http_build_query($params);
    header("Location: $redirect");
    exit;
}

// ── Delete ──────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM contacts WHERE id = ?")->execute([$id]);
    header("Location: contacts.php");
    exit;
}

// ── Search + Filter + Pagination ────────────────────────────
$search  = trim($_GET['search'] ?? '');
$filter  = $_GET['filter']  ?? 'all'; // all | unread | read
$page    = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset  = ($page - 1) * $per_page;

$where_clauses = [];
$params        = [];

if ($search !== '') {
    $where_clauses[] = "(name LIKE ? OR email LIKE ? OR message LIKE ?)";
    $like = '%' . $search . '%';
    $params = array_merge($params, [$like, $like, $like]);
}
if ($filter === 'unread') {
    $where_clauses[] = "read_status = 0";
} elseif ($filter === 'read') {
    $where_clauses[] = "read_status = 1";
}

$where_sql = $where_clauses ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

// Total count for pagination
$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM contacts $where_sql");
$count_stmt->execute($params);
$total      = (int)$count_stmt->fetchColumn();
$total_pages = max(1, ceil($total / $per_page));
$page = min($page, $total_pages);

// Fetch messages for current page
$stmt = $pdo->prepare("SELECT * FROM contacts $where_sql ORDER BY read_status ASC, created_at DESC LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$messages = $stmt->fetchAll();

$unread_total = (int)$pdo->query("SELECT COUNT(*) FROM contacts WHERE read_status = 0")->fetchColumn();
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-primary mb-0">Inquiry Management</h2>
        <?php if ($unread_total > 0): ?>
        <span class="badge bg-danger rounded-pill mt-1"><?= $unread_total ?> unread</span>
        <?php endif; ?>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">Total: <?= $total ?></span>
    </div>
</div>

<!-- Search + Filter Bar -->
<form method="GET" class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by name, email or message..." value="<?= htmlspecialchars($search) ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="filter" class="form-select">
                    <option value="all"   <?= $filter === 'all'    ? 'selected' : '' ?>>All Messages</option>
                    <option value="unread"<?= $filter === 'unread' ? 'selected' : '' ?>>Unread Only</option>
                    <option value="read"  <?= $filter === 'read'   ? 'selected' : '' ?>>Read Only</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Filter</button>
                <a href="contacts.php" class="btn btn-outline-secondary rounded-pill">Reset</a>
            </div>
        </div>
    </div>
</form>

<!-- Messages Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="5%"></th>
                        <th>Sender</th>
                        <th>Email</th>
                        <th width="35%">Message</th>
                        <th>Received</th>
                        <th class="pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $m): ?>
                    <?php $is_read = (bool)$m['read_status']; ?>
                    <tr class="<?= $is_read ? 'table-light' : 'fw-semibold' ?>">
                        <td class="ps-4 text-center">
                            <?php if (!$is_read): ?>
                                <span class="badge bg-danger rounded-circle p-1" title="Unread" style="width:10px;height:10px;display:inline-block;"></span>
                            <?php else: ?>
                                <span class="badge bg-success rounded-circle p-1" title="Read" style="width:10px;height:10px;display:inline-block;opacity:0.4;"></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div><?= htmlspecialchars($m['name'] ?: 'Website Visitor') ?></div>
                        </td>
                        <td><a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="text-decoration-none text-muted small"><?= htmlspecialchars($m['email']) ?></a></td>
                        <td>
                            <div class="small text-muted" style="max-height:80px;overflow-y:auto;">
                                <?= nl2br(htmlspecialchars($m['message'])) ?>
                            </div>
                        </td>
                        <td class="text-muted small"><?= date('M d, Y', strtotime($m['created_at'])) ?></td>
                        <td class="pe-4">
                            <div class="btn-group btn-group-sm">
                                <?php
                                $back_params = http_build_query(array_filter(['search'=>$search,'filter'=>$filter,'page'=>$page]));
                                $back = $back_params ? "&$back_params" : '';
                                ?>
                                <a href="contacts.php?toggle_read=<?= $m['id'] . $back ?>"
                                   class="btn <?= $is_read ? 'btn-outline-secondary' : 'btn-outline-success' ?>"
                                   title="<?= $is_read ? 'Mark as Unread' : 'Mark as Read' ?>">
                                    <i class="fas <?= $is_read ? 'fa-envelope' : 'fa-envelope-open' ?>"></i>
                                </a>
                                <a href="contacts.php?delete=<?= $m['id'] ?>"
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('Delete this message permanently?')"
                                   title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($messages)): ?>
                    <tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>No messages found.
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
            <a class="page-link rounded-start-pill" href="contacts.php?<?= http_build_query(array_filter(['search'=>$search,'filter'=>$filter,'page'=>$page-1])) ?>">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
            <a class="page-link" href="contacts.php?<?= http_build_query(array_filter(['search'=>$search,'filter'=>$filter,'page'=>$p])) ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
            <a class="page-link rounded-end-pill" href="contacts.php?<?= http_build_query(array_filter(['search'=>$search,'filter'=>$filter,'page'=>$page+1])) ?>">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
<p class="text-center text-muted small">Showing page <?= $page ?> of <?= $total_pages ?> (<?= $total ?> total messages)</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>

<?php
// admin/programs.php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM programs WHERE id = ?");
    $stmt->execute([$id]);
    $program = $stmt->fetch();
    
    if ($program) {
        if ($program['image'] && file_exists('../' . $program['image'])) {
            unlink('../' . $program['image']);
        }
        $pdo->prepare("DELETE FROM programs WHERE id = ?")->execute([$id]);
        set_flash_message('success', 'Program deleted successfully!');
        header("Location: programs.php");
        exit;
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = sanitize_input($_POST['title'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
    $icon = sanitize_input($_POST['icon'] ?? 'fas fa-star');
    $features = sanitize_input($_POST['features'] ?? '');
    $image_path = $_POST['existing_image'] ?? '';

    // Handle File Upload
    $upload_error = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $file_mime = mime_content_type($_FILES['image']['tmp_name']);
        $file_size = $_FILES['image']['size'];

        if (!in_array($file_mime, $allowed_mimes)) {
            $upload_error = 'Invalid file type. Only JPG, PNG, and WEBP are allowed.';
        } elseif ($file_size > $max_size) {
            $upload_error = 'File size exceeds the 2MB limit.';
        } else {
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", basename($_FILES['image']['name']));
            $target_file = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Delete old image if exists
                if ($image_path && file_exists('../' . $image_path)) {
                    unlink('../' . $image_path);
                }
                $image_path = 'uploads/' . $filename;
            } else {
                $upload_error = 'Failed to move uploaded file.';
            }
        }
    }

    if ($upload_error) {
        set_flash_message('error', $upload_error);
    } elseif (empty($title) || empty($description) || empty($image_path)) {
        set_flash_message('error', 'Title, description, and image are required.');
    } else {
        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE programs SET title=?, description=?, icon=?, image=?, features=? WHERE id=?");
            $stmt->execute([$title, $description, $icon, $image_path, $features, $id]);
            set_flash_message('success', 'Program updated successfully!');
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO programs (title, description, icon, image, features) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $icon, $image_path, $features]);
            set_flash_message('success', 'Program created successfully!');
        }
        header("Location: programs.php");
        exit;
    }
}

$programs = $pdo->query("SELECT * FROM programs ORDER BY created_at DESC")->fetchAll();
$success = get_flash_message('success');
$error = get_flash_message('error');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary">Manage Programs</h2>
    <button class="btn btn-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#programModal">
        <i class="fas fa-plus me-2"></i> Add New Program
    </button>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?= $success ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?= $error ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="100">Image</th>
                        <th>Title</th>
                        <th>Icon</th>
                        <th>Date</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($programs as $p): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars(resolve_image_path($p['image'], true)) ?>" alt="Img" class="rounded" style="width: 80px; height: 60px; object-fit: cover;"></td>
                        <td><?= htmlspecialchars($p['title']) ?></td>
                        <td><i class="<?= htmlspecialchars($p['icon']) ?>"></i> <?= htmlspecialchars($p['icon']) ?></td>
                        <td><?= date('M d, Y', strtotime($p['created_at'])) ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary" onclick="editProgram(<?= htmlspecialchars(json_encode($p)) ?>)"><i class="fas fa-edit"></i></a>
                            <a href="programs.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this program?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($programs)): ?>
                    <tr><td colspan="5" class="text-center text-muted">No programs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="programModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Add New Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="prog_id">
                    <input type="hidden" name="existing_image" id="existing_image">
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" id="prog_title" class="form-control rounded-3" placeholder="e.g. Information Technology" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">FontAwesome Icon</label>
                            <input type="text" name="icon" id="prog_icon" class="form-control rounded-3" placeholder="e.g. fas fa-laptop-code" value="fas fa-star">
                            <div class="form-text"><a href="https://fontawesome.com/v5/search?m=free" target="_blank">Find icons here</a></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" id="prog_desc" class="form-control rounded-3" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Features (One per line)</label>
                        <textarea name="features" id="prog_features" class="form-control rounded-3" rows="4" placeholder="Certificate Course in Active Basic IT (CCAB)&#10;Certificate Course in Advance Word-Excel (CCAWE)"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Image (Leave blank to keep existing for edits)</label>
                        <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editProgram(data) {
    document.getElementById('modalTitle').innerText = 'Edit Program';
    document.getElementById('prog_id').value = data.id;
    document.getElementById('prog_title').value = data.title;
    document.getElementById('prog_desc').value = data.description;
    document.getElementById('prog_icon').value = data.icon;
    document.getElementById('prog_features').value = data.features;
    document.getElementById('existing_image').value = data.image;
    
    var myModal = new bootstrap.Modal(document.getElementById('programModal'));
    myModal.show();
}

// Reset form when modal is hidden
document.getElementById('programModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').innerText = 'Add New Program';
    document.getElementById('prog_id').value = '';
    document.getElementById('existing_image').value = '';
    this.querySelector('form').reset();
    document.getElementById('prog_icon').value = 'fas fa-star';
});
</script>

<?php require_once 'includes/footer.php'; ?>

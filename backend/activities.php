<?php
// admin/activities.php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM activities WHERE id = ?");
    $stmt->execute([$id]);
    $activity = $stmt->fetch();
    
    if ($activity) {
        if (file_exists('../' . $activity['image'])) {
            unlink('../' . $activity['image']);
        }
        $pdo->prepare("DELETE FROM activities WHERE id = ?")->execute([$id]);
        set_flash_message('success', 'Activity deleted successfully!');
        header("Location: activities.php");
        exit;
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = sanitize_input($_POST['title'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
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
        set_flash_message('error', 'All fields are required. Image is required for new activities.');
    } else {
        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE activities SET title=?, description=?, image=? WHERE id=?");
            $stmt->execute([$title, $description, $image_path, $id]);
            set_flash_message('success', 'Activity updated successfully!');
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO activities (title, description, image) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $image_path]);
            set_flash_message('success', 'Activity created successfully!');
        }
        header("Location: activities.php");
        exit;
    }
}

$activities = $pdo->query("SELECT * FROM activities ORDER BY created_at DESC")->fetchAll();
$success = get_flash_message('success');
$error = get_flash_message('error');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary">Manage Activities & Blogs</h2>
    <button class="btn btn-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#activityModal">
        <i class="fas fa-plus me-2"></i> Add New Activity
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
                        <th>Date</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activities as $a): ?>
                    <tr>
                        <td><img src="../<?= htmlspecialchars($a['image']) ?>" alt="Img" class="rounded" style="width: 80px; height: 60px; object-fit: cover;"></td>
                        <td><?= htmlspecialchars($a['title']) ?></td>
                        <td><?= date('M d, Y', strtotime($a['created_at'])) ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary" onclick="editActivity(<?= htmlspecialchars(json_encode($a)) ?>)"><i class="fas fa-edit"></i></a>
                            <a href="activities.php?delete=<?= $a['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($activities)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No activities found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="activityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Add New Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="act_id">
                    <input type="hidden" name="existing_image" id="existing_image">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" id="act_title" class="form-control rounded-3" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" id="act_desc" class="form-control rounded-3" rows="5" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Image (Leave blank to keep existing for edits)</label>
                        <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editActivity(data) {
    document.getElementById('modalTitle').innerText = 'Edit Activity';
    document.getElementById('act_id').value = data.id;
    document.getElementById('act_title').value = data.title;
    document.getElementById('act_desc').value = data.description;
    document.getElementById('existing_image').value = data.image;
    
    var myModal = new bootstrap.Modal(document.getElementById('activityModal'));
    myModal.show();
}

// Reset form when modal is hidden
document.getElementById('activityModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').innerText = 'Add New Activity';
    document.getElementById('act_id').value = '';
    document.getElementById('existing_image').value = '';
    this.querySelector('form').reset();
});
</script>

<?php require_once 'includes/footer.php'; ?>

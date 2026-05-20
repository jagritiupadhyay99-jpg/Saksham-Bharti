<?php
// admin/settings.php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_pass = $_POST['current_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if (!password_verify($current_pass, $admin['password'])) {
        $error = 'Current password is incorrect.';
    } elseif ($new_pass !== $confirm_pass) {
        $error = 'New passwords do not match.';
    } elseif (strlen($new_pass) < 6) {
        $error = 'New password must be at least 6 characters.';
    } else {
        $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_pass, $_SESSION['admin_id']]);
        $success = 'Password updated successfully!';
    }
}
?>

<div class="mb-4">
    <h2 class="fw-bold text-primary">Account Settings</h2>
    <p class="text-muted">Manage your administrative credentials.</p>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Change Password</h5>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control rounded-3" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control rounded-3" required>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Update Password</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 bg-primary text-white rounded-4 shadow-sm h-100">
            <div class="card-body p-5 d-flex flex-column justify-content-center">
                <i class="fas fa-shield-alt fa-4x mb-4 opacity-50"></i>
                <h3 class="fw-bold">Security Tip</h3>
                <p class="lead mb-0">Ensure you use a strong, unique password for the admin portal. Never share your credentials with unauthorized personnel.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

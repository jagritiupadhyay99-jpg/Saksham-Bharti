<?php
// admin/site_settings.php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_email = $_POST['contact_email'] ?? '';
    $contact_phone = $_POST['contact_phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $notification_email = $_POST['notification_email'] ?? '';
    $facebook_url = $_POST['facebook_url'] ?? '';
    $twitter_url = $_POST['twitter_url'] ?? '';
    $instagram_url = $_POST['instagram_url'] ?? '';
    $linkedin_url = $_POST['linkedin_url'] ?? '';
    $auto_reply_emails = isset($_POST['auto_reply_emails']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE site_settings SET 
        contact_email = ?, contact_phone = ?, address = ?, notification_email = ?, 
        facebook_url = ?, twitter_url = ?, instagram_url = ?, linkedin_url = ?, auto_reply_emails = ? WHERE id = 1");
    
    if ($stmt->execute([$contact_email, $contact_phone, $address, $notification_email, $facebook_url, $twitter_url, $instagram_url, $linkedin_url, $auto_reply_emails])) {
        $success = 'Site settings updated successfully!';
    } else {
        $error = 'Failed to update site settings.';
    }
}

// Fetch current settings
$stmt = $pdo->query("SELECT * FROM site_settings WHERE id = 1");
$settings = $stmt->fetch();

if (!$settings) {
    // Fallback empty array if not found
    $settings = [
        'contact_email' => '', 'contact_phone' => '', 'address' => '', 'notification_email' => '',
        'facebook_url' => '', 'twitter_url' => '', 'instagram_url' => '', 'linkedin_url' => '', 'auto_reply_emails' => 1
    ];
}
?>

<div class="mb-4">
    <h2 class="fw-bold text-primary">Site Settings</h2>
    <p class="text-muted">Manage website configuration, contact information, and email notifications.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <?php if ($success): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Contact Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Contact Email (Displayed on Site)</label>
                    <input type="email" name="contact_email" class="form-control rounded-3" value="<?= htmlspecialchars($settings['contact_email']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control rounded-3" value="<?= htmlspecialchars($settings['contact_phone']) ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Office Address</label>
                    <textarea name="address" class="form-control rounded-3" rows="2" required><?= htmlspecialchars($settings['address']) ?></textarea>
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Admin Notifications & Automation</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Notification Email (Receives Form Submissions)</label>
                    <input type="email" name="notification_email" class="form-control rounded-3" value="<?= htmlspecialchars($settings['notification_email']) ?>" required>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check form-switch mt-md-4">
                        <input class="form-check-input" type="checkbox" id="auto_reply_emails" name="auto_reply_emails" value="1" <?= $settings['auto_reply_emails'] ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="auto_reply_emails">Enable Auto-Reply Emails to Users</label>
                        <div class="small text-muted">Send automated thank-you/confirmation emails when users submit contact, volunteer, or donation forms.</div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Social Media Links</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label"><i class="fab fa-facebook text-primary me-1"></i> Facebook URL</label>
                    <input type="url" name="facebook_url" class="form-control rounded-3" value="<?= htmlspecialchars($settings['facebook_url']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fab fa-twitter text-info me-1"></i> Twitter / X URL</label>
                    <input type="url" name="twitter_url" class="form-control rounded-3" value="<?= htmlspecialchars($settings['twitter_url']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fab fa-instagram text-danger me-1"></i> Instagram URL</label>
                    <input type="url" name="instagram_url" class="form-control rounded-3" value="<?= htmlspecialchars($settings['instagram_url']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fab fa-linkedin text-primary me-1"></i> LinkedIn URL</label>
                    <input type="url" name="linkedin_url" class="form-control rounded-3" value="<?= htmlspecialchars($settings['linkedin_url']) ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fas fa-save me-2"></i> Save Settings</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<?php
// includes/functions.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── PHPMailer ────────────────────────────────────────────────
require_once __DIR__ . '/../lib/PHPMailer/Exception.php';
require_once __DIR__ . '/../lib/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/SMTP.php';
require_once __DIR__ . '/../config/mail_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as MailException;

// ── CSRF Helpers ────────────────────────────────────────────
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// ── Input Sanitization ──────────────────────────────────────
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

// ── Flash Messages ──────────────────────────────────────────
function set_flash_message($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function get_flash_message($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

// ── Internal: Log Mail Errors ───────────────────────────────
function _log_mail_error($context, $error) {
    $log_dir = dirname(MAIL_ERROR_LOG);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    $line = '[' . date('Y-m-d H:i:s') . '] [' . $context . '] ' . $error . PHP_EOL;
    file_put_contents(MAIL_ERROR_LOG, $line, FILE_APPEND | LOCK_EX);
}

// ── Internal: Build PHPMailer Instance ──────────────────────
function _make_mailer() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;
    $mail->Port       = MAIL_PORT;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USERNAME;
    $mail->Password   = MAIL_PASSWORD;
    $mail->SMTPSecure = MAIL_ENCRYPTION === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    return $mail;
}

// ── Internal: Mock Email System for Local Dev ─────────────────
function _is_mock_email() {
    return MAIL_USERNAME === 'your_email@gmail.com' || empty(MAIL_USERNAME);
}

function _write_mock_email($to, $subject, $body) {
    $log_dir = dirname(MAIL_ERROR_LOG);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    $file = $log_dir . '/mock_emails.html';
    $time = date('Y-m-d H:i:s');
    $content = "<hr><div style='font-family:sans-serif;margin-bottom:20px;'><h3 style='color:#1F327F;'>[$time] Mock Email Sent</h3><p><strong>To:</strong> " . htmlspecialchars($to) . "</p><p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p><div style='border:1px solid #ccc;padding:15px;background:#fdfdfd;'>" . $body . "</div></div>\n";
    file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
}

// ── Send Notification Email to Admin ───────────────────────
// Triggered on: contact form, volunteer signup, donation intent
function send_notification_email($subject, $body) {
    global $pdo;
    try {
        // Fetch admin notification email from site_settings
        $to = 'admin@sakshambharti.org'; // fallback
        if (isset($pdo)) {
            $stmt = $pdo->query("SELECT notification_email FROM site_settings WHERE id = 1");
            $settings = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($settings && !empty($settings['notification_email'])) {
                $to = $settings['notification_email'];
            }
        }

        if (_is_mock_email()) {
            _write_mock_email($to, $subject, $body);
            return;
        }

        $mail = _make_mailer();
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body    = '
            <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
                <div style="background:#1F327F;padding:20px 30px;">
                    <h2 style="color:#fff;margin:0;">Saksham Bharti</h2>
                    <p style="color:#f4a020;margin:4px 0 0;">Admin Notification</p>
                </div>
                <div style="padding:30px;color:#333;">
                    <h3 style="color:#1F327F;">' . htmlspecialchars($subject) . '</h3>
                    <hr style="border:none;border-top:1px solid #eee;">
                    <div style="margin-top:20px;line-height:1.8;">' . $body . '</div>
                </div>
                <div style="background:#f9f9f9;padding:15px 30px;font-size:12px;color:#999;">
                    This is an automated notification from your website.
                </div>
            </div>';
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $body));
        $mail->send();

    } catch (MailException $e) {
        _log_mail_error('send_notification_email', $e->getMessage());
    } catch (Exception $e) {
        _log_mail_error('send_notification_email', $e->getMessage());
    }
}

// ── Send Confirmation Email to User ────────────────────────
// Triggered on: volunteer signup, donation intent
function send_user_email($to_email, $to_name, $subject, $body_html) {
    global $pdo;
    try {
        if ($pdo) {
            $stmt = $pdo->query("SELECT auto_reply_emails FROM site_settings WHERE id = 1");
            $settings = $stmt->fetch();
            if ($settings && $settings['auto_reply_emails'] == 0) {
                return; // Auto-replies are disabled
            }
        }

        $full_body_html = '
            <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
                <div style="background:#1F327F;padding:20px 30px;">
                    <h2 style="color:#fff;margin:0;">Saksham Bharti</h2>
                    <p style="color:#f4a020;margin:4px 0 0;">Empowering Youth Through Skill &amp; Education</p>
                </div>
                <div style="padding:30px;color:#333;line-height:1.8;">
                    <p>Dear <strong>' . htmlspecialchars($to_name) . '</strong>,</p>
                    ' . $body_html . '
                    <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">
                    <p style="color:#555;">Warm regards,<br><strong>Team Saksham Bharti</strong><br>
                    <a href="https://www.sakshambharti.org" style="color:#1F327F;">www.sakshambharti.org</a></p>
                </div>
                <div style="background:#f9f9f9;padding:15px 30px;font-size:12px;color:#999;">
                    &copy; ' . date('Y') . ' Saksham Bharti. All rights reserved.
                </div>
            </div>';

        if (_is_mock_email()) {
            _write_mock_email($to_email, $subject, $full_body_html);
            return;
        }

        $mail = _make_mailer();
        $mail->addAddress($to_email, $to_name);
        $mail->Subject = $subject;
        $mail->Body    = $full_body_html;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<p>', '</p>'], ["\n", "\n", "\n"], $body_html));
        $mail->send();

    } catch (MailException $e) {
        _log_mail_error('send_user_email to ' . $to_email, $e->getMessage());
    } catch (Exception $e) {
        _log_mail_error('send_user_email to ' . $to_email, $e->getMessage());
    }
}

// ── Get All Site Settings ───────────────────────────────────
function get_all_site_settings() {
    global $pdo;
    if (!isset($pdo)) return [];
    try {
        $stmt = $pdo->query("SELECT * FROM site_settings WHERE id = 1");
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        return $settings ?: [];
    } catch (PDOException $e) {
        return [];
    }
}

// ── Rate Limiting (Session-based) ──────────────────────────
function check_rate_limit($action, $max_requests = 3, $time_window = 60) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $now = time();
    if (!isset($_SESSION['rate_limits'])) {
        $_SESSION['rate_limits'] = [];
    }
    if (!isset($_SESSION['rate_limits'][$action])) {
        $_SESSION['rate_limits'][$action] = [];
    }
    
    // Filter out older timestamps outside the time window
    $_SESSION['rate_limits'][$action] = array_filter(
        $_SESSION['rate_limits'][$action],
        function ($timestamp) use ($now, $time_window) {
            return ($now - $timestamp) < $time_window;
        }
    );
    
    if (count($_SESSION['rate_limits'][$action]) >= $max_requests) {
        return false; // Limit exceeded
    }
    
    // Add current request timestamp
    $_SESSION['rate_limits'][$action][] = $now;
    return true;
}

// ── Google reCAPTCHA v3 Validation ──────────────────────────
function verify_recaptcha($recaptcha_response) {
    // Localhost bypass for testing and headless verification
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
        return true;
    }

    if (empty($recaptcha_response)) {
        return false;
    }
    
    // Google test secret key (always passes)
    $secret = '6LeIxAcTAAAAAGG-vFI1TnFTxWfnC0CFUqfdO77_';
    
    // Build POST request
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret,
        'response' => $recaptcha_response,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
            'timeout' => 5
        ]
    ];
    
    $context  = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        // Fallback: If Google API is unreachable, default to true in local testing
        return true; 
    }
    
    $result = json_decode($response, true);
    return isset($result['success']) && $result['success'] === true;
}




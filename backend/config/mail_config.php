<?php
// ============================================================
// SMTP Email Configuration — Saksham Bharti Foundation
// ============================================================
// INSTRUCTIONS:
//   1. Replace the values below with your real SMTP credentials.
//   2. For Gmail: enable 2FA then create an "App Password" at
//      https://myaccount.google.com/apppasswords
//   3. For Mailtrap (local testing): use the credentials from
//      https://mailtrap.io → Inboxes → SMTP Settings
// ============================================================

define('MAIL_HOST',       'smtp.gmail.com');     // e.g. smtp.gmail.com | smtp.mailtrap.io
define('MAIL_PORT',       587);                  // 587 = TLS | 465 = SSL
define('MAIL_ENCRYPTION', 'tls');                // 'tls' or 'ssl'
define('MAIL_USERNAME',   'your_email@gmail.com');   // Your Gmail / SMTP username
define('MAIL_PASSWORD',   'your_app_password');      // Gmail App Password (NOT your login password)
define('MAIL_FROM_EMAIL', 'no-reply@sakshambharti.org');
define('MAIL_FROM_NAME',  'Saksham Bharti Foundation');

// Log file path for email errors
define('MAIL_ERROR_LOG',  __DIR__ . '/../../logs/mail_errors.log');

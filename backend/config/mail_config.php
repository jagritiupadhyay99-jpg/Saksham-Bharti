<?php
// ============================================================
// SMTP Email Configuration — Saksham Bharti
// ============================================================
// Values are loaded from the .env file in the project root.
// To change settings, edit the .env file — NOT this file.
// ============================================================

require_once __DIR__ . '/env.php';

define('MAIL_HOST',       $_ENV['MAIL_HOST']       ?? 'smtp.gmail.com');
define('MAIL_PORT',       (int)($_ENV['MAIL_PORT']  ?? 587));
define('MAIL_ENCRYPTION', $_ENV['MAIL_ENCRYPTION']  ?? 'tls');
define('MAIL_USERNAME',   $_ENV['MAIL_USERNAME']    ?? 'your_email@gmail.com');
define('MAIL_PASSWORD',   $_ENV['MAIL_PASSWORD']    ?? 'your_app_password');
define('MAIL_FROM_EMAIL', $_ENV['MAIL_FROM_EMAIL']  ?? 'no-reply@sakshambharti.org');
define('MAIL_FROM_NAME',  $_ENV['MAIL_FROM_NAME']   ?? 'Saksham Bharti');

// Log file path for email errors
define('MAIL_ERROR_LOG',  __DIR__ . '/../../logs/mail_errors.log');

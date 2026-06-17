<?php
// config/db.php — Database connection using .env values
require_once __DIR__ . '/env.php';

$host   = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'sakasxin_sb-uat';
$user   = $_ENV['DB_USER'] ?? 'sakasxin_sb-uat';
$pass   = $_ENV['DB_PASS'] ?? 'Banta@123!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

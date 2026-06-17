<?php
// run_database_update.php
require_once __DIR__ . '/backend/config/db.php';

if (($_GET['key'] ?? '') !== 'SakshamSecure2026') {
    header('HTTP/1.1 403 Forbidden');
    die('Unauthorized access.');
}

echo "<h3>Running Database Migrations/Updates...</h3>";

$sqlFile = __DIR__ . '/database.sql';
if (!file_exists($sqlFile)) {
    die("Error: database.sql not found at $sqlFile");
}

$sqlContent = file_get_contents($sqlFile);

// Simple SQL parser to split queries by semicolon
// Remove SQL comments
$sqlContent = preg_replace('/--.*\n/', '', $sqlContent);
$sqlContent = preg_replace('/\/\*.*?\*\//s', '', $sqlContent);

$queries = explode(';', $sqlContent);

foreach ($queries as $query) {
    $query = trim($query);
    if (empty($query)) {
        continue;
    }

    echo "Executing: <code>" . htmlspecialchars(substr($query, 0, 100)) . "...</code> ";
    try {
        $pdo->exec($query);
        echo "<span style='color: green;'>SUCCESS</span><br>";
    } catch (PDOException $e) {
        echo "<span style='color: red;'>FAILED: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    }
}

echo "<h4>Database update complete!</h4>";
?>

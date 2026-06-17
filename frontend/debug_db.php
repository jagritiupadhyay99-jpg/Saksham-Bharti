<?php
// frontend/debug_db.php
require_once __DIR__ . '/../backend/config/db.php';

echo "<h2>Saksham Bharti — Database Diagnostic</h2>";
echo "<p>Connection Status: <strong>OK</strong></p>";

try {
    $stmt = $pdo->query("SELECT DATABASE() as db");
    $row = $stmt->fetch();
    echo "<p>Active Database: <strong>" . htmlspecialchars($row['db'] ?? 'None') . "</strong></p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Error fetching active database: " . htmlspecialchars($e->getMessage()) . "</p>";
}

try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM blogs");
    $row = $stmt->fetch();
    echo "<p>Row Count in 'blogs' table: <strong>" . $row['count'] . "</strong></p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Error querying 'blogs' table: " . htmlspecialchars($e->getMessage()) . "</p>";
}

try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM activities");
    $row = $stmt->fetch();
    echo "<p>Row Count in 'activities' table: <strong>" . $row['count'] . "</strong></p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Error querying 'activities' table: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h3>Environment Variables ($_ENV):</h3>";
echo "<ul>";
foreach ($_ENV as $key => $value) {
    // Mask sensitive credentials
    if (stripos($key, 'pass') !== false || stripos($key, 'secret') !== false || stripos($key, 'key') !== false || stripos($key, 'user') !== false) {
        $value = '[MASKED]';
    }
    echo "<li>" . htmlspecialchars($key) . ": " . htmlspecialchars($value) . "</li>";
}
echo "</ul>";
?>

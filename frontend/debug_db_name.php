<?php
// frontend/debug_db_name.php
require_once __DIR__ . '/../backend/config/db.php';

try {
    $db_name = $pdo->query("SELECT DATABASE()")->fetchColumn();
    $blogs_count = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    $activities_count = $pdo->query("SELECT COUNT(*) FROM activities")->fetchColumn();
    
    echo "<h1>Database Connection Diagnostics</h1>";
    echo "<p><strong>Connected Database:</strong> " . htmlspecialchars($db_name) . "</p>";
    echo "<p><strong>Blogs Table Row Count:</strong> " . htmlspecialchars($blogs_count) . "</p>";
    echo "<p><strong>Activities Table Row Count:</strong> " . htmlspecialchars($activities_count) . "</p>";
} catch (PDOException $e) {
    echo "<h1>Database Connection Failed</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

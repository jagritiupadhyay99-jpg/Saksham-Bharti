<?php
/**
 * Saksham Bharti - Live Server Diagnostics & Debugging Tool
 * 
 * Securely checks database connection, table structures, and function definitions
 * to find out why pages might throw 500 errors on the live server.
 */

// Enable error reporting to catch issues
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saksham Bharti - Live Diagnostics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: system-ui, -apple-system, sans-serif; }
        .card { border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .status-badge { font-weight: 600; padding: 0.35em 0.65em; border-radius: 50rem; }
    </style>
</head>
<body class="py-5">
    <div class="container" style="max-width: 800px;">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Live Server Diagnostics</h2>
            <p class="text-muted">Troubleshooting environment, database, and functions</p>
        </div>

        <!-- 1. PHP Environment -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-server me-2 text-primary"></i> PHP Environment</h5>
            <table class="table table-sm mb-0">
                <tr>
                    <td width="250" class="text-muted">PHP Version</td>
                    <td><strong><?= PHP_VERSION ?></strong></td>
                </tr>
                <tr>
                    <td class="text-muted">Server Software</td>
                    <td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></td>
                </tr>
            </table>
        </div>

        <!-- 2. Functions & Code Files -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-code me-2 text-primary"></i> Code & Helper Functions</h5>
            <table class="table table-sm mb-0">
                <tr>
                    <td width="250" class="text-muted">backend/includes/functions.php</td>
                    <td>
                        <?php
                        $func_file = __DIR__ . '/../backend/includes/functions.php';
                        if (file_exists($func_file)) {
                            echo '<span class="badge bg-success status-badge">File Exists</span>';
                            // Try to include it if not loaded
                            @include_once $func_file;
                        } else {
                            echo '<span class="badge bg-danger status-badge">Missing File</span>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted">resolve_image_path() definition</td>
                    <td>
                        <?php
                        if (function_exists('resolve_image_path')) {
                            echo '<span class="badge bg-success status-badge">Function Defined</span>';
                        } else {
                            echo '<span class="badge bg-danger status-badge">Undefined Function</span>';
                            echo '<div class="text-danger small mt-1">Please ensure the latest <strong>backend/includes/functions.php</strong> is uploaded to the server.</div>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <!-- 3. Database Connection & Tables -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-database me-2 text-primary"></i> Database Status</h5>
            <?php
            $db_file = __DIR__ . '/../backend/config/db.php';
            if (!file_exists($db_file)) {
                echo '<div class="alert alert-danger"><strong>Missing file:</strong> backend/config/db.php not found.</div>';
            } else {
                try {
                    // Try to require database configuration
                    require_once $db_file;
                    
                    if (isset($pdo) && $pdo instanceof PDO) {
                        echo '<div class="alert alert-success d-flex align-items-center mb-3">';
                        echo '<div><strong>Database Connected Successfully!</strong></div>';
                        echo '</div>';
                        
                        // Check tables
                        $tables = ['programs', 'blogs', 'activities', 'site_settings'];
                        echo '<table class="table table-sm mb-0">';
                        foreach ($tables as $table) {
                            try {
                                $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM `$table`");
                                $count = $stmt->fetchColumn();
                                echo '<tr>';
                                echo '<td width="250" class="text-muted">Table `' . $table . '`</td>';
                                echo '<td><span class="badge bg-success status-badge">OK (' . $count . ' rows)</span></td>';
                                echo '</tr>';
                            } catch (PDOException $ex) {
                                echo '<tr>';
                                echo '<td class="text-muted">Table `' . $table . '`</td>';
                                echo '<td><span class="badge bg-danger status-badge">Error / Missing Table</span><br>';
                                echo '<span class="text-danger small">' . htmlspecialchars($ex->getMessage()) . '</span></td>';
                                echo '</tr>';
                            }
                        }
                        echo '</table>';
                    } else {
                        echo '<div class="alert alert-warning">Database file loaded, but $pdo is not an instance of PDO.</div>';
                    }
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger"><strong>Database connection failed:</strong><br>' . htmlspecialchars($e->getMessage()) . '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

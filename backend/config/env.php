<?php
// config/env.php — Loads the root .env file into $_ENV
// Include this file ONCE at the top of db.php and mail_config.php

function loadEnv(string $path): void {
    if (!file_exists($path)) {
        return; // No .env file — use defaults or server environment
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);

        // Skip comments
        if (str_starts_with($line, '#') || $line === '') {
            continue;
        }

        // Split on first = only
        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        // Remove surrounding quotes if present
        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

// Load the .env from the project root (two levels up from config/)
loadEnv(dirname(__DIR__, 2) . '/.env');

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id']) || !in_array($_SESSION['role'] ?? '', ['admin', 'petugas'], true)) {
    $rootDir = dirname(__DIR__);
    $currentDir = dirname($_SERVER['SCRIPT_FILENAME']);

    $relative = str_replace('\\', '/', substr($currentDir, strlen($rootDir)));
    $relative = trim($relative, '/');

    $depth = ($relative === '') ? 0 : (substr_count($relative, '/') + 1);
    $base = str_repeat('../', $depth);

    header('Location: ' . $base . 'auth/login.php');
    exit;
}

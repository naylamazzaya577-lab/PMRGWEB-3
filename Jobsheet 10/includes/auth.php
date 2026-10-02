<?php
// includes/auth.php
// Guard clause: redirect ke auth/login.php kalau belum login.
// WAJIB di-include sebagai BARIS PERTAMA di halaman yang dikunci,
// SEBELUM require koneksi.php dan SEBELUM include header.php, supaya
// header('Location: ...') masih bisa dipanggil sebelum ada output HTML
// apa pun (dan supaya tidak perlu koneksi DB dulu buat redirect).

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    // Hitung $base otomatis berdasarkan kedalaman folder, sama seperti
    // logika di includes/header.php, supaya redirect tetap benar baik
    // diakses dari root (php -S) maupun subfolder (Laragon).
    $rootDir = dirname(__DIR__);
    $currentDir = dirname($_SERVER['SCRIPT_FILENAME']);

    $relative = str_replace('\\', '/', substr($currentDir, strlen($rootDir)));
    $relative = trim($relative, '/');

    $depth = ($relative === '') ? 0 : (substr_count($relative, '/') + 1);
    $base = str_repeat('../', $depth);

    header('Location: ' . $base . 'auth/login.php');
    exit;
}

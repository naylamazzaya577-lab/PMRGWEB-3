<?php
// includes/security.php
// Helper keamanan: escape output (XSS) dan token CSRF.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Escape output HTML (anti-XSS)
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Token CSRF per-sesi
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Input hidden yang ditempel di setiap form POST
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

// Dipanggil di awal file proses POST (SETELAH auth guard)
function csrf_verify(): void
{
    $dikirim = $_POST['csrf_token'] ?? '';
    $asli    = $_SESSION['csrf_token'] ?? '';

    if (!is_string($dikirim) || $asli === '' || !hash_equals($asli, $dikirim)) {
        http_response_code(403);
        exit('Permintaan ditolak: token CSRF tidak valid. Kembali dan muat ulang halaman.');
    }
}
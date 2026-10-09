<?php
require_once __DIR__ . '/security.php';

$host = 'ep-billowing-tree-b4dw64eu.c-6.us-east-2.aws.neon.tech';
$port = '5432';
$db   = 'neondb';
$user = 'neondb_owner';
$pass = 'npg_h9VzA4PGYKtD';

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    error_log('Koneksi database gagal: ' . $e->getMessage());
    die('Layanan sedang bermasalah. Silakan coba lagi nanti.');
}
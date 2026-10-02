<?php
// includes/koneksi.php
// Koneksi PDO ke PostgreSQL (Neon). Di-include lewat require di setiap
// file yang butuh akses database (list.php, proses_tambah.php, index.php,
// proses_edit.php, hapus.php).

$host = 'ep-billowing-tree-b4dw64eu-pooler.c-6.us-east-2.aws.neon.tech';
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
    die('Koneksi database gagal: ' . $e->getMessage());
}

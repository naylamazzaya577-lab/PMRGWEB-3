<?php
// includes/koneksi.php
// Koneksi PDO ke PostgreSQL. Di-include lewat require di setiap file
// yang butuh akses database (list.php, proses_tambah.php, index.php).

$host = ep-billowing-tree-b4dw64eu-pooler.c-6.us-east-2.aws.neon.tech
$port = '5432';
$db   = neondb;
$user = neondb_owner; // sesuaikan dengan environment lokal kamu
$pass = npg_h9VzA4PGYKtD;            // sesuaikan dengan environment lokal kamu

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}

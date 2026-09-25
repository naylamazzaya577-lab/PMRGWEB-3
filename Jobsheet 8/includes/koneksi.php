<?php
// includes/koneksi.php
// Koneksi PDO ke PostgreSQL. Di-include lewat require di setiap file
// yang butuh akses database (list.php, proses_tambah.php, index.php).

$host = '127.0.0.1';
$port = '5432';
$db   = 'taslimiyah_bakery';
$user = 'postgres';   // sesuaikan dengan environment lokal kamu
$pass = '';            // sesuaikan dengan environment lokal kamu

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}

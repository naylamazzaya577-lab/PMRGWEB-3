<?php
// Di Railway: diisi lewat Variables. Di lokal: lewat koneksi.local.php (tidak di-push).
$local = __DIR__ . '/koneksi.local.php';
if (is_file($local)) {
    require $local;
}

$host = $host ?? getenv('DB_HOST');
$port = $port ?? (getenv('DB_PORT') ?: '5432');
$db   = $db   ?? getenv('DB_NAME');
$user = $user ?? getenv('DB_USER');
$pass = $pass ?? getenv('DB_PASS');

$dsn = "pgsql:host={$host};port={$port};dbname={$db};sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}
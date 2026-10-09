<?php
require __DIR__ . '/includes/auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: promo.php');
    exit;
}
$judul = trim($_POST['judul'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$jenis = $_POST['jenis'] ?? '';
$mulai = $_POST['tanggal_mulai'] ?? '';
$selesai = $_POST['tanggal_selesai'] ?? '';
$validDate = static function (string $date): bool {
    $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    return $parsed !== false && $parsed->format('Y-m-d') === $date;
};
if ($judul === '' || strlen($judul) > 150 || $deskripsi === '' || strlen($deskripsi) > 1000 ||
    !in_array($jenis, ['harian', 'bulanan'], true) ||
    !$validDate($mulai) || !$validDate($selesai) || $selesai < $mulai) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data promo tidak valid. Periksa judul, deskripsi, jenis, dan tanggal.'];
    header('Location: promo.php');
    exit;
}
$stmt = $pdo->prepare('INSERT INTO promo (judul, deskripsi, jenis, tanggal_mulai, tanggal_selesai) VALUES (:judul, :deskripsi, :jenis, :mulai, :selesai)');
$stmt->execute([':judul' => $judul, ':deskripsi' => $deskripsi, ':jenis' => $jenis, ':mulai' => $mulai, ':selesai' => $selesai]);
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Promo berhasil ditambahkan.'];
header('Location: promo.php');
exit;

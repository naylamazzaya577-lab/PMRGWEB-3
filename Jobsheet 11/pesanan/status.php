<?php
require __DIR__ . '/../includes/auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}
csrf_verify();
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Pesanan tidak valid.'];
} else {
    $stmt = $pdo->prepare("UPDATE pesanan SET status_pembayaran = 'dibayar' WHERE id = :id AND status_pembayaran = 'menunggu'");
    $stmt->execute([':id' => $id]);
    $_SESSION['flash'] = ['type' => $stmt->rowCount() ? 'success' : 'error', 'pesan' => $stmt->rowCount() ? 'Status pembayaran diperbarui.' : 'Pesanan tidak ditemukan atau sudah diproses.'];
}
header('Location: list.php');
exit;

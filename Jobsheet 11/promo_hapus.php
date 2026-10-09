<?php
require __DIR__ . '/includes/auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: promo.php');
    exit;
}
csrf_verify();
$id = (int) ($_POST['id'] ?? 0);
if ($id < 1) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Promo tidak valid.'];
} else {
    $stmt = $pdo->prepare('DELETE FROM promo WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Promo berhasil dihapus.'];
}
header('Location: promo.php');
exit;

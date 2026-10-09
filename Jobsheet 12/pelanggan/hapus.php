<?php
require __DIR__ . '/../includes/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => 'Pelanggan tidak valid.',
    ];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare('DELETE FROM pelanggan WHERE id = :id');
$stmt->execute([':id' => $id]);

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Pelanggan berhasil dihapus.',
];

header('Location: list.php');
exit;

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$kodeAdmin = (string) ($_POST['kode_admin'] ?? '');

if ($nama === '' || mb_strlen($nama) > 10) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => 'Nama admin wajib diisi dan maksimal 10 karakter.',
    ];
    header('Location: login.php');
    exit;
}

if (!hash_equals('050707', $kodeAdmin)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => 'Nama admin atau kode admin salah.',
    ];
    header('Location: login.php');
    exit;
}

session_regenerate_id(true);
unset($_SESSION['mode']);
$_SESSION['user_id'] = 'kode-admin';
$_SESSION['nama'] = $nama;
$_SESSION['username'] = strtolower($nama);
$_SESSION['role'] = 'admin';

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Berhasil login, selamat datang ' . $nama . '!',
];

header('Location: ../index.php');
exit;

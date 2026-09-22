<?php
// pelanggan/proses_tambah.php
// Memvalidasi $_POST di server (terpisah dari validasi JS) sehingga tetap
// mencegah data invalid tersimpan walau JavaScript dimatikan di browser.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['pelanggan'])) {
    $_SESSION['pelanggan'] = [];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$kode   = trim($_POST['kode'] ?? '');
$nama   = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$nohp   = trim($_POST['nohp'] ?? '');

$errors = [];

if ($kode === '') {
    $errors[] = 'Kode pelanggan wajib diisi.';
}
if ($nama === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
}
if ($alamat === '') {
    $errors[] = 'Alamat domisili wajib diisi.';
}
if ($nohp === '' || !preg_match('/^[0-9+\-\s]{8,15}$/', $nohp)) {
    $errors[] = 'Nomor HP wajib diisi dengan format yang valid.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors),
    ];
    header('Location: tambah.php');
    exit;
}

$_SESSION['pelanggan'][] = [
    'kode_pelanggan' => $kode,
    'nama'           => $nama,
    'alamat'         => $alamat,
    'no_hp'          => $nohp,
];

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Pelanggan berhasil ditambahkan!',
];

header('Location: list.php');
exit;

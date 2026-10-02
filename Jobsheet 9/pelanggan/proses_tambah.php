<?php
// pelanggan/proses_tambah.php
// Validasi $_POST tetap di server (sama seperti Jobsheet 7), tapi
// penyimpanan sekarang lewat INSERT prepared statement ke PostgreSQL,
// bukan lagi $_SESSION['pelanggan'][].

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

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

$sql = 'INSERT INTO pelanggan (kode_pelanggan, nama, alamat, no_hp)
        VALUES (:kode, :nama, :alamat, :nohp)
        RETURNING id';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':kode'   => $kode,
    ':nama'   => $nama,
    ':alamat' => $alamat,
    ':nohp'   => $nohp,
]);

$idBaru = $stmt->fetchColumn();

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Pelanggan berhasil ditambahkan!',
];

header('Location: list.php');
exit;

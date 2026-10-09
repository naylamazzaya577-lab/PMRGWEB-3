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

$id     = (int) ($_POST['id'] ?? 0);
$kode   = trim($_POST['kode'] ?? '');
$nama   = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$nohp   = trim($_POST['nohp'] ?? '');
$gender = trim($_POST['gender'] ?? '');

$errors = [];

if ($id <= 0) {
    $errors[] = 'Pelanggan tidak valid.';
}
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
if (!in_array($gender, ['Perempuan', 'Laki-laki', 'Tidak disebutkan'], true)) {
    $errors[] = 'Gender tidak valid.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors),
    ];
    header('Location: edit.php?id=' . $id);
    exit;
}

$sql = 'UPDATE pelanggan
        SET kode_pelanggan = :kode,
            nama           = :nama,
            alamat         = :alamat,
            no_hp          = :nohp,
            gender         = :gender
        WHERE id = :id';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':kode'   => $kode,
    ':nama'   => $nama,
    ':alamat' => $alamat,
    ':nohp'   => $nohp,
    ':gender' => $gender,
    ':id'     => $id,
]);

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Pelanggan berhasil diperbarui!',
];

header('Location: list.php');
exit;

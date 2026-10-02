<?php
require __DIR__ . '/../includes/auth.php';
// produk/proses_edit.php
// Validasi sama seperti proses_tambah.php, tapi eksekusinya UPDATE
// (bukan INSERT) dan menyasar baris dengan id tertentu.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id       = (int) ($_POST['id'] ?? 0);
$kode     = trim($_POST['kode'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga    = $_POST['harga'] ?? '';
$stok     = $_POST['stok'] ?? '';

$errors = [];

if ($id <= 0) {
    $errors[] = 'Produk tidak valid.';
}
if ($kode === '') {
    $errors[] = 'Kode produk wajib diisi.';
}
if ($nama === '') {
    $errors[] = 'Nama produk wajib diisi.';
}
$kategoriValid = ['Roti', 'Cake', 'Pastry', 'Snack Box', 'Kue Kering'];
if ($kategori === '' || !in_array($kategori, $kategoriValid, true)) {
    $errors[] = 'Kategori tidak valid.';
}
if ($harga === '' || !is_numeric($harga) || (float) $harga < 0) {
    $errors[] = 'Harga wajib diisi dengan angka yang valid.';
}
if ($stok === '' || !is_numeric($stok) || (int) $stok < 0) {
    $errors[] = 'Stok wajib diisi dengan angka yang valid.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors),
    ];
    header('Location: edit.php?id=' . $id);
    exit;
}

$sql = 'UPDATE produk
        SET kode_produk = :kode,
            nama_produk = :nama,
            kategori    = :kategori,
            harga       = :harga,
            stok        = :stok
        WHERE id = :id';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':kode'     => $kode,
    ':nama'     => $nama,
    ':kategori' => $kategori,
    ':harga'    => $harga,
    ':stok'     => $stok,
    ':id'       => $id,
]);

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Produk berhasil diperbarui!',
];

header('Location: list.php');
exit;

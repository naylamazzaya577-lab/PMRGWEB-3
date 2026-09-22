<?php
// produk/proses_tambah.php
// Memvalidasi $_POST di server (terpisah dari validasi JS) sehingga tetap
// mencegah data invalid tersimpan walau JavaScript dimatikan di browser.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['produk'])) {
    $_SESSION['produk'] = [];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$kode     = trim($_POST['kode'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga    = $_POST['harga'] ?? '';
$stok     = $_POST['stok'] ?? '';

$errors = [];

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
    header('Location: tambah.php');
    exit;
}

$_SESSION['produk'][] = [
    'kode_produk' => $kode,
    'nama_produk' => $nama,
    'kategori'    => $kategori,
    'harga'       => (float) $harga,
    'stok'        => (int) $stok,
];

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Produk berhasil ditambahkan!',
];

header('Location: list.php');
exit;

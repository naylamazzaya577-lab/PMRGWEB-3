<?php
// produk/proses_tambah.php
// Validasi $_POST tetap di server (sama seperti Jobsheet 7), tapi
// penyimpanan sekarang lewat INSERT prepared statement ke PostgreSQL,
// bukan lagi $_SESSION['produk'][].

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

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

$sql = 'INSERT INTO produk (kode_produk, nama_produk, kategori, harga, stok)
        VALUES (:kode, :nama, :kategori, :harga, :stok)
        RETURNING id';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':kode'     => $kode,
    ':nama'     => $nama,
    ':kategori' => $kategori,
    ':harga'    => $harga,
    ':stok'     => $stok,
]);

$idBaru = $stmt->fetchColumn();

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Produk berhasil ditambahkan!',
];

header('Location: list.php');
exit;

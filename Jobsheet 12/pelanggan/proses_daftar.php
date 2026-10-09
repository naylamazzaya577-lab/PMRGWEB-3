<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: daftar.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$nohp = preg_replace('/[\s-]+/', '', trim($_POST['nohp'] ?? ''));
$gender = trim($_POST['gender'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$testimoni = trim($_POST['testimoni'] ?? '');
$publishTestimoni = ($_POST['setuju_testimoni'] ?? '') === '1';
$errors = [];

if ($nama === '' || strlen($nama) > 150) {
    $errors[] = 'Nama wajib diisi (maksimal 150 karakter).';
}
if (!preg_match('/^\+?[0-9]{8,15}$/', $nohp)) {
    $errors[] = 'Nomor HP tidak valid.';
}
if (!in_array($gender, ['Perempuan', 'Laki-laki', 'Tidak disebutkan'], true)) {
    $errors[] = 'Pilih gender yang valid.';
}
if ($alamat === '' || strlen($alamat) > 1000) {
    $errors[] = 'Alamat domisili wajib diisi.';
}
if (strlen($testimoni) > 500) {
    $errors[] = 'Testimoni maksimal 500 karakter.';
}
if ($testimoni !== '' && !$publishTestimoni) {
    $errors[] = 'Setujui publikasi anonim atau kosongkan kolom testimoni.';
}

if ($errors) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: daftar.php');
    exit;
}
$kode = 'TM-' . strtoupper(bin2hex(random_bytes(4)));

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare(
        'INSERT INTO pelanggan (kode_pelanggan, nama, alamat, no_hp, gender)
         VALUES (:kode, :nama, :alamat, :nohp, :gender)
         RETURNING id'
    );
    $stmt->execute([
        ':kode' => $kode,
        ':nama' => $nama,
        ':alamat' => $alamat,
        ':nohp' => $nohp,
        ':gender' => $gender,
    ]);
    $memberId = (int) $stmt->fetchColumn();

    if ($testimoni !== '') {
        $review = $pdo->prepare('INSERT INTO testimoni (pelanggan_id, isi) VALUES (:pelanggan_id, :isi)');
        $review->execute([':pelanggan_id' => $memberId, ':isi' => $testimoni]);
    }
    $pdo->commit();
} catch (Throwable $error) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Gagal mendaftarkan loyalty member: ' . $error->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Pendaftaran gagal disimpan. Silakan coba kembali.'];
    header('Location: daftar.php');
    exit;
}

$waNumber = preg_replace('/\D+/', '', $nohp);
if (str_starts_with($waNumber, '0')) {
    $waNumber = '62' . substr($waNumber, 1);
}

$message = rawurlencode("Halo {$nama}, nomor khusus Loyalty Taslimiyah Bakery kamu adalah {$kode}. Gunakan kode ini untuk mendapatkan diskon 4%.");
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pendaftaran berhasil. Simpan nomor khusus member kamu: ' . $kode];
header('Location: daftar_sukses.php?wa=' . rawurlencode($waNumber) . '&text=' . $message);
exit;

<?php
// auth/proses_register.php
// Validasi server, cek username duplikat, simpan password dengan
// password_hash() — JANGAN PERNAH simpan password dalam bentuk teks biasa.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama       = trim($_POST['nama'] ?? '');
$username   = trim($_POST['username'] ?? '');
$password   = $_POST['password'] ?? '';
$konfirmasi = $_POST['konfirmasi'] ?? '';

$errors = [];

if ($nama === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
}
if ($username === '') {
    $errors[] = 'Username wajib diisi.';
}
if (strlen($password) < 6) {
    $errors[] = 'Password minimal 6 karakter.';
}
if ($password !== $konfirmasi) {
    $errors[] = 'Konfirmasi password tidak cocok.';
}

// Cek username duplikat
if (empty($errors)) {
    $cek = $pdo->prepare('SELECT id FROM users WHERE username = :username');
    $cek->execute([':username' => $username]);
    if ($cek->fetch()) {
        $errors[] = 'Username sudah dipakai, pilih username lain.';
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors),
    ];
    header('Location: register.php');
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, :role)');
$stmt->execute([
    ':nama'     => $nama,
    ':username' => $username,
    ':password' => $hashed,
    ':role'     => 'petugas',
]);

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Akun berhasil dibuat, silakan login.',
];

header('Location: login.php');
exit;

<?php
// auth/proses_login.php
// Cari user by username, cocokkan password dengan password_verify()
// (jangan pernah bandingkan password mentah dengan == atau ===).

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
$stmt->execute([':username' => $username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => 'Username atau password salah.',
    ];
    header('Location: login.php');
    exit;
}

// Login berhasil — simpan info user di session
$_SESSION['user_id']  = $user['id'];
$_SESSION['nama']     = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role']     = $user['role'];

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Berhasil login, selamat datang ' . $user['nama'] . '!',
];

header('Location: ../index.php');
exit;

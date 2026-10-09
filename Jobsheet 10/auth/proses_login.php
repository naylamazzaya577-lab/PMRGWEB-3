<?php
// auth/proses_login.php
// Akun database diverifikasi dengan password_verify(); kredensial environment
// menggunakan hash_equals() agar kode akses tidak ditanam di source.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$password = $_POST['kode_admin'] ?? '';

$configuredName = getenv('BAKERY_ADMIN_NAME');
$configuredCode = getenv('BAKERY_ADMIN_CODE');
$configuredName = is_string($configuredName) && $configuredName !== '' ? $configuredName : 'Zaya';
$user = null;

if (is_string($configuredCode) && $configuredCode !== '' &&
    strcasecmp($nama, $configuredName) === 0 &&
    hash_equals($configuredCode, (string) $password)) {
    $user = [
        'id' => 'configured-admin',
        'nama' => $configuredName,
        'username' => strtolower($configuredName),
        'role' => 'admin',
    ];
} else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(nama) = LOWER(:nama) AND role IN ('admin', 'petugas') ORDER BY id");
    $stmt->execute([':nama' => $nama]);
    foreach ($stmt->fetchAll() as $candidate) {
        if (password_verify($password, $candidate['password'])) {
            $user = $candidate;
            break;
        }
    }
}

if (!$user) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => 'Nama admin atau kode admin salah.',
    ];
    header('Location: login.php');
    exit;
}

// Login berhasil — simpan info user di session
session_regenerate_id(true);
unset($_SESSION['mode']);
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

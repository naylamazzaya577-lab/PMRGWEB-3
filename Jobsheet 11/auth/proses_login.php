<?php
// auth/proses_login.php
// Akun database diverifikasi dengan password_verify(); kredensial environment
// menggunakan hash_equals() agar kode akses tidak ditanam di source.
// Tambahan: nama bebas (maks. 10 karakter) + kode admin 050707.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}
csrf_verify();

$nama = trim($_POST['nama'] ?? '');
$password = trim((string) ($_POST['kode_admin'] ?? ''));

// Validasi nama: wajib diisi, maksimal 10 karakter
if ($nama === '' || mb_strlen($nama) > 10) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => 'Nama admin wajib diisi dan maksimal 10 karakter.',
    ];
    header('Location: login.php');
    exit;
}

$validAdminCodes = ['050707'];

$configuredName = getenv('BAKERY_ADMIN_NAME');
$configuredCode = getenv('BAKERY_ADMIN_CODE');
$configuredName = is_string($configuredName) && $configuredName !== '' ? $configuredName : 'Zaya';
$user = null;

// 1) Nama bebas + kode admin
foreach ($validAdminCodes as $code) {
    if (hash_equals($code, $password)) {
        $user = [
            'id' => 'kode-admin',
            'nama' => $nama,
            'username' => strtolower($nama),
            'role' => 'admin',
        ];
        break;
    }
}

// 2) Kredensial environment (jalur lama)
if (!$user &&
    is_string($configuredCode) && $configuredCode !== '' &&
    strcasecmp($nama, $configuredName) === 0 &&
    hash_equals($configuredCode, $password)) {
    $user = [
        'id' => 'configured-admin',
        'nama' => $configuredName,
        'username' => strtolower($configuredName),
        'role' => 'admin',
    ];
}

// 3) Akun di tabel users (jalur lama). Dibungkus try/catch supaya kalau
//    tabel users belum ada, tidak muncul Fatal error.
if (!$user) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(nama) = LOWER(:nama) AND role IN ('admin', 'petugas') ORDER BY id");
        $stmt->execute([':nama' => $nama]);
        foreach ($stmt->fetchAll() as $candidate) {
            if (password_verify($password, $candidate['password'])) {
                $user = $candidate;
                break;
            }
        }
    } catch (Throwable $error) {
        error_log('Login: tabel users tidak bisa dibaca: ' . $error->getMessage());
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
<?php
// includes/header.php
// Dipakai lewat include di setiap halaman .php
// $base tetap digunakan untuk file CSS agar tampilan tetap berjalan.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Root proyek = satu tingkat di atas folder includes/ ini
$rootDir = dirname(__DIR__);

// Folder tempat file yang sedang dieksekusi berada
$currentDir = dirname($_SERVER['SCRIPT_FILENAME']);

$relative = str_replace('\\', '/', substr($currentDir, strlen($rootDir)));
$relative = trim($relative, '/');

$depth = ($relative === '') ? 0 : (substr_count($relative, '/') + 1);
$base = str_repeat('../', $depth);

$pageTitle = $pageTitle ?? 'Taslimiyah Bakery';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkgreen: '#103713',
                        softgreen: '#1b5220',
                        lightbg: '#F8FAFC',
                    }
                }
            }
        }
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- CSS tetap menggunakan $base -->
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>

<body class="bg-lightbg text-slate-800 min-h-screen flex flex-col font-sans antialiased selection:bg-darkgreen selection:text-white">

<header class="border-b border-white/10 bg-darkgreen/95 backdrop-blur-md sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        <!-- Logo / Beranda -->
        <a href="/index.php" class="flex items-center space-x-3 group">

            <div class="w-8 h-8 rounded-full bg-white text-darkgreen flex items-center justify-center font-bold text-sm tracking-tighter shadow-sm">
                T
            </div>

            <span class="font-bold text-lg tracking-tight text-white group-hover:text-emerald-200 transition-colors">
                Taslimiyah Bakery
            </span>

        </a>


        <!-- BAGIAN KANAN: menu + ikon dijadikan satu grup supaya rata kanan -->
        <div class="flex items-center space-x-2">

            <!-- MENU DESKTOP -->
            <nav class="hidden md:flex items-center space-x-1 text-sm font-medium mr-2">

                <a href="/index.php"
                   class="px-3 py-1.5 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition-colors">
                    Beranda
                </a>

                <a href="/produk/list.php"
                   class="px-3 py-1.5 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition-colors">
                    Produk
                </a>

                <a href="/pelanggan/list.php"
                   class="px-3 py-1.5 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition-colors">
                    Pelanggan
                </a>

                <?php if (!empty($_SESSION['user_id'])): ?>
                    <span class="px-3 py-1.5 text-white/70 text-xs font-mono">
                        Halo, <?= htmlspecialchars($_SESSION['nama']) ?>
                    </span>
                    <a href="/auth/logout.php"
                       class="px-3 py-1.5 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition-colors">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/auth/login.php"
                       class="px-3 py-1.5 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition-colors">
                        Login
                    </a>
                <?php endif; ?>

            </nav>

            <a href="https://github.com"
               target="_blank"
               class="p-2 text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">

                <i data-lucide="github" class="w-5 h-5"></i>

            </a>


            <!-- Tombol menu HP -->
            <button id="menu-btn"
                    class="md:hidden p-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-colors focus:outline-none">

                <i data-lucide="menu" class="w-6 h-6"></i>

            </button>

        </div>

    </div>


    <!-- MENU MOBILE: dirapihin jadi bentang penuh dari kiri (left-4) ke kanan (right-4),
         bukan cuma kotak kecil ngambang di pojok kanan seperti sebelumnya -->
    <div id="mobile-menu"
         class="hidden md:hidden absolute left-4 right-4 top-16 bg-white border border-slate-200 rounded-xl p-2 shadow-xl z-50 flex flex-col space-y-1">

        <a href="/index.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
            Beranda
        </a>

        <a href="/produk/list.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
            Produk
        </a>

        <a href="/pelanggan/list.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
            Pelanggan
        </a>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <span class="block px-4 py-2 text-xs font-mono text-slate-400">
                Halo, <?= htmlspecialchars($_SESSION['nama']) ?>
            </span>
            <a href="/auth/logout.php"
               class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
                Logout
            </a>
        <?php else: ?>
            <a href="/auth/login.php"
               class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
                Login
            </a>
        <?php endif; ?>

    </div>

</header>


<!-- FLASH MESSAGE -->
<?php if (!empty($_SESSION['flash'])): ?>

    <?php
        $flash = $_SESSION['flash'];
        $isSuccess = ($flash['type'] ?? 'success') === 'success';

        unset($_SESSION['flash']);
    ?>

    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-6">

        <div class="rounded-lg border px-4 py-3 text-sm font-medium flex items-center space-x-2
            <?= $isSuccess
                ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                : 'bg-red-50 border-red-200 text-red-700'
            ?>">

            <i data-lucide="<?= $isSuccess ? 'check-circle' : 'alert-circle' ?>"
               class="w-4 h-4">
            </i>

            <span>
                <?= htmlspecialchars($flash['pesan'] ?? '') ?>
            </span>

        </div>

    </div>

<?php endif; ?>

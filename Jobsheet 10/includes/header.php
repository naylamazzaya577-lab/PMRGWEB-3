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
$isAdmin = !empty($_SESSION['user_id']) && in_array($_SESSION['role'] ?? '', ['admin', 'petugas'], true);
$isGuest = ($_SESSION['mode'] ?? '') === 'guest';
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
                        darkgreen: '#174d3b',
                        softgreen: '#24644e',
                        lightbg: '#faf8f4',
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

<header class="border-b border-white/60 bg-white/85 backdrop-blur-xl sticky top-0 z-50 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        <!-- Logo / Beranda -->
        <div class="flex min-w-0 items-center gap-2 sm:gap-3">
        <a href="<?= $base ?>index.php" class="flex items-center space-x-2 sm:space-x-3 group">

            <div class="w-8 h-8 rounded-full bg-darkgreen text-white flex items-center justify-center font-bold text-sm tracking-tighter shadow-sm">
                T
            </div>

            <span class="whitespace-nowrap text-sm font-bold tracking-tight text-stone-800 transition-colors group-hover:text-darkgreen sm:text-lg">
                Taslimiyah Bakery
            </span>

        </a>
        <?php if ($isAdmin || $isGuest): ?>
            <span class="whitespace-nowrap rounded-full border border-emerald-900/10 bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-darkgreen sm:px-2.5 sm:text-xs">
                <?= $isAdmin ? 'Admin' : 'Guest' ?>
            </span>
        <?php endif; ?>
        </div>


        <!-- BAGIAN KANAN: menu + ikon dijadikan satu grup supaya rata kanan -->
        <div class="flex items-center space-x-2">

            <!-- MENU DESKTOP -->
            <nav class="hidden md:flex items-center space-x-1 text-sm font-medium mr-2">

                <a href="<?= $base ?>index.php"
                   class="px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">
                    Beranda
                </a>

                <a href="<?= $base ?>produk/list.php"
                   class="px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">
                    Produk
                </a>

                <a href="<?= $base ?>pelanggan/list.php"
                   class="px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">
                    Pelanggan
                </a>

                <a href="<?= $base ?>promo.php"
                   class="px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">
                    Promo
                </a>

                <?php if ($isGuest): ?>
                    <a href="<?= $base ?>checkout.php" aria-label="Buka keranjang" class="relative inline-flex h-9 w-9 items-center justify-center rounded-full text-lg text-darkgreen transition-colors hover:bg-emerald-50"><span aria-hidden="true">🛒</span><span class="cart-count absolute right-0 top-0">0</span></a>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                    <a href="<?= $base ?>pesanan/list.php" class="px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">Pesanan</a>
                    <a href="<?= $base ?>auth/logout.php"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">
                        <i data-lucide="log-out" class="h-4 w-4"></i>Keluar
                    </a>
                <?php elseif (!$isGuest): ?>
                    <a href="<?= $base ?>auth/login.php"
                       class="px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors">
                        Masuk
                    </a>
                <?php else: ?>
                    <a href="<?= $base ?>auth/logout.php" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-stone-600 hover:text-darkgreen hover:bg-emerald-50 transition-colors"><i data-lucide="log-out" class="h-4 w-4"></i>Keluar</a>
                <?php endif; ?>

            </nav>

            <!-- Tombol menu HP -->
            <button id="menu-btn"
                    class="md:hidden p-2 text-stone-700 hover:text-darkgreen hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none">

                <i data-lucide="menu" class="w-6 h-6"></i>

            </button>

        </div>

    </div>


    <!-- MENU MOBILE: dirapihin jadi bentang penuh dari kiri (left-4) ke kanan (right-4),
         bukan cuma kotak kecil ngambang di pojok kanan seperti sebelumnya -->
    <div id="mobile-menu"
         class="hidden md:hidden absolute left-4 right-4 top-16 bg-white/95 backdrop-blur-xl border border-slate-200 rounded-xl p-2 shadow-xl z-50 flex flex-col space-y-1">

        <a href="<?= $base ?>index.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
            Beranda
        </a>

        <a href="<?= $base ?>produk/list.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
            Produk
        </a>

        <a href="<?= $base ?>pelanggan/list.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
            Pelanggan
        </a>

        <a href="<?= $base ?>promo.php"
           class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">Promo</a>

        <?php if ($isGuest): ?>
            <a href="<?= $base ?>checkout.php" aria-label="Buka keranjang" class="relative flex h-10 w-10 items-center justify-center rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen transition-colors"><span aria-hidden="true">🛒</span><span class="cart-count absolute right-1 top-1">0</span></a>
            <a href="<?= $base ?>auth/logout.php" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors"><i data-lucide="log-out" class="h-4 w-4"></i>Keluar dari mode tamu</a>
        <?php elseif ($isAdmin): ?>
            <a href="<?= $base ?>pesanan/list.php" class="block px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">Pesanan</a>
            <a href="<?= $base ?>auth/logout.php"
               class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-slate-700 hover:text-white hover:bg-darkgreen text-sm font-medium transition-colors">
                <i data-lucide="log-out" class="h-4 w-4"></i>Keluar
            </a>
        <?php else: ?>
            <a href="<?= $base ?>auth/login.php"
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

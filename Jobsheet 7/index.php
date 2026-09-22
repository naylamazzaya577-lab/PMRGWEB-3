<?php
$pageTitle = 'Taslimiyah Bakery | Keranjang Digital';
include __DIR__ . '/includes/header.php';

if (!isset($_SESSION['produk'])) {
    $_SESSION['produk'] = [];
}
if (!isset($_SESSION['pelanggan'])) {
    $_SESSION['pelanggan'] = [];
}

$totalProduk = count($_SESSION['produk']);
$totalPelanggan = count($_SESSION['pelanggan']);
?>
<main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="relative overflow-hidden rounded-2xl border-2 border-darkgreen bg-white p-8 sm:p-12 mb-8 shadow-md">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-200/50 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-emerald-300/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-900 text-xs font-mono mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>System Active</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900 mb-4">
                Taslimiyah Bakery | Keranjang Digital
            </h1>
            <p class="text-slate-600 text-base sm:text-lg leading-relaxed mb-6">
                Sistem Manajemen dan Belanja Online | Nikmati enaknya roti yang dibuat fresh setiap harinya, Selamat Berbelanja
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="produk/list.php" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-lg bg-darkgreen text-white font-semibold text-sm hover:bg-softgreen transition-colors shadow-sm">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    <span>Daftar Produk</span>
                </a>
                <a href="pelanggan/list.php" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-lg bg-white text-slate-700 font-medium text-sm border border-slate-200 hover:border-darkgreen hover:text-darkgreen transition-colors shadow-sm">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Loyalty Member Taslimiyah Bakrey</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-10">
        <div class="relative overflow-hidden p-6 rounded-xl border-2 border-darkgreen bg-white shadow-sm hover:shadow-md transition-all">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-200/60 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex items-center justify-between mb-3">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-500">Total Produk</span>
                <div class="p-2 rounded-lg bg-emerald-50 text-darkgreen border border-emerald-100">
                    <i data-lucide="box" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative z-10 text-4xl font-extrabold text-slate-900 tracking-tight"><?= $totalProduk ?></div>
            <p class="relative z-10 text-xs text-slate-500 mt-2">Varian roti &amp; kue</p>
        </div>

        <div class="relative overflow-hidden p-6 rounded-xl border-2 border-darkgreen bg-white shadow-sm hover:shadow-md transition-all">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-200/60 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex items-center justify-between mb-3">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-500">Loyalty Member Taslimiyah Bakrey</span>
                <div class="p-2 rounded-lg bg-emerald-50 text-darkgreen border border-emerald-100">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative z-10 text-4xl font-extrabold text-slate-900 tracking-tight"><?= $totalPelanggan ?></div>
            <p class="relative z-10 text-xs text-slate-500 mt-2">Pelanggan terdaftar</p>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>

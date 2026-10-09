<?php
$pageTitle = 'Taslimiyah Bakery | Beranda';
require __DIR__ . '/includes/koneksi.php';
include __DIR__ . '/includes/header.php';

$totalProduk = (int) $pdo->query('SELECT COUNT(*) FROM produk')->fetchColumn();
$totalPelanggan = (int) $pdo->query('SELECT COUNT(*) FROM pelanggan')->fetchColumn();
$isAdmin = !empty($_SESSION['user_id']) && in_array($_SESSION['role'] ?? '', ['admin', 'petugas'], true);
$isGuest = ($_SESSION['mode'] ?? '') === 'guest';
?>
<main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <?php if (!$isAdmin && !$isGuest): ?>
    <div class="fixed inset-0 z-[80] flex items-center justify-center bg-stone-950/45 p-4 backdrop-blur-md">
        <div class="glass-panel w-full max-w-lg rounded-[2rem] p-7 sm:p-9 shadow-2xl">
            <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-darkgreen"><i data-lucide="croissant" class="h-7 w-7"></i></div>
            <p class="text-center text-xs font-bold uppercase tracking-[.25em] text-darkgreen">Taslimiyah Bakery</p>
            <h1 class="mt-3 text-center font-serif text-3xl font-bold text-stone-900">Selamat datang</h1>
            <p class="mt-2 text-center text-sm text-stone-600">Pilih cara masuk untuk mulai menjelajahi bakery kami.</p>
            <div class="mt-7 grid gap-3 sm:grid-cols-2">
                <a href="auth/guest.php" class="glass-button flex min-h-36 flex-col items-center justify-center rounded-2xl p-5 text-center hover:-translate-y-1">
                    <i data-lucide="shopping-bag" class="mb-3 h-7 w-7"></i><strong>Masuk sebagai Guest</strong><span class="mt-1 text-xs text-stone-500">Lihat produk, promo, dan pesan</span>
                </a>
                <a href="auth/login.php" class="glass-button flex min-h-36 flex-col items-center justify-center rounded-2xl p-5 text-center hover:-translate-y-1">
                    <i data-lucide="shield-check" class="mb-3 h-7 w-7"></i><strong>Masuk sebagai Admin</strong><span class="mt-1 text-xs text-stone-500">Kelola toko dan pelanggan</span>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="relative mx-auto max-w-3xl overflow-hidden rounded-2xl border border-white/60 bg-gradient-to-br from-[#164b3a] via-[#123a2d] to-[#1e2e20] p-7 sm:p-12 mb-8 shadow-xl">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-200/50 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-emerald-300/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 mx-auto max-w-2xl text-center">
            <h1 class="mt-4 mb-4 font-serif text-4xl font-bold tracking-tight text-white sm:text-6xl">
                Taslimiyah Bakery
            </h1>
            <p class="text-emerald-50/80 text-base sm:text-lg leading-relaxed mb-7">
                <?= $isAdmin ? 'Panel manajemen toko dan loyalty member.' : 'Nikmati kelezatan roti berkualitas tinggi yang dibuat fresh setiap hari.' ?>
            </p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="produk/list.php" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-[#214f3d] px-5 py-3 text-sm font-semibold text-white shadow-[0_4px_0_#102f24,0_8px_18px_rgba(0,0,0,.2)] transition hover:-translate-y-0.5 hover:bg-[#286249] hover:shadow-[0_5px_0_#102f24,0_10px_20px_rgba(0,0,0,.24)]">
                    <i data-lucide="package" class="w-4 h-4 text-amber-300"></i>
                    <span><?= $isAdmin ? 'Kelola Produk' : 'Lihat Menu' ?></span>
                </a>
                <a href="pelanggan/list.php" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-[#214f3d] px-5 py-3 text-sm font-semibold text-white shadow-[0_4px_0_#102f24,0_8px_18px_rgba(0,0,0,.2)] transition hover:-translate-y-0.5 hover:bg-[#286249] hover:shadow-[0_5px_0_#102f24,0_10px_20px_rgba(0,0,0,.24)]">
                    <i data-lucide="users" class="w-4 h-4 text-amber-300"></i>
                    <span><?= $isAdmin ? 'Kelola Member' : 'Loyalty Member' ?></span>
                </a>
                <?php if ($isGuest): ?>
                    <a href="checkout.php" aria-label="Buka keranjang" class="relative inline-flex items-center justify-center rounded-xl border border-white/20 bg-[#214f3d] px-5 py-3 text-xl text-white shadow-[0_4px_0_#102f24,0_8px_18px_rgba(0,0,0,.2)] transition hover:-translate-y-0.5 hover:bg-[#286249]">
                        <span aria-hidden="true">🛒</span><span class="cart-count absolute -right-1.5 -top-1.5">0</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-3"><span class="text-xs font-semibold uppercase tracking-wider text-stone-500">Pricelist roti</span><i data-lucide="tag" class="h-5 w-5 text-amber-600"></i></div>
            <div class="font-serif text-2xl font-bold text-stone-900">Mulai 5k</div><p class="mt-2 text-xs text-stone-500">Terjangkau &amp; higienis</p>
        </div>
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-500">Total Produk</span>
                <div class="p-2 rounded-lg bg-emerald-50 text-darkgreen border border-emerald-100">
                    <i data-lucide="box" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-4xl font-extrabold text-slate-900 tracking-tight"><?= $totalProduk ?></div>
            <p class="text-xs text-slate-500 mt-2">Varian roti &amp; kue</p>
        </div>

        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-stone-500">Loyalty Member</span>
                <div class="p-2 rounded-lg bg-emerald-50 text-darkgreen border border-emerald-100">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="text-4xl font-extrabold text-slate-900 tracking-tight"><?= $totalPelanggan ?></div>
            <p class="text-xs text-slate-500 mt-2">Pelanggan terdaftar</p>
        </div>
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-3"><span class="text-xs font-semibold uppercase tracking-wider text-stone-500">Jam toko</span><i data-lucide="clock-3" class="h-5 w-5 text-violet-600"></i></div>
            <div class="font-serif text-2xl font-bold text-stone-900">07:00 – 21:00</div><p class="mt-2 text-xs text-stone-500">Buka setiap hari</p>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>

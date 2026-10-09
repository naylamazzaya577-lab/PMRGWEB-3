<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = 'Taslimiyah Bakery | Pricelist';
require __DIR__ . '/../includes/koneksi.php';
$isAdmin = !empty($_SESSION['user_id']) && in_array($_SESSION['role'] ?? '', ['admin', 'petugas'], true);
$isGuest = ($_SESSION['mode'] ?? '') === 'guest';
$query = trim($_GET['q'] ?? '');
$sql = 'SELECT * FROM produk';
$params = [];
if ($query !== '') {
    $sql .= ' WHERE nama_produk ILIKE :kw_name OR kode_produk ILIKE :kw_code OR kategori ILIKE :kw_category';
    $keyword = '%' . $query . '%';
    $params = [':kw_name' => $keyword, ':kw_code' => $keyword, ':kw_category' => $keyword];
}
$sql .= ' ORDER BY kategori, nama_produk';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
$categories = [];
foreach ($products as $product) {
    $categories[$product['kategori']][] = $product;
}
include __DIR__ . '/../includes/header.php';
?>
<main class="mx-auto w-full max-w-7xl flex-grow px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-darkgreen">Fresh from our oven</p>
            <h1 class="mt-2 font-serif text-4xl font-bold text-stone-900">Pricelist Produk</h1>
            <p class="mt-2 text-sm text-stone-500">Pilih kategori kue kering, cake, dan roti all variant.</p>
        </div>
        <?php if ($isAdmin): ?>
            <a href="tambah.php" class="inline-flex items-center gap-2 self-start rounded-xl bg-darkgreen px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-softgreen"><i data-lucide="plus" class="h-4 w-4"></i>Tambah produk</a>
        <?php elseif ($isGuest): ?>
            <a href="../checkout.php" class="inline-flex items-center gap-2 self-start rounded-xl bg-darkgreen px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-softgreen"><i data-lucide="shopping-bag" class="h-4 w-4"></i>Lihat keranjang <span class="cart-count">0</span></a>
        <?php endif; ?>
    </div>

    <form method="get" class="mb-6 flex gap-2">
        <input type="search" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Cari nama produk atau kategori..." class="min-w-0 flex-1 rounded-xl border border-white bg-white/80 px-4 py-3 text-sm shadow-sm outline-none focus:border-darkgreen focus:ring-2 focus:ring-emerald-100">
        <button class="rounded-xl bg-darkgreen px-5 py-3 text-sm font-semibold text-white hover:bg-softgreen">Cari</button>
    </form>

    <?php if (!$products): ?>
        <div class="glass-card p-10 text-center text-stone-500">Belum ada produk yang sesuai.</div>
    <?php endif; ?>
    <?php foreach ($categories as $category => $items): ?>
        <section class="mb-8">
            <div class="mb-4 flex items-center gap-3">
                <h2 class="font-serif text-2xl font-bold text-stone-900"><?= htmlspecialchars($category) ?></h2>
                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-darkgreen"><?= count($items) ?> produk</span>
                <div class="h-px flex-1 bg-emerald-900/10"></div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($items as $product): ?>
                    <article class="glass-card p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-mono text-stone-400"><?= htmlspecialchars($product['kode_produk']) ?></p>
                                <h3 class="mt-2 text-lg font-semibold text-stone-900"><?= htmlspecialchars($product['nama_produk']) ?></h3>
                            </div>
                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-darkgreen"><?= (int) $product['stok'] > 0 ? 'Tersedia' : 'Habis' ?></span>
                        </div>
                        <div class="mt-5 flex items-end justify-between gap-3">
                            <div><p class="text-xs text-stone-500">Harga</p><p class="mt-1 text-xl font-bold text-darkgreen">Rp <?= number_format((float) $product['harga'], 0, ',', '.') ?></p></div>
                            <?php if ($isGuest && (int) $product['stok'] > 0): ?>
                                <button type="button" data-add-to-cart data-id="<?= (int) $product['id'] ?>" data-name="<?= htmlspecialchars($product['nama_produk'], ENT_QUOTES) ?>" data-price="<?= (float) $product['harga'] ?>" data-stock="<?= (int) $product['stok'] ?>" class="rounded-xl bg-darkgreen px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-softgreen">Tambah</button>
                            <?php elseif ($isAdmin): ?>
                                <div class="flex gap-2">
                                    <a href="edit.php?id=<?= (int) $product['id'] ?>" class="rounded-lg border border-emerald-900/10 p-2 text-darkgreen hover:bg-emerald-50" aria-label="Edit produk"><i data-lucide="pencil" class="h-4 w-4"></i></a>
                                    <form class="form-hapus" method="post" action="hapus.php" data-nama="<?= htmlspecialchars($product['nama_produk'], ENT_QUOTES) ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                                        <button class="rounded-lg border border-red-100 p-2 text-red-600 hover:bg-red-50" aria-label="Hapus produk"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-xs text-stone-400">Login sebagai guest untuk memesan</span>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<?php
$pageTitle = 'Taslimiyah Bakery | Daftar Produk';
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$daftarProduk = $pdo->query('SELECT * FROM produk ORDER BY id DESC')->fetchAll();
?>
<main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Daftar Produk</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola stok dan daftar produk Cake dan roti.</p>
        </div>
        <a href="tambah.php" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-lg bg-darkgreen text-white font-semibold text-sm hover:bg-softgreen transition-colors w-fit shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Produk</span>
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-mono">Kode</th>
                        <th scope="col" class="px-6 py-4">Nama Produk</th>
                        <th scope="col" class="px-6 py-4">Kategori</th>
                        <th scope="col" class="px-6 py-4">Harga</th>
                        <th scope="col" class="px-6 py-4">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($daftarProduk)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-slate-400">Belum ada data produk.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarProduk as $p): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono text-darkgreen font-bold"><?= htmlspecialchars($p['kode_produk']) ?></td>
                                <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($p['nama_produk']) ?></td>
                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($p['kategori']) ?></td>
                                <td class="px-6 py-4 font-mono text-slate-600">Rp <?= number_format((float) $p['harga'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4 text-slate-600"><?= (int) $p['stok'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<?php
require __DIR__ . '/../includes/auth.php';
$pageTitle = 'Taslimiyah Bakery | Pesanan';
require __DIR__ . '/../includes/koneksi.php';
$orders = $pdo->query('SELECT * FROM pesanan ORDER BY dibuat_pada DESC LIMIT 100')->fetchAll();
include __DIR__ . '/../includes/header.php';
?>
<main class="mx-auto w-full max-w-7xl flex-grow px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-7"><p class="text-xs font-bold uppercase tracking-[.2em] text-darkgreen">Admin</p><h1 class="mt-2 font-serif text-4xl font-bold text-stone-900">Pesanan Masuk</h1><p class="mt-2 text-sm text-stone-500">Pesanan tersimpan terbaru (maksimal 100).</p></div>
    <div class="space-y-4">
        <?php foreach ($orders as $order): $details = json_decode($order['detail_produk'], true, 512, JSON_THROW_ON_ERROR); ?>
            <article class="glass-card p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-stone-200 pb-4 sm:flex-row sm:items-start sm:justify-between">
                    <div><p class="font-mono text-xs text-darkgreen"><?= htmlspecialchars($order['kode_pesanan']) ?></p><h2 class="mt-1 text-lg font-semibold"><?= htmlspecialchars($order['nama_pelanggan']) ?></h2><p class="text-sm text-stone-500"><?= htmlspecialchars($order['no_hp']) ?> · <?= htmlspecialchars($order['metode_layanan']) ?> · <?= htmlspecialchars($order['metode_bayar']) ?></p></div>
                    <span class="w-fit rounded-full <?= $order['status_pembayaran'] === 'dibayar' ? 'bg-emerald-100 text-darkgreen' : 'bg-amber-100 text-amber-800' ?> px-3 py-1 text-xs font-bold"><?= htmlspecialchars($order['status_pembayaran']) ?></span>
                </div>
                <div class="grid gap-5 pt-4 md:grid-cols-[1fr_auto]">
                    <div><p class="mb-2 text-xs font-bold uppercase tracking-wider text-stone-400">Rincian produk</p><ul class="space-y-1 text-sm"><?php foreach ($details as $item): ?><li><?= htmlspecialchars($item['name']) ?> × <?= (int) $item['quantity'] ?></li><?php endforeach; ?></ul><?php if ($order['metode_layanan'] === 'delivery'): ?><p class="mt-3 text-sm text-stone-500"><?= htmlspecialchars($order['alamat']) ?> · <?= number_format((float) $order['jarak_km'], 1, ',', '.') ?> km</p><?php endif; ?></div>
                    <div class="text-sm md:min-w-48"><p class="text-xs text-stone-400">Total tagihan</p><p class="mt-1 text-xl font-bold text-darkgreen">Rp <?= number_format((float) $order['total'], 0, ',', '.') ?></p><?php if ($order['status_pembayaran'] !== 'dibayar'): ?><form method="post" action="status.php" class="mt-3"><input type="hidden" name="id" value="<?= (int) $order['id'] ?>"><button class="rounded-lg bg-darkgreen px-3 py-2 text-xs font-semibold text-white hover:bg-softgreen">Tandai dibayar</button></form><?php endif; ?></div>
                </div>
            </article>
        <?php endforeach; ?>
        <?php if (!$orders): ?><div class="glass-card p-10 text-center text-stone-500">Belum ada pesanan.</div><?php endif; ?>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

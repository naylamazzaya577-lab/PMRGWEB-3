<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = 'Taslimiyah Bakery | Nota Digital';
require __DIR__ . '/includes/koneksi.php';
$code = trim($_GET['kode'] ?? '');
$stmt = $pdo->prepare('SELECT * FROM pesanan WHERE kode_pesanan = :kode');
$stmt->execute([':kode' => $code]);
$order = $stmt->fetch();
if (!$order || ($_SESSION['last_order_code'] ?? '') !== $code) {
    http_response_code(404);
    include __DIR__ . '/includes/header.php';
    echo '<main class="mx-auto flex w-full max-w-2xl flex-grow items-center justify-center px-4 py-16"><section class="glass-panel rounded-2xl p-8 text-center"><h1 class="font-serif text-2xl font-bold">Nota tidak ditemukan</h1><a class="mt-4 inline-block text-darkgreen underline" href="index.php">Kembali ke beranda</a></section></main>';
    include __DIR__ . '/includes/footer.php';
    exit;
}
$details = json_decode($order['detail_produk'], true, 512, JSON_THROW_ON_ERROR);
include __DIR__ . '/includes/header.php';
?>
<main class="mx-auto flex w-full max-w-2xl flex-grow items-center px-4 py-10">
    <article class="glass-panel w-full rounded-3xl p-6 sm:p-9">
        <div class="text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-darkgreen"><i data-lucide="receipt-text" class="h-7 w-7"></i></div><p class="mt-4 text-xs font-bold uppercase tracking-[.2em] text-darkgreen">Taslimiyah Bakery</p><h1 class="mt-2 font-serif text-3xl font-bold">Nota Digital</h1><p class="mt-2 font-mono text-sm text-stone-500"><?= htmlspecialchars($order['kode_pesanan']) ?></p></div>
        <div class="my-6 border-y border-dashed border-stone-300 py-5 text-sm"><p><strong><?= htmlspecialchars($order['nama_pelanggan']) ?></strong> · <?= htmlspecialchars($order['no_hp']) ?></p><p class="mt-1 text-stone-500"><?= $order['metode_layanan'] === 'pickup' ? 'Pick up di toko' : 'Delivery: ' . htmlspecialchars($order['alamat']) ?></p><p class="mt-1 text-stone-500">Pembayaran: <?= htmlspecialchars($order['metode_bayar']) ?></p></div>
        <div class="space-y-3"><?php foreach ($details as $item): ?><div class="flex justify-between gap-3 text-sm"><span><?= htmlspecialchars($item['name']) ?> × <?= (int) $item['quantity'] ?></span><strong>Rp <?= number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', '.') ?></strong></div><?php endforeach; ?></div>
        <div class="mt-5 space-y-2 border-t border-stone-200 pt-4 text-sm"><div class="flex justify-between"><span>Subtotal</span><span>Rp <?= number_format((float) $order['subtotal'], 0, ',', '.') ?></span></div><div class="flex justify-between"><span>Diskon member</span><span>- Rp <?= number_format((float) $order['diskon'], 0, ',', '.') ?></span></div><div class="flex justify-between"><span>Ongkir</span><span>Rp <?= number_format((float) $order['ongkir'], 0, ',', '.') ?></span></div><div class="flex justify-between border-t border-stone-200 pt-3 text-base font-bold"><span>Total</span><span class="text-darkgreen">Rp <?= number_format((float) $order['total'], 0, ',', '.') ?></span></div></div>
        <p class="mt-5 rounded-xl bg-amber-50 p-3 text-sm text-amber-900"><?= $order['metode_bayar'] === 'Cash' ? 'Silakan tunjukkan nota digital ini saat mengambil pesanan dan lakukan pembayaran cash di toko.' : 'Status pembayaran: menunggu konfirmasi admin. Simpan nota ini dan tunggu detail pembayaran melalui WhatsApp.' ?></p>
        <div class="mt-6 flex flex-wrap justify-center gap-3"><button type="button" onclick="window.print()" class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-stone-50">Cetak nota</button><a href="produk/list.php" class="rounded-xl bg-darkgreen px-4 py-2.5 text-sm font-semibold text-white hover:bg-softgreen">Kembali ke produk</a></div>
    </article>
</main>
<script>localStorage.removeItem('taslimiyah-cart');</script>
<style>@media print { header, footer, button, main > article > div:last-child a { display:none!important } body { background:#fff!important } .glass-panel { box-shadow:none!important; border:0!important } }</style>
<?php include __DIR__ . '/includes/footer.php'; ?>

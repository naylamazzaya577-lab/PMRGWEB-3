<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$wa = preg_replace('/\D+/', '', $_GET['wa'] ?? '');
$text = $_GET['text'] ?? '';
$pageTitle = 'Taslimiyah Bakery | Pendaftaran Berhasil';
include __DIR__ . '/../includes/header.php';
?>
<main class="mx-auto flex w-full max-w-xl flex-grow items-center px-4 py-12">
    <section class="glass-panel w-full rounded-3xl p-8 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-darkgreen"><i data-lucide="badge-check" class="h-8 w-8"></i></div>
        <h1 class="mt-5 font-serif text-3xl font-bold text-stone-900">Kamu resmi jadi member!</h1>
        <p class="mt-2 text-sm text-stone-500">Nomor khusus member ditampilkan pada notifikasi pendaftaran. Simpan kodenya dan gunakan saat pembayaran.</p>
        <?php if ($wa !== '' && $text !== ''): ?><a target="_blank" rel="noopener noreferrer" href="https://wa.me/<?= htmlspecialchars($wa) ?>?text=<?= htmlspecialchars($text) ?>" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-darkgreen px-5 py-3 font-semibold text-white hover:bg-softgreen"><i data-lucide="message-circle" class="h-4 w-4"></i>Buka WhatsApp untuk menyimpan kode</a><?php endif; ?>
        <p class="mt-3 text-xs text-stone-400">WhatsApp akan terbuka dengan pesan siap kirim; pengiriman otomatis memerlukan integrasi WhatsApp Business.</p>
        <a href="list.php" class="mt-5 block text-sm font-medium text-darkgreen hover:underline">Kembali ke member</a>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

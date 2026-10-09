<?php
$pageTitle = 'Taslimiyah Bakery | Loyalty Member';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isAdmin = !empty($_SESSION['user_id']) && in_array($_SESSION['role'] ?? '', ['admin', 'petugas'], true);
$isGuest = ($_SESSION['mode'] ?? '') === 'guest';
require __DIR__ . '/../includes/koneksi.php';
$members = $pdo->query('SELECT * FROM pelanggan ORDER BY id DESC')->fetchAll();
$testimonials = $pdo->query('SELECT isi FROM testimoni WHERE dipublikasikan = TRUE ORDER BY dibuat_pada DESC LIMIT 6')->fetchAll();
include __DIR__ . '/../includes/header.php';
?>
<main class="mx-auto w-full max-w-7xl flex-grow px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-darkgreen">Loyalty Club</p>
            <h1 class="mt-2 font-serif text-4xl font-bold text-stone-900"><?= $isAdmin ? 'Data Member' : 'Pelanggan & Member' ?></h1>
            <p class="mt-2 max-w-2xl text-sm text-stone-500"><?= $isAdmin ? 'Kelola data pelanggan Taslimiyah Bakery.' : 'Daftar jadi member untuk mendapatkan potongan 4% setiap transaksi.' ?></p>
        </div>
        <?php if (!$isAdmin): ?>
            <a href="daftar.php" class="inline-flex items-center gap-2 self-start rounded-xl bg-darkgreen px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-softgreen"><i data-lucide="user-round-plus" class="h-4 w-4"></i>Daftarkan diri</a>
        <?php endif; ?>
    </div>

    <?php if (!$isAdmin): ?>
        <section class="mb-8 grid gap-4 md:grid-cols-3">
            <article class="glass-card p-6"><i data-lucide="cake-slice" class="h-6 w-6 text-darkgreen"></i><h2 class="mt-4 font-serif text-xl font-bold">Rasa yang fresh</h2><p class="mt-2 text-sm text-stone-500">Pilihan kue dan roti dibuat untuk menemani momen spesialmu.</p></article>
            <article class="glass-card p-6"><i data-lucide="badge-percent" class="h-6 w-6 text-amber-600"></i><h2 class="mt-4 font-serif text-xl font-bold">Diskon member 4%</h2><p class="mt-2 text-sm text-stone-500">Masukkan nomor khusus member saat proses pembayaran.</p></article>
            <article class="glass-card p-6"><i data-lucide="heart-handshake" class="h-6 w-6 text-rose-500"></i><h2 class="mt-4 font-serif text-xl font-bold">Cerita dari member</h2><p class="mt-2 text-sm text-stone-500">Bagikan pengalamanmu saat bergabung. Testimoni hanya ditampilkan anonim setelah mendapat persetujuanmu.</p></article>
        </section>
        <section class="mb-8">
            <h2 class="mb-4 font-serif text-2xl font-bold text-stone-900">Testimoni member</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($testimonials as $testimonial): ?><blockquote class="glass-card p-5"><i data-lucide="quote" class="h-5 w-5 text-amber-600"></i><p class="mt-3 text-sm leading-6 text-stone-700">“<?= nl2br(htmlspecialchars($testimonial['isi'])) ?>”</p><footer class="mt-4 text-xs font-semibold text-darkgreen">Member Taslimiyah Bakery</footer></blockquote><?php endforeach; ?>
                <?php if (!$testimonials): ?><p class="text-sm text-stone-500">Belum ada testimoni. Kamu dapat berbagi cerita saat mendaftar sebagai member.</p><?php endif; ?>
            </div>
        </section>
        <section>
            <h2 class="mb-4 font-serif text-2xl font-bold text-stone-900">Loyalty member</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach (array_slice($members, 0, 6) as $member): ?>
                    <article class="glass-card p-5">
                        <div class="flex items-center gap-3"><div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100 font-serif text-lg font-bold text-darkgreen"><i data-lucide="heart" class="h-5 w-5"></i></div><div><h3 class="font-semibold text-stone-900">Member Loyalty</h3><p class="text-xs text-stone-500">Taslimiyah Bakery</p></div></div>
                        <p class="mt-4 text-sm text-stone-500">Terima kasih sudah menjadi bagian dari perjalanan manis kami.</p>
                    </article>
                <?php endforeach; ?>
                <?php if (!$members): ?><p class="text-sm text-stone-500">Belum ada member. Jadilah yang pertama bergabung.</p><?php endif; ?>
            </div>
        </section>
    <?php else: ?>
        <div class="glass-panel overflow-x-auto rounded-2xl">
            <table class="w-full min-w-[680px] text-left text-sm">
                <thead class="border-b border-stone-200/70 text-xs uppercase tracking-wider text-stone-500"><tr><th class="px-5 py-4">Nomor khusus</th><th class="px-5 py-4">Nama</th><th class="px-5 py-4">Gender</th><th class="px-5 py-4">Alamat domisili</th><th class="px-5 py-4">No. HP</th><th class="px-5 py-4 text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-stone-200/60">
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td class="px-5 py-4 font-mono font-bold text-darkgreen"><?= htmlspecialchars($member['kode_pelanggan']) ?></td>
                        <td class="px-5 py-4 font-semibold"><?= htmlspecialchars($member['nama']) ?></td>
                        <td class="px-5 py-4"><?= htmlspecialchars($member['gender'] ?? '—') ?></td>
                        <td class="px-5 py-4"><?= htmlspecialchars($member['alamat']) ?></td>
                        <td class="px-5 py-4"><?= htmlspecialchars($member['no_hp']) ?></td>
                        <td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="edit.php?id=<?= (int) $member['id'] ?>" class="rounded-lg p-2 text-darkgreen hover:bg-emerald-50" aria-label="Edit member"><i data-lucide="pencil" class="h-4 w-4"></i></a><form class="form-hapus" method="post" action="hapus.php" data-nama="<?= htmlspecialchars($member['nama'], ENT_QUOTES) ?>"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $member['id'] ?>"><button class="rounded-lg p-2 text-red-600 hover:bg-red-50" aria-label="Hapus member"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form></div></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$members): ?><tr><td colspan="6" class="px-5 py-8 text-center text-stone-500">Belum ada member terdaftar.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
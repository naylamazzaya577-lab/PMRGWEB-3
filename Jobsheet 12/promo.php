<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/includes/auth.php';

    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'simpan') {
        $judul = trim($_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $jenis = $_POST['jenis'] ?? '';
        $mulai = $_POST['tanggal_mulai'] ?? '';
        $selesai = $_POST['tanggal_selesai'] ?? '';

        $validDate = static function (string $date): bool {
            $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
            return $parsed !== false && $parsed->format('Y-m-d') === $date;
        };

        if (
            $judul === ''
            || strlen($judul) > 150
            || $deskripsi === ''
            || strlen($deskripsi) > 1000
            || !in_array($jenis, ['harian', 'bulanan'], true)
            || !$validDate($mulai)
            || !$validDate($selesai)
            || $selesai < $mulai
        ) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data promo tidak valid. Periksa judul, deskripsi, jenis, dan tanggal.'];
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO promo (judul, deskripsi, jenis, tanggal_mulai, tanggal_selesai)
                 VALUES (:judul, :deskripsi, :jenis, :mulai, :selesai)'
            );
            $stmt->execute([
                ':judul' => $judul,
                ':deskripsi' => $deskripsi,
                ':jenis' => $jenis,
                ':mulai' => $mulai,
                ':selesai' => $selesai,
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Promo berhasil ditambahkan.'];
        }
    } elseif ($aksi === 'hapus') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id < 1) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Promo tidak valid.'];
        } else {
            $stmt = $pdo->prepare('DELETE FROM promo WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Promo berhasil dihapus.'];
        }
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Aksi promo tidak dikenal.'];
    }

    header('Location: promo.php');
    exit;
}

$pageTitle = 'Taslimiyah Bakery | Promo';
$isAdmin = !empty($_SESSION['user_id']) && in_array($_SESSION['role'] ?? '', ['admin', 'petugas'], true);
$today = date('Y-m-d');
$stmt = $pdo->prepare(
    'SELECT * FROM promo
     WHERE tanggal_mulai <= :today AND tanggal_selesai >= :today
     ORDER BY jenis, tanggal_mulai'
);
$stmt->execute([':today' => $today]);
$promos = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<main class="mx-auto w-full max-w-7xl flex-grow px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-8"><p class="text-xs font-bold uppercase tracking-[.2em] text-darkgreen">Special for you</p><h1 class="mt-2 font-serif text-4xl font-bold text-stone-900">Promo Harian &amp; Bulanan</h1><p class="mt-2 text-sm text-stone-500">Promo aktif Taslimiyah Bakery hari ini.</p></div>
    <?php if ($isAdmin): ?>
        <form method="post" action="promo.php" class="glass-panel mb-8 grid gap-4 rounded-2xl p-5 sm:grid-cols-2 lg:grid-cols-6">
            <input type="hidden" name="aksi" value="simpan">
            <input name="judul" required maxlength="150" placeholder="Nama promo" class="rounded-xl border border-stone-200 bg-white/80 px-3 py-2.5 text-sm lg:col-span-2">
            <input name="deskripsi" required maxlength="1000" placeholder="Deskripsi promo" class="rounded-xl border border-stone-200 bg-white/80 px-3 py-2.5 text-sm lg:col-span-2">
            <select name="jenis" class="rounded-xl border border-stone-200 bg-white/80 px-3 py-2.5 text-sm"><option value="harian">Harian</option><option value="bulanan">Bulanan</option></select>
            <button class="rounded-xl bg-darkgreen px-4 py-2.5 text-sm font-semibold text-white hover:bg-softgreen">Tambah promo</button>
            <label class="text-xs text-stone-500">Mulai<input type="date" name="tanggal_mulai" required value="<?= htmlspecialchars($today) ?>" class="mt-1 w-full rounded-lg border border-stone-200 bg-white px-3 py-2 text-sm"></label>
            <label class="text-xs text-stone-500">Berakhir<input type="date" name="tanggal_selesai" required value="<?= htmlspecialchars($today) ?>" class="mt-1 w-full rounded-lg border border-stone-200 bg-white px-3 py-2 text-sm"></label>
        </form>
    <?php endif; ?>
    <div class="grid gap-5 md:grid-cols-2">
        <?php foreach ($promos as $promo): ?>
            <article class="glass-card p-6">
                <div class="flex items-start justify-between"><span class="rounded-full <?= $promo['jenis'] === 'harian' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-darkgreen' ?> px-3 py-1 text-xs font-bold uppercase"><?= htmlspecialchars($promo['jenis']) ?></span>
                    <?php if ($isAdmin): ?><form method="post" action="promo.php" class="form-hapus" data-nama="<?= htmlspecialchars($promo['judul'], ENT_QUOTES) ?>"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= (int) $promo['id'] ?>"><button class="rounded-lg p-2 text-red-600 hover:bg-red-50" aria-label="Hapus promo"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form><?php endif; ?>
                </div>
                <h2 class="mt-4 font-serif text-2xl font-bold text-stone-900"><?= htmlspecialchars($promo['judul']) ?></h2><p class="mt-2 text-sm leading-6 text-stone-600"><?= nl2br(htmlspecialchars($promo['deskripsi'])) ?></p>
                <p class="mt-5 text-xs text-stone-400">Berlaku <?= date('d M Y', strtotime($promo['tanggal_mulai'])) ?>–<?= date('d M Y', strtotime($promo['tanggal_selesai'])) ?></p>
            </article>
        <?php endforeach; ?>
        <?php if (!$promos): ?><div class="glass-card p-8 text-center text-stone-500 md:col-span-2">Belum ada promo aktif hari ini. Nantikan kejutan manis berikutnya!</div><?php endif; ?>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>

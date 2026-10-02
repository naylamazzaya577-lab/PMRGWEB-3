<?php
require __DIR__ . '/../includes/auth.php';
$pageTitle = 'Taslimiyah Bakery | Daftar Pelanggan';
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

// --- Pagination ---
$perHalaman = 5;
$halaman = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($halaman - 1) * $perHalaman;

// --- Pencarian server-side ---
$kataKunci = trim($_GET['q'] ?? '');

$where = '';
$params = [];
if ($kataKunci !== '') {
    $where = 'WHERE nama ILIKE :kw OR kode_pelanggan ILIKE :kw';
    $params[':kw'] = '%' . $kataKunci . '%';
}

$totalBaris = (int) (function () use ($pdo, $where, $params) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pelanggan {$where}");
    $stmt->execute($params);
    return $stmt->fetchColumn();
})();
$totalHalaman = max(1, (int) ceil($totalBaris / $perHalaman));

$sql = "SELECT * FROM pelanggan {$where} ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit', $perHalaman, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarPelanggan = $stmt->fetchAll();

function urlHalamanPelanggan(int $page, string $q): string
{
    $params = ['page' => $page];
    if ($q !== '') {
        $params['q'] = $q;
    }
    return '?' . http_build_query($params);
}
?>
<main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Daftar Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">Segera daftarkan dirimu. Be A Mamber and get 9% discount every payment</p>
        </div>
        <a href="tambah.php" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-lg bg-darkgreen text-white font-semibold text-sm hover:bg-softgreen transition-colors w-fit shadow-sm">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Daftarkan diri</span>
        </a>
    </div>

    <form method="get" action="list.php" class="mb-4 flex gap-2">
        <input
            type="text"
            id="search-input"
            name="q"
            placeholder="Cari kode atau nama pelanggan..."
            value="<?= $kataKunci ?>"
            class="flex-grow px-4 py-2.5 rounded-lg bg-white border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all"
        >
        <button type="submit" class="px-4 py-2.5 rounded-lg bg-darkgreen text-white font-semibold text-sm hover:bg-softgreen transition-colors shadow-sm">
            Cari
        </button>
    </form>

    <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-mono">Kode</th>
                        <th scope="col" class="px-6 py-4">Nama Pelanggan</th>
                        <th scope="col" class="px-6 py-4">Alamat</th>
                        <th scope="col" class="px-6 py-4">No HP</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($daftarPelanggan)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-slate-400">Belum ada data pelanggan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPelanggan as $c): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono text-darkgreen font-bold"><?= htmlspecialchars($c['kode_pelanggan']) ?></td>
                                <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($c['nama']) ?></td>
                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($c['alamat']) ?></td>
                                <td class="px-6 py-4 font-mono text-slate-600"><?= htmlspecialchars($c['no_hp']) ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="edit.php?id=<?= (int) $c['id'] ?>" class="p-2 rounded-lg text-slate-500 hover:text-darkgreen hover:bg-slate-100 transition-colors" title="Edit">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form class="form-hapus" method="post" action="hapus.php" data-nama="<?= htmlspecialchars($c['nama']) ?>">
                                            <input type="hidden" name="id" value="<?= (int) $c['id'] ?>">
                                            <button type="submit" class="p-2 rounded-lg text-red-500 hover:text-white hover:bg-red-500 transition-colors" title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($totalHalaman > 1): ?>
        <div class="flex items-center justify-center gap-2 mt-6">
            <a href="<?= urlHalamanPelanggan(max(1, $halaman - 1), $kataKunci) ?>"
               class="px-3 py-2 rounded-lg text-sm font-medium border border-slate-200 <?= $halaman <= 1 ? 'pointer-events-none text-slate-300' : 'text-slate-600 hover:text-darkgreen hover:bg-slate-100' ?> transition-colors">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>

            <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
                <a href="<?= urlHalamanPelanggan($i, $kataKunci) ?>"
                   class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-medium border transition-colors <?= $i === $halaman ? 'bg-darkgreen text-white border-darkgreen' : 'text-slate-600 border-slate-200 hover:bg-slate-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <a href="<?= urlHalamanPelanggan(min($totalHalaman, $halaman + 1), $kataKunci) ?>"
               class="px-3 py-2 rounded-lg text-sm font-medium border border-slate-200 <?= $halaman >= $totalHalaman ? 'pointer-events-none text-slate-300' : 'text-slate-600 hover:text-darkgreen hover:bg-slate-100' ?> transition-colors">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

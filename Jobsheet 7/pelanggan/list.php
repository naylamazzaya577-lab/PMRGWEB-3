<?php
$pageTitle = 'Taslimiyah Bakery | Daftar Pelanggan';
include __DIR__ . '/../includes/header.php';

// Seed data awal (menggantikan pelanggan.json dari Jobsheet 6) hanya jika
// sesi belum punya data sama sekali.
if (!isset($_SESSION['pelanggan'])) {
    $_SESSION['pelanggan'] = [
        ['kode_pelanggan' => 'C001', 'nama' => 'Dewi Lestari', 'alamat' => 'Bululawang, Malang', 'no_hp' => '081234567890'],
        ['kode_pelanggan' => 'C002', 'nama' => 'Ahmad Fauzi', 'alamat' => 'Krebet Senggrong, Malang', 'no_hp' => '081398765432'],
        ['kode_pelanggan' => 'C003', 'nama' => 'Rina Puspita', 'alamat' => 'Kepanjen, Malang', 'no_hp' => '085711223344'],
        ['kode_pelanggan' => 'C004', 'nama' => 'Bagus Prakoso', 'alamat' => 'Gondanglegi, Malang', 'no_hp' => '082155667788'],
        ['kode_pelanggan' => 'C005', 'nama' => 'Siti Nur Aini', 'alamat' => 'Pakisaji, Malang', 'no_hp' => '088899001122'],
    ];
}

$daftarPelanggan = $_SESSION['pelanggan'];
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

    <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-mono">Kode</th>
                        <th scope="col" class="px-6 py-4">Nama Pelanggan</th>
                        <th scope="col" class="px-6 py-4">Alamat</th>
                        <th scope="col" class="px-6 py-4">No HP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($daftarPelanggan)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-slate-400">Belum ada data pelanggan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPelanggan as $c): ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono text-darkgreen font-bold"><?= htmlspecialchars($c['kode_pelanggan']) ?></td>
                                <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($c['nama']) ?></td>
                                <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($c['alamat']) ?></td>
                                <td class="px-6 py-4 font-mono text-slate-600"><?= htmlspecialchars($c['no_hp']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

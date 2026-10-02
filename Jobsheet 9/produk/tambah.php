<?php
$pageTitle = 'Taslimiyah Bakery | Tambah Produk';
include __DIR__ . '/../includes/header.php';
?>
<main class="flex-grow max-w-2xl w-full mx-auto px-4 sm:px-6 py-10">
    <div class="mb-8">
        <a href="list.php" class="inline-flex items-center space-x-2 text-xs font-mono text-slate-500 hover:text-darkgreen mb-3 transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Kembali ke Daftar Produk</span>
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Tambah Produk Baru</h1>
        <p class="text-slate-500 text-sm mt-1">Masukkan produk baru</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
        <form id="formTambahProduk" method="post" action="proses_tambah.php" class="space-y-5">
            <div>
                <label for="kode" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Kode Produk</label>
                <input type="text" id="kode" name="kode" required placeholder="Contoh: P003" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <div>
                <label for="nama" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Nama Produk</label>
                <input type="text" id="nama" name="nama" required placeholder="Contoh: Brownies Fudgy Cokelat" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kategori" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Kategori</label>
                    <select id="kategori" name="kategori" required class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
                        <option value="Roti">Roti</option>
                        <option value="Cake">Cake</option>
                        <option value="Pastry">Pastry</option>
                        <option value="Snack Box">Snack Box</option>
                        <option value="Kue Kering">Kue Kering</option>
                    </select>
                </div>

                <div>
                    <label for="harga" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" required min="0" placeholder="25000" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
                </div>
            </div>

            <div>
                <label for="stok" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Jumlah Stok</label>
                <input type="number" id="stok" name="stok" required min="0" placeholder="15" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3">
                <a href="list.php" class="px-4 py-2.5 rounded-lg bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 text-sm font-medium transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-lg bg-darkgreen text-white font-semibold text-sm hover:bg-softgreen transition-colors shadow-sm">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Produk</span>
                </button>
            </div>
        </form>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<?php
$pageTitle = 'Taslimiyah Bakery | Daftar Akun';
include __DIR__ . '/../includes/header.php';
?>
<main class="flex-grow max-w-md w-full mx-auto px-4 sm:px-6 py-10">
    <div class="mb-8 text-center">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">Daftar Akun Petugas</h1>
        <p class="text-slate-500 text-sm mt-1">Buat akun untuk mengelola produk & pelanggan</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
        <form method="post" action="proses_register.php" class="space-y-5">
            <div>
                <label for="nama" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <div>
                <label for="username" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Username</label>
                <input type="text" id="username" name="username" required placeholder="Contoh: budi.santoso" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <div>
                <label for="password" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Password</label>
                <input type="password" id="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <div>
                <label for="konfirmasi" class="block text-xs font-mono uppercase tracking-wider text-slate-500 mb-2">Konfirmasi Password</label>
                <input type="password" id="konfirmasi" name="konfirmasi" required minlength="6" placeholder="Ulangi password" class="w-full px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-darkgreen focus:ring-1 focus:ring-darkgreen text-sm transition-all">
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center space-x-2 px-5 py-2.5 rounded-lg bg-darkgreen text-white font-semibold text-sm hover:bg-softgreen transition-colors shadow-sm">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Daftar</span>
            </button>

            <p class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="login.php" class="text-darkgreen font-medium hover:underline">Login di sini</a>
            </p>
        </form>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

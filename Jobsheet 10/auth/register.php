<?php
$pageTitle = 'Taslimiyah Bakery | Akses Admin';
include __DIR__ . '/../includes/header.php';
?>
<main class="mx-auto flex w-full max-w-xl flex-grow items-center px-4 py-12">
    <section class="glass-panel w-full rounded-2xl p-8 text-center">
        <i data-lucide="shield-lock" class="mx-auto h-10 w-10 text-darkgreen"></i>
        <h1 class="mt-4 font-serif text-3xl font-bold text-stone-900">Akses admin dikelola pemilik toko</h1>
        <p class="mt-2 text-sm text-stone-500">Pendaftaran akun admin tidak tersedia untuk publik. Hubungi pemilik toko untuk mendapatkan akses.</p>
        <a href="login.php" class="mt-6 inline-flex rounded-xl bg-darkgreen px-5 py-3 font-semibold text-white hover:bg-softgreen">Kembali ke login admin</a>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

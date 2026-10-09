<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['mode']) && empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
$pageTitle = 'Taslimiyah Bakery | Daftar Member';
include __DIR__ . '/../includes/header.php';
?>
<main class="mx-auto w-full max-w-2xl flex-grow px-4 py-10 sm:px-6">
    <div class="mb-7"><a href="list.php" class="text-sm font-medium text-darkgreen hover:underline">← Kembali ke Loyalty Club</a><h1 class="mt-4 font-serif text-4xl font-bold text-stone-900">Gabung Loyalty Club</h1><p class="mt-2 text-sm text-stone-500">Data dengan tanda * wajib diisi. Nomor khusus akan digunakan untuk diskon 4%.</p></div>
    <form method="post" action="proses_daftar.php" class="glass-panel space-y-5 rounded-2xl p-6 sm:p-8">
        <div><label for="nama" class="mb-2 block text-sm font-medium">Nama lengkap *</label><input id="nama" name="nama" required maxlength="150" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen"></div>
        <div><label for="nohp" class="mb-2 block text-sm font-medium">Nomor HP / WhatsApp *</label><input id="nohp" name="nohp" type="tel" required pattern="[0-9+ -]{8,18}" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen" placeholder="08xxxxxxxxxx"></div>
        <div><label for="gender" class="mb-2 block text-sm font-medium">Gender *</label><select id="gender" name="gender" required class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen"><option value="">Pilih gender</option><option value="Perempuan">Perempuan</option><option value="Laki-laki">Laki-laki</option><option value="Tidak disebutkan">Tidak ingin menyebutkan</option></select></div>
        <div><label for="alamat" class="mb-2 block text-sm font-medium">Alamat domisili, Kepanjen/Malang *</label><textarea id="alamat" name="alamat" rows="3" required maxlength="1000" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen" placeholder="Kecamatan / kelurahan / alamat domisili"></textarea></div>
        <div><label for="testimoni" class="mb-2 block text-sm font-medium">Testimoni <span class="font-normal text-stone-400">(opsional)</span></label><textarea id="testimoni" name="testimoni" rows="3" maxlength="500" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen" placeholder="Bagikan pengalamanmu bersama Taslimiyah Bakery"></textarea><label class="mt-2 flex items-start gap-2 text-xs text-stone-500"><input type="checkbox" name="setuju_testimoni" value="1" class="mt-0.5 accent-darkgreen"><span>Saya setuju testimoni ini ditampilkan secara anonim di halaman member.</span></label></div>
        <button class="w-full rounded-xl bg-darkgreen px-5 py-3 font-semibold text-white transition hover:bg-softgreen">Daftarkan saya</button>
    </form>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

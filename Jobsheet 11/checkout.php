<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (($_SESSION['mode'] ?? '') !== 'guest') {
    header('Location: index.php');
    exit;
}
$pageTitle = 'Taslimiyah Bakery | Pembayaran';
include __DIR__ . '/includes/header.php';
?>
<main class="mx-auto w-full max-w-5xl flex-grow px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-7"><p class="text-xs font-bold uppercase tracking-[.2em] text-darkgreen">Checkout</p><h1 class="mt-2 font-serif text-4xl font-bold text-stone-900">Proses Pembayaran</h1><p class="mt-2 text-sm text-stone-500">Lengkapi detail pesananmu untuk mendapatkan nota digital.</p></div>
    <form id="checkout-form" method="post" action="pesanan/proses.php" class="grid gap-6 lg:grid-cols-[1.1fr_.9fr]">
        <?= csrf_field() ?>
        <div class="space-y-6">
            <section class="glass-panel space-y-4 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-xl font-bold">Informasi pelanggan</h2>
                <div><label for="nama" class="mb-1.5 block text-sm font-medium">Nama *</label><input id="nama" name="nama" required maxlength="150" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen"></div>
                <div><label for="no_hp" class="mb-1.5 block text-sm font-medium">Nomor HP / WhatsApp *</label><input id="no_hp" name="no_hp" type="tel" required pattern="[0-9+ -]{8,18}" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen"></div>
                <div><label for="kode_member" class="mb-1.5 block text-sm font-medium">Kode khusus member <span class="font-normal text-stone-400">(opsional)</span></label><input id="kode_member" name="kode_member" maxlength="30" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 uppercase outline-none focus:border-darkgreen" placeholder="140706, kode member, atau -"><p class="mt-1 text-xs text-stone-400">Kode 140706 mendapat diskon langsung 4%. Kode member terdaftar mendapat diskon 4% setelah diverifikasi. Isi - atau kosong jika bukan member.</p></div>
            </section>
            <section class="glass-panel space-y-4 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-xl font-bold">Metode penerimaan</h2>
                <div class="grid gap-3 sm:grid-cols-2">
                    <label class="cursor-pointer rounded-xl border border-stone-200 bg-white/70 p-4 has-[:checked]:border-darkgreen has-[:checked]:bg-emerald-50"><input type="radio" name="layanan" value="pickup" checked class="accent-darkgreen"> <strong class="ml-1">Pick up</strong><span class="mt-1 block text-xs text-stone-500">Ambil di toko</span></label>
                    <label class="cursor-pointer rounded-xl border border-stone-200 bg-white/70 p-4 has-[:checked]:border-darkgreen has-[:checked]:bg-emerald-50"><input type="radio" name="layanan" value="delivery" class="accent-darkgreen"> <strong class="ml-1">Delivery order</strong><span class="mt-1 block text-xs text-stone-500">Diantar ke alamat</span></label>
                </div>
                <div id="delivery-fields" class="hidden space-y-4 border-t border-stone-200 pt-4">
                    <div><label for="alamat" class="mb-1.5 block text-sm font-medium">Alamat pengantaran *</label><textarea id="alamat" name="alamat" rows="3" maxlength="1000" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen"></textarea></div>
                    <div><label for="jarak_km" class="mb-1.5 block text-sm font-medium">Jarak rute dari toko (km) *</label><input id="jarak_km" name="jarak_km" type="number" min="0.1" max="200" step="0.1" value="1" class="w-full rounded-xl border border-stone-200 bg-white/80 px-4 py-3 outline-none focus:border-darkgreen"><p class="mt-1 text-xs text-stone-500">Toko: Jl. Raya Krebet Senggrong, Demang Jaya 1 No. 55, Bululawang. Masukkan jarak rute yang terlihat di aplikasi peta; jarak tidak dikirim ke layanan peta dari halaman ini.</p></div>
                    <div id="ongkir-note" class="rounded-xl bg-emerald-50 p-3 text-sm text-darkgreen">Gratis ongkir hingga 7,5 km.</div>
                </div>
            </section>
        </div>
        <aside class="space-y-6">
            <section class="glass-panel rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-xl font-bold">Produk yang dibeli</h2>
                <div id="cart-lines" class="mt-4 space-y-3"></div>
                <p id="empty-cart" class="mt-4 hidden rounded-xl bg-amber-50 p-4 text-sm text-amber-900">Keranjang masih kosong. <a class="font-semibold underline" href="produk/list.php">Pilih produk</a>.</p>
                <input type="hidden" name="items_json" id="items-json">
                <div class="mt-5 space-y-2 border-t border-stone-200 pt-4 text-sm">
                    <div class="flex justify-between"><span class="text-stone-500">Subtotal</span><strong id="subtotal-text">Rp 0</strong></div>
                    <div class="flex justify-between"><span class="text-stone-500">Diskon member</span><strong id="discount-text">Rp 0</strong></div>
                    <div class="flex justify-between"><span class="text-stone-500">Ongkir</span><strong id="shipping-text">Rp 0</strong></div>
                    <div class="flex justify-between border-t border-stone-200 pt-3 text-base"><strong>Total</strong><strong id="total-text" class="text-darkgreen">Rp 0</strong></div>
                </div>
                <input type="hidden" id="client-subtotal" name="client_subtotal" value="0">
            </section>
            <section class="glass-panel space-y-3 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-xl font-bold">Metode pembayaran</h2>
                <div id="payment-options" class="space-y-2">
                    <label class="block rounded-xl border border-stone-200 bg-white/70 p-3"><input type="radio" name="metode_bayar" value="QRIS" checked class="accent-darkgreen"> QRIS</label>
                    <label class="block rounded-xl border border-stone-200 bg-white/70 p-3"><input type="radio" name="metode_bayar" value="Transfer" class="accent-darkgreen"> Transfer bank</label>
                    <label class="block rounded-xl border border-stone-200 bg-white/70 p-3"><input type="radio" name="metode_bayar" value="Cash" class="accent-darkgreen"> Cash</label>
                </div>
                <p class="rounded-xl bg-stone-100 p-3 text-xs leading-5 text-stone-500">QRIS dan transfer dicatat sebagai menunggu konfirmasi; admin akan mengirim detail pembayaran setelah pesanan diterima. Cash dibayar langsung saat pesanan diambil atau diterima.</p>
                <button id="submit-order" class="w-full rounded-xl bg-darkgreen px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-softgreen disabled:cursor-not-allowed disabled:opacity-50">Buat pesanan</button>
            </section>
        </aside>
    </form>
</main>
<script>
(() => {
    const form = document.getElementById('checkout-form');
    const cartKey = 'taslimiyah-cart';
    const lines = document.getElementById('cart-lines');
    const serviceFields = document.getElementById('delivery-fields');
    const shippingText = document.getElementById('shipping-text');
    const radioService = [...document.querySelectorAll('input[name="layanan"]')];
    const money = (amount) => 'Rp ' + Math.round(amount).toLocaleString('id-ID');
    const getItems = () => {
        try { return JSON.parse(localStorage.getItem(cartKey) || '[]'); }
        catch (error) { console.error('Keranjang tidak dapat dibaca.', error); return []; }
    };
    const render = () => {
        const items = getItems();
        const subtotal = items.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0);
        document.getElementById('items-json').value = JSON.stringify(items);
        document.getElementById('client-subtotal').value = String(subtotal);
        lines.innerHTML = items.map((item) => `<div class="flex items-center justify-between gap-3 text-sm"><div><p class="font-medium">${escapeText(item.name)}</p><p class="text-xs text-stone-500">${Number(item.quantity)} × ${money(item.price)}</p></div><div class="flex items-center gap-2"><strong>${money(Number(item.quantity) * Number(item.price))}</strong><button type="button" data-remove="${Number(item.id)}" class="rounded p-1 text-red-500" aria-label="Hapus dari keranjang">×</button></div></div>`).join('');
        lines.querySelectorAll('[data-remove]').forEach((button) => button.addEventListener('click', () => {
            localStorage.setItem(cartKey, JSON.stringify(getItems().filter((item) => Number(item.id) !== Number(button.dataset.remove))));
            render();
        }));
        document.getElementById('empty-cart').classList.toggle('hidden', items.length > 0);
        document.getElementById('submit-order').disabled = items.length === 0;
        updateTotals();
    };
    const escapeText = (value) => String(value).replace(/[&<>"']/g, (char) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
    const updateTotals = () => {
        const subtotal = Number(document.getElementById('client-subtotal').value || 0);
        const isDelivery = document.querySelector('input[name="layanan"]:checked').value === 'delivery';
        const km = Math.max(0, Number(document.getElementById('jarak_km').value || 0));
        const shipping = isDelivery && km > 7.5 ? Math.ceil(km - 7.5) * 5000 : 0;
        document.getElementById('subtotal-text').textContent = money(subtotal);
        shippingText.textContent = money(shipping);
        document.getElementById('shipping-text').dataset.amount = String(shipping);
        const code = document.getElementById('kode_member').value.trim();
        const hasMemberCode = code !== '' && code !== '-';
        const discount = hasMemberCode ? Math.round(subtotal * 0.04) : 0;
        const verificationNote = hasMemberCode && code !== '140706' ? ' (menunggu verifikasi)' : '';
        document.getElementById('discount-text').textContent = hasMemberCode ? money(discount) + verificationNote : money(0);
        document.getElementById('total-text').textContent = money(subtotal - discount + shipping);
        const note = document.getElementById('ongkir-note');
        if (!isDelivery || km <= 7.5) note.textContent = 'Gratis ongkir hingga 7,5 km.';
        else note.textContent = `Estimasi ongkir Rp ${Math.ceil(km - 7.5).toLocaleString('id-ID')} × Rp 5.000 = ${money(shipping)}.`;
    };
    const updateService = () => {
        const isDelivery = document.querySelector('input[name="layanan"]:checked').value === 'delivery';
        serviceFields.classList.toggle('hidden', !isDelivery);
        document.getElementById('alamat').required = isDelivery;
        document.getElementById('jarak_km').required = isDelivery;
        updateTotals();
    };
    radioService.forEach((radio) => radio.addEventListener('change', updateService));
    document.getElementById('jarak_km').addEventListener('input', updateTotals);
    document.getElementById('kode_member').addEventListener('input', updateTotals);
    document.getElementById('no_hp').addEventListener('input', updateTotals);
    form.addEventListener('submit', (event) => {
        if (!getItems().length) { event.preventDefault(); return; }
    });
    render();
    updateService();
})();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>

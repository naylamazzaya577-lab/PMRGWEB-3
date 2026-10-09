// assets/js/app.js
// Jobsheet 9: konfirmasi hapus dipindah dari event 'click' (Jobsheet 6/7)
// ke event 'submit' pada <form class="form-hapus">, supaya bisa
// preventDefault() dan benar-benar membatalkan submit kalau user pilih
// "Batal" di dialog konfirmasi.

function initHapusConfirm() {
    const formHapus = document.querySelectorAll('form.form-hapus');

    formHapus.forEach((form) => {
        form.addEventListener('submit', (e) => {
            const nama = form.dataset.nama || 'data ini';
            const yakin = confirm(`Yakin mau hapus ${nama}? Tindakan ini tidak bisa dibatalkan.`);

            if (!yakin) {
                e.preventDefault();
            }
        });
    });
}

// Filter instan client-side untuk baris yang SEDANG tampil di halaman ini
// saja (tidak lintas-halaman). Pencarian lintas-halaman/server tetap lewat
// tombol "Cari" (form GET ke list.php?q=...).
function initFilterTabel() {
    const input = document.getElementById('search-input');
    const tbody = document.querySelector('table tbody');

    if (!input || !tbody) return;

    input.addEventListener('keyup', () => {
        const kata = input.value.toLowerCase();
        const baris = tbody.querySelectorAll('tr');

        baris.forEach((tr) => {
            const teks = tr.textContent.toLowerCase();
            tr.style.display = teks.includes(kata) ? '' : 'none';
        });
    });
}

function getCart() {
    try {
        const cart = JSON.parse(localStorage.getItem('taslimiyah-cart') || '[]');
        return Array.isArray(cart) ? cart : [];
    } catch (error) {
        console.error('Keranjang tidak dapat dibaca.', error);
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem('taslimiyah-cart', JSON.stringify(cart));
    const count = cart.reduce((total, item) => total + Number(item.quantity || 0), 0);
    document.querySelectorAll('.cart-count').forEach((node) => {
        node.textContent = String(count);
    });
}

function initCart() {
    saveCart(getCart());
    document.querySelectorAll('[data-add-to-cart]').forEach((button) => {
        button.addEventListener('click', () => {
            const cart = getCart();
            const id = Number(button.dataset.id);
            const existing = cart.find((item) => Number(item.id) === id);
            const stock = Number(button.dataset.stock || 0);
            const maxQuantity = Math.min(50, stock);
            if (existing && Number(existing.quantity) >= maxQuantity) {
                window.alert('Jumlah pilihan sudah mencapai stok produk.');
                return;
            }
            if (existing) existing.quantity = Number(existing.quantity || 0) + 1;
            else cart.push({
                id,
                name: button.dataset.name,
                price: Number(button.dataset.price),
                quantity: 1
            });
            saveCart(cart);
            button.textContent = 'Ditambahkan';
            window.setTimeout(() => { button.textContent = 'Tambah'; }, 1000);
        });
    });
}

document.addEventListener('DOMContentLoaded', initCart);

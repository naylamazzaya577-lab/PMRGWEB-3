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

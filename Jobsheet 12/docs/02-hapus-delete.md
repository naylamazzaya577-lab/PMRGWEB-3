# 2. Fitur Hapus (Delete)

## 2.1 Melengkapi CRUD Jadi Penuh

Dengan Edit di bab sebelumnya, tinggal satu operasi lagi yang belum
ada: **Delete**. `produk/hapus.php` dan `pelanggan/hapus.php`
menyelesaikan siklus CRUD (Create, Read, Update, Delete) penuh.

## 2.2 Kenapa Harus POST, Bukan GET

Kalau tombol hapus dibuat sebagai link biasa (`<a href="hapus.php?id=5">`),
ada risiko nyata:

- **Search engine crawler** yang otomatis mengunjungi semua `<a href>`
  di halaman bisa "tidak sengaja" memicu penghapusan data, karena bagi
  browser/crawler, GET request dianggap aman untuk diakses berulang.
- Link **bisa di-*prefetch*** oleh sebagian browser tanpa user benar-benar
  mengklik.

Makanya `hapus.php` sengaja menolak request selain POST:

```php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}
```

Supaya bisa POST, tombol hapus di `list.php` dibungkus `<form
method="post" action="hapus.php">` sungguhan — bukan `<button>` polos
yang cuma didekorasi tampil seperti tombol.

## 2.3 Konfirmasi Sebelum Submit

Karena hapus itu tindakan permanen, `assets/js/app.js`
(`initHapusConfirm`) memasang listener di event **`submit`** form
`.form-hapus`, bukan event **`click`** tombolnya:

```js
form.addEventListener('submit', (e) => {
    const yakin = confirm(`Yakin mau hapus ${nama}?`);
    if (!yakin) e.preventDefault();
});
```

Bedanya penting: kalau listener dipasang di `click`, form tetap akan
ter-submit meskipun user klik "Batal" di dialog, karena event `click`
tidak bisa membatalkan proses submit form yang sudah berjalan.
`submit` bisa, lewat `e.preventDefault()`.

## 2.4 Kenapa Hapus Langsung di `hapus.php` (Bukan `proses_hapus.php`)

Beda dengan tambah/edit yang butuh dua halaman (form + proses),
hapus tidak punya form input apa pun untuk ditampilkan — cuma butuh
`id` mana yang mau dihapus (dikirim dari `list.php` lewat hidden
input). Jadi `hapus.php` langsung berperan sebagai "proses"-nya
sekaligus, tanpa perlu halaman tampilan terpisah.

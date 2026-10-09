# 1. Fitur Edit (Update)

## 1.1 Kenapa Butuh Update

Sejak Jobsheet 8, data produk & pelanggan sudah tersimpan permanen di
PostgreSQL — tapi baru bisa **Create** (tambah) dan **Read** (tampil).
Kalau ada salah ketik saat nambah data, satu-satunya cara memperbaikinya
adalah hapus manual lewat database langsung. Jobsheet 9 menutup celah
ini dengan menambahkan **Update** lewat halaman `edit.php`.

## 1.2 Alur Dua Halaman: `edit.php` + `proses_edit.php`

Polanya sama persis dengan `tambah.php` + `proses_tambah.php` dari
Jobsheet 8, cuma ada dua bedanya:

1. **`edit.php` mengambil data lama dulu** lewat `SELECT * FROM produk
   WHERE id = :id`, lalu isi form (`value="..."`) diisi dari data itu —
   supaya user lihat data yang mau diedit, bukan form kosong.
2. **`proses_edit.php` menjalankan `UPDATE`, bukan `INSERT`**, dan
   query-nya selalu diakhiri `WHERE id = :id` supaya cuma baris itu
   yang berubah, bukan semua baris di tabel.

```php
$sql = 'UPDATE produk
        SET kode_produk = :kode, nama_produk = :nama,
            kategori = :kategori, harga = :harga, stok = :stok
        WHERE id = :id';
```

## 1.3 Kenapa `id` yang Dipakai, Bukan `kode_produk`

`kode_produk` bisa saja diubah user lewat form edit (misal dari `P003`
jadi `P003B`). Kalau `WHERE`-nya pakai `kode_produk`, begitu kode
berubah di tengah request, query bisa salah sasaran. `id` dari kolom
`SERIAL` itu ditentukan otomatis oleh database dan **tidak pernah
berubah** seumur hidup baris itu — makanya dia yang paling aman dipakai
sebagai penunjuk baris mana yang mau di-update, dikirim lewat
`<input type="hidden" name="id" value="...">` di form.

## 1.4 Validasi Tetap Sama

Aturan validasi di `proses_edit.php` sama persis dengan
`proses_tambah.php` (kode/nama wajib diisi, kategori harus salah satu
dari pilihan yang valid, harga & stok harus angka ≥ 0) — bedanya kalau
gagal, redirect-nya balik ke `edit.php?id=...` (bukan `tambah.php`),
supaya user tetap di form edit yang sama, bukan disuruh mulai dari nol.

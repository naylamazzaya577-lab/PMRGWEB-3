# 4. Rangkuman & Latihan Lanjutan

## 4.1 Rangkuman Keseluruhan Jobsheet 9

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Edit/Update](01-update-edit.md) | `edit.php` prefill form dari `SELECT ... WHERE id`, `proses_edit.php` pakai `UPDATE ... WHERE id`, kenapa `id` lebih aman dipakai daripada kode |
| [Hapus/Delete](02-hapus-delete.md) | Kenapa harus POST bukan GET, form sungguhan vs tombol polos, konfirmasi di event `submit` |
| [Pagination & Pencarian](03-pagination-pencarian.md) | `LIMIT`/`OFFSET`, `COUNT(*)` buat total halaman, `ILIKE` buat pencarian case-insensitive, menjaga `q` tetap ada lintas halaman |

## 4.2 Konsep Inti yang Perlu Diingat

1. **CRUD sekarang lengkap** — Create & Read dari Jobsheet 8, Update &
   Delete dari Jobsheet 9. Ini pola dasar yang dipakai di hampir semua
   aplikasi berbasis data.
2. **`id` (bukan kode buatan user) adalah kunci yang aman** untuk
   menyasar satu baris spesifik di `UPDATE`/`DELETE`, karena nilainya
   otomatis dan tidak pernah berubah.
3. **Method HTTP itu penting secara semantik** — GET untuk membaca
   data (aman diulang-ulang), POST untuk mengubah data (tidak boleh
   terpicu tanpa sengaja). Delete lewat GET adalah kesalahan desain
   yang cukup umum ditemukan di aplikasi pemula.
4. **Pagination & pencarian bekerja di lapisan database**, bukan di
   PHP/JavaScript sesudah semua data diambil — ini jauh lebih efisien
   karena PostgreSQL hanya mengirim baris yang benar-benar dibutuhkan.

## 4.3 Cara Mencoba Sendiri

1. Jalankan `php -S localhost:8000`, buka `http://localhost:8000/index.php`.
2. Uji siklus CRUD penuh: tambah produk baru → cek muncul di list →
   klik ikon pensil (Edit) → ubah harga → simpan → cek harga berubah
   di list → klik ikon tempat sampah (Hapus) → konfirmasi → cek baris
   hilang dari list.
3. Tambahkan lebih dari 5 produk, perhatikan tombol-tombol nomor
   halaman muncul di bawah tabel.
4. Ketik sesuatu di kolom pencarian tanpa klik "Cari" dulu — amati
   baris yang sedang tampil langsung tersaring (filter client-side).
5. Klik tombol "Cari" — amati URL berubah jadi `?q=...` dan hasil
   pencarian mencakup SEMUA data, bukan cuma 5 baris yang tadi tampil.
6. Coba akses `hapus.php` langsung lewat address bar browser (GET) —
   amati request ditolak dan diarahkan balik ke `list.php` tanpa ada
   data yang terhapus.

## 4.4 Ide Latihan Tambahan (Opsional)

1. **Perbaiki celah XSS di kolom pencarian** — bungkus nilai `q` dengan
   `htmlspecialchars()` sebelum ditampilkan ke atribut `value`, lalu
   coba masukkan `"><script>alert(1)</script>` ke kolom pencarian
   sebelum dan sesudah perbaikan untuk melihat bedanya.
2. **Tambah konfirmasi ganda untuk Edit** — tampilkan flash message
   "Tidak ada perubahan" kalau user submit form edit tanpa mengubah
   nilai apa pun.
3. **Gabungkan sort dengan pencarian** — tambahkan dropdown "Urutkan
   berdasarkan: Nama / Harga / Stok" yang mengubah klausa `ORDER BY`
   di query, tetap mempertahankan `q` dan `page` yang sedang aktif.
4. **Soft delete** — daripada `DELETE` beneran, tambah kolom
   `dihapus_pada TIMESTAMP NULL`, lalu `hapus.php` cuma mengisi kolom
   itu dengan `NOW()` dan query `list.php` menambahkan
   `WHERE dihapus_pada IS NULL` — data lama tidak benar-benar hilang
   dan bisa "dipulihkan" nanti.

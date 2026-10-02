# 3. Pagination & Pencarian Server-Side

## 3.1 Kenapa Butuh Pagination

Sebelum Jobsheet 9, `list.php` menampilkan **semua** baris tabel
sekaligus lewat `SELECT * FROM produk ORDER BY id DESC`. Ini masih
oke waktu datanya cuma belasan baris, tapi begitu tabel berisi ratusan
atau ribuan baris, ini jadi masalah: satu halaman jadi berat dimuat,
dan user harus scroll panjang buat cari satu data.

## 3.2 Rumus `LIMIT` / `OFFSET`

Pagination bekerja dengan membagi hasil query jadi potongan-potongan
kecil (5 baris per halaman di project ini):

```php
$perHalaman = 5;
$halaman = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($halaman - 1) * $perHalaman;
```

- Halaman 1 → `OFFSET 0` (baris ke-1 sampai 5)
- Halaman 2 → `OFFSET 5` (baris ke-6 sampai 10)
- Halaman 3 → `OFFSET 10` (baris ke-11 sampai 15)

Lalu ditempel ke query: `LIMIT :limit OFFSET :offset`. `max(1, ...)`
di baris kedua mencegah orang iseng akses `?page=0` atau `?page=-5`
yang bisa bikin `OFFSET` jadi negatif dan error di PostgreSQL.

## 3.3 Menghitung Total Halaman

Supaya tombol-tombol nomor halaman (1, 2, 3, ...) bisa digambar, perlu
tahu dulu berapa total baris yang ada **sebelum** `LIMIT` dipotong —
makanya ada query kedua yang terpisah:

```php
$totalBaris = SELECT COUNT(*) FROM produk [WHERE ...];
$totalHalaman = ceil($totalBaris / $perHalaman);
```

## 3.4 Pencarian Server-Side dengan `ILIKE`

`ILIKE` adalah operator pencocokan teks khas PostgreSQL yang **tidak
peduli huruf besar/kecil** (beda dengan `LIKE` biasa yang case-sensitive).
Dikombinasikan dengan wildcard `%`:

```php
$where = 'WHERE nama_produk ILIKE :kw OR kode_produk ILIKE :kw';
$params[':kw'] = '%' . $kataKunci . '%';
```

`%roti%` akan cocok dengan "Roti Tawar", "roti sobek", atau "Croissant
**Roti**" — di mana pun kata "roti" muncul dalam teks, tanpa peduli
besar-kecil huruf.

## 3.5 Menjaga Kata Kunci Tetap Ada Saat Pindah Halaman

Kalau user cari "roti" lalu klik "Halaman 2", pencarian tidak boleh
hilang. Makanya setiap link halaman dibangun lewat helper
`urlHalaman()` yang selalu menyertakan `q` (kalau ada):

```php
function urlHalaman(int $page, string $q): string {
    $params = ['page' => $page];
    if ($q !== '') $params['q'] = $q;
    return '?' . http_build_query($params);
}
```

Hasilnya link jadi `?page=2&q=roti`, bukan cuma `?page=2` yang bakal
mereset pencarian.

## 3.6 Dua Peran Kolom Pencarian (`#search-input`)

Input pencarian di halaman ini sengaja melayani **dua peran sekaligus**:

1. **Filter instan client-side** (JS, `initFilterTabel` di `app.js`) —
   begitu user mengetik, baris-baris yang SEDANG tampil di halaman ini
   langsung disembunyikan/dimunculkan tanpa reload. Tapi ini cuma
   menyaring 5 baris yang sedang dimuat, bukan seluruh data di database.
2. **Pencarian penuh lintas-halaman** (server-side) — begitu tombol
   "Cari" diklik, form melakukan GET request ke `list.php?q=...`, dan
   PostgreSQL yang mencari lewat SEMUA baris di tabel, tidak dibatasi
   halaman yang sedang tampil.

> **Catatan keamanan (sengaja belum diperbaiki):** nilai `q` yang
> ditampilkan kembali ke atribut `value` pada input pencarian
> **tidak di-escape** dengan `htmlspecialchars()`. Ini artinya kalau
> seseorang mengisi `q` dengan karakter HTML/JavaScript tertentu, itu
> bisa dieksekusi balik ke halaman (celah XSS). Ini sengaja dibiarkan
> apa adanya di jobsheet ini sebagai bahan pembelajaran — audit dan
> perbaikan XSS menyeluruh dilakukan di Jobsheet 11.

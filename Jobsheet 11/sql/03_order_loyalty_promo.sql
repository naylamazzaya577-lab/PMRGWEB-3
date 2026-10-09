-- Jalankan sekali pada database Jobsheet 10 yang sudah memiliki tabel produk,
-- pelanggan, dan users: psql -d neondb -f sql/03_order_loyalty_promo.sql
ALTER TABLE pelanggan
    ADD COLUMN IF NOT EXISTS gender VARCHAR(20) NOT NULL DEFAULT 'Tidak disebutkan';

CREATE TABLE IF NOT EXISTS pesanan (
    id              BIGSERIAL PRIMARY KEY,
    kode_pesanan    VARCHAR(30) NOT NULL UNIQUE,
    nama_pelanggan  VARCHAR(150) NOT NULL,
    no_hp           VARCHAR(20) NOT NULL,
    kode_member     VARCHAR(30),
    metode_layanan  VARCHAR(20) NOT NULL CHECK (metode_layanan IN ('pickup', 'delivery')),
    alamat          TEXT,
    jarak_km        NUMERIC(7, 2) NOT NULL DEFAULT 0,
    subtotal        NUMERIC(12, 2) NOT NULL,
    diskon          NUMERIC(12, 2) NOT NULL DEFAULT 0,
    ongkir          NUMERIC(12, 2) NOT NULL DEFAULT 0,
    total            NUMERIC(12, 2) NOT NULL,
    metode_bayar    VARCHAR(30) NOT NULL,
    status_pembayaran VARCHAR(20) NOT NULL DEFAULT 'menunggu',
    detail_produk   JSONB NOT NULL,
    dibuat_pada     TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS promo (
    id              BIGSERIAL PRIMARY KEY,
    judul           VARCHAR(150) NOT NULL,
    deskripsi       TEXT NOT NULL,
    jenis           VARCHAR(20) NOT NULL CHECK (jenis IN ('harian', 'bulanan')),
    tanggal_mulai   DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    dibuat_pada     TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS testimoni (
    id              BIGSERIAL PRIMARY KEY,
    pelanggan_id    INTEGER NOT NULL REFERENCES pelanggan(id) ON DELETE CASCADE,
    isi             TEXT NOT NULL,
    dipublikasikan  BOOLEAN NOT NULL DEFAULT TRUE,
    dibuat_pada     TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

INSERT INTO promo (judul, deskripsi, jenis, tanggal_mulai, tanggal_selesai)
SELECT 'Fresh from the oven', 'Nikmati roti pilihan yang baru dipanggang setiap hari.', 'harian', CURRENT_DATE, CURRENT_DATE
WHERE NOT EXISTS (SELECT 1 FROM promo WHERE judul = 'Fresh from the oven');

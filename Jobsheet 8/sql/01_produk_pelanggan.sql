-- sql/01_produk_pelanggan.sql
-- Dijalankan dengan: psql -d taslimiyah_bakery -f sql/01_produk_pelanggan.sql

CREATE TABLE IF NOT EXISTS produk (
    id           SERIAL PRIMARY KEY,
    kode_produk  VARCHAR(20)     NOT NULL UNIQUE,
    nama_produk  VARCHAR(150)    NOT NULL,
    kategori     VARCHAR(50)     NOT NULL,
    harga        NUMERIC(12, 2)  NOT NULL DEFAULT 0,
    stok         INTEGER         NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS pelanggan (
    id              SERIAL PRIMARY KEY,
    kode_pelanggan  VARCHAR(20)   NOT NULL UNIQUE,
    nama            VARCHAR(150)  NOT NULL,
    alamat          TEXT          NOT NULL,
    no_hp           VARCHAR(20)   NOT NULL
);


-- sql/01_produk_pelanggan.sql
-- Skema dasar (ERD sederhana) untuk Taslimiyah Bakery
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

-- Data awal (opsional, menggantikan seed session dari Jobsheet 7)
INSERT INTO produk (kode_produk, nama_produk, kategori, harga, stok) VALUES
    ('P001', 'Roti Tawar Premium', 'Roti', 18000, 25),
    ('P002', 'Roti Sobek Coklat Keju', 'Roti', 22000, 18),
    ('P003', 'Black Forest Cake', 'Cake', 135000, 6),
    ('P004', 'Red Velvet Cake', 'Cake', 145000, 4),
    ('P005', 'Brownies Panggang Fudgy', 'Pastry', 45000, 12),
    ('P006', 'Croissant Butter', 'Pastry', 15000, 30)
ON CONFLICT (kode_produk) DO NOTHING;

INSERT INTO pelanggan (kode_pelanggan, nama, alamat, no_hp) VALUES
    ('C001', 'Dewi Lestari', 'Bululawang, Malang', '081234567890'),
    ('C002', 'Ahmad Fauzi', 'Krebet Senggrong, Malang', '081398765432'),
    ('C003', 'Rina Puspita', 'Kepanjen, Malang', '085711223344'),
    ('C004', 'Bagus Prakoso', 'Gondanglegi, Malang', '082155667788'),
    ('C005', 'Siti Nur Aini', 'Pakisaji, Malang', '088899001122')
ON CONFLICT (kode_pelanggan) DO NOTHING;

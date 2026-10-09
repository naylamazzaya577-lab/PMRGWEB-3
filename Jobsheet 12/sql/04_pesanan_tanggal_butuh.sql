-- Revisi: kolom "kue dibutuhkan tanggal & jam berapa" pada pesanan.
-- Aplikasi (pesanan/proses.php) juga menjalankan perintah ini otomatis
-- (IF NOT EXISTS, aman dijalankan berulang), tapi boleh dijalankan manual:
-- psql -d neondb -f sql/04_pesanan_tanggal_butuh.sql
ALTER TABLE pesanan
    ADD COLUMN IF NOT EXISTS tanggal_butuh TIMESTAMPTZ;

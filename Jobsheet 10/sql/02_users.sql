-- sql/02_users.sql
-- Dijalankan dengan: psql -d taslimiyah_bakery -f sql/02_users.sql

CREATE TABLE IF NOT EXISTS users (
    id        SERIAL PRIMARY KEY,
    nama      VARCHAR(150) NOT NULL,
    username  VARCHAR(50)  NOT NULL UNIQUE,
    password  VARCHAR(255) NOT NULL,
    role      VARCHAR(20)  NOT NULL DEFAULT 'petugas'
);

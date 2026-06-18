-- =====================================================
-- DATABASE: db_mahasiswa
-- Aplikasi CRUD Akademik (Mahasiswa, Dosen, Matkul, Jadwal)
-- =====================================================

CREATE DATABASE IF NOT EXISTS db_mahasiswa;
USE db_mahasiswa;

-- 1. Tabel Pengguna (Login)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- 2. Tabel Mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    jurusan VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- 3. Tabel Dosen
CREATE TABLE IF NOT EXISTS dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat VARCHAR(255) NOT NULL
);

-- 4. Tabel Mata Kuliah
CREATE TABLE IF NOT EXISTS matkul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matkul VARCHAR(100) NOT NULL,
    sks INT NOT NULL
);

-- 5. Tabel Jadwal (relasi ke dosen & matkul)
CREATE TABLE IF NOT EXISTS jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_dosen INT NOT NULL,
    id_matkul INT NOT NULL,
    waktu VARCHAR(100) NOT NULL,
    ruang VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_dosen) REFERENCES dosen(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matkul) REFERENCES matkul(id) ON DELETE CASCADE
);

-- 6. Akun Admin Default (Username: admin, Password: admin123)
-- Password di-hash menggunakan password_hash() PHP demi keamanan.
-- CATATAN: Hash di bawah adalah hash valid untuk "admin123".
INSERT INTO users (username, password) VALUES
('admin', '$2b$12$A6WvYA/FWES/BkRgCPTWdOO565W8Bmc12yG7Qw38QhLzD2Q3oGRry')
ON DUPLICATE KEY UPDATE username = username;

-- =====================================================
-- DATA CONTOH (opsional, untuk testing)
-- =====================================================
INSERT INTO dosen (nama, alamat) VALUES
('Dr. Budi Santoso, M.Kom', 'Jl. Merdeka No. 10, Tangerang'),
('Siti Aminah, S.Kom, M.T', 'Jl. Pamulang Raya No. 5, Tangsel');

INSERT INTO matkul (matkul, sks) VALUES
('Pemrograman Web', 3),
('Basis Data', 3),
('Riset Operasional', 2);

INSERT INTO jadwal (id_dosen, id_matkul, waktu, ruang) VALUES
(1, 1, 'Senin, 08:00 - 10:30', 'Lab Komputer 1'),
(2, 2, 'Selasa, 13:00 - 15:30', 'Ruang 304');

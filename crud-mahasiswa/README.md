# Aplikasi CRUD Akademik (Mahasiswa, Dosen, Mata Kuliah, Jadwal)

Aplikasi CRUD berbasis **PHP Native + MySQL + Fetch API (AJAX) + Bootstrap 5**.
Pengembangan dari tugas CRUD Mahasiswa, ditambah 3 entitas baru: **Dosen**, **Mata Kuliah**, dan **Jadwal** (dengan relasi).

## Daftar File

| File | Fungsi |
|------|--------|
| `database.sql` | Struktur database + tabel + data contoh |
| `koneksi.php` | Koneksi ke MySQL |
| `login.php` | Halaman login (autentikasi session) |
| `logout.php` | Menghapus session |
| `index.php` | Dashboard utama dengan 4 tab menu |
| `api.php` | Backend RESTful (semua proses CRUD → JSON) |
| `script.js` | Frontend AJAX (Fetch API, manipulasi DOM) |

## Langkah Instalasi

1. **Salin folder** `crud-mahasiswa` ke `C:\xampp\htdocs\`

2. **Jalankan XAMPP** → start **Apache** dan **MySQL**

3. **Import database:**
   - Buka `http://localhost/phpmyadmin/`
   - Klik tab **SQL**
   - Copy-paste seluruh isi `database.sql`, lalu klik **Go**
   - Atau: buat database `db_mahasiswa`, lalu menu **Import** → pilih `database.sql`

4. **Akses aplikasi:** buka `http://localhost/crud-mahasiswa/login.php`

5. **Login default:**
   - Username: `admin`
   - Password: `admin123`

## Struktur Tabel Baru

```
dosen   (id, nama, alamat)
matkul  (id, matkul, sks)
jadwal  (id, id_dosen, id_matkul, waktu, ruang)
```

Tabel `jadwal` memiliki **FOREIGN KEY** ke `dosen` dan `matkul`. Pada form jadwal,
pilihan dosen & mata kuliah berupa **dropdown otomatis** dari data yang ada
(bukan ketik ID manual), sehingga relasi data tetap rapi dan valid.

## Catatan Teknis

- Penghapusan dosen/matkul memakai `ON DELETE CASCADE` — jadwal yang memakai
  dosen/matkul tersebut ikut terhapus otomatis agar tidak ada data jadwal "yatim".
- Output tabel di-escape (anti-XSS) lewat fungsi `esc()` di `script.js`.
- Semua proses CRUD berjalan tanpa reload halaman (AJAX Fetch API).

## Jika ingin mengganti password admin

Buat file sementara `buat_hash.php`, jalankan sekali, lalu hapus:

```php
<?php
echo password_hash("password_baru_anda", PASSWORD_DEFAULT);
?>
```

Salin hasilnya ke kolom `password` tabel `users` di phpMyAdmin.

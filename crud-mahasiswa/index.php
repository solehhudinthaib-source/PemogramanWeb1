<?php
session_start();
// Proteksi halaman: Jika belum login, tendang kembali ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Akademik</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">SIAKAD Universitas</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container my-5">

        <!-- Tab Navigasi Menu -->
        <ul class="nav nav-tabs mb-4" id="menuTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-mahasiswa" data-bs-toggle="tab" data-bs-target="#pane-mahasiswa" type="button" role="tab">Mahasiswa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-dosen" data-bs-toggle="tab" data-bs-target="#pane-dosen" type="button" role="tab">Dosen</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-matkul" data-bs-toggle="tab" data-bs-target="#pane-matkul" type="button" role="tab">Mata Kuliah</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-jadwal" data-bs-toggle="tab" data-bs-target="#pane-jadwal" type="button" role="tab">Jadwal</button>
            </li>
        </ul>

        <div class="tab-content" id="menuTabContent">

            <!-- ====================== TAB MAHASISWA ====================== -->
            <div class="tab-pane fade show active" id="pane-mahasiswa" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Daftar Mahasiswa</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mahasiswaModal" onclick="siapkanTambahMhs()">+ Tambah Mahasiswa</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>NIM</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jurusan</th>
                                        <th>Email</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tempat-data-mahasiswa"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================== TAB DOSEN ====================== -->
            <div class="tab-pane fade" id="pane-dosen" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Daftar Dosen</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dosenModal" onclick="siapkanTambahDosen()">+ Tambah Dosen</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Nama Dosen</th>
                                        <th>Alamat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tempat-data-dosen"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================== TAB MATA KULIAH ====================== -->
            <div class="tab-pane fade" id="pane-matkul" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Daftar Mata Kuliah</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#matkulModal" onclick="siapkanTambahMatkul()">+ Tambah Mata Kuliah</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tempat-data-matkul"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================== TAB JADWAL ====================== -->
            <div class="tab-pane fade" id="pane-jadwal" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Daftar Jadwal Kuliah</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jadwalModal" onclick="siapkanTambahJadwal()">+ Tambah Jadwal</button>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen Pengampu</th>
                                        <th>Waktu</th>
                                        <th>Ruang</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tempat-data-jadwal"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ============================================================= -->
    <!-- MODAL: MAHASISWA                                              -->
    <!-- ============================================================= -->
    <div class="modal fade" id="mahasiswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleMhs">Form Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formMahasiswa" onsubmit="simpanMahasiswa(event)">
                    <div class="modal-body">
                        <input type="hidden" id="mahasiswa_id" name="id">
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================= -->
    <!-- MODAL: DOSEN                                                  -->
    <!-- ============================================================= -->
    <div class="modal fade" id="dosenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleDosen">Form Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formDosen" onsubmit="simpanDosen(event)">
                    <div class="modal-body">
                        <input type="hidden" id="dosen_id" name="id">
                        <div class="mb-3">
                            <label for="dosen_nama" class="form-label">Nama Dosen</label>
                            <input type="text" class="form-control" id="dosen_nama" name="nama" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="dosen_alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="dosen_alamat" name="alamat" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================= -->
    <!-- MODAL: MATA KULIAH                                            -->
    <!-- ============================================================= -->
    <div class="modal fade" id="matkulModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleMatkul">Form Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formMatkul" onsubmit="simpanMatkul(event)">
                    <div class="modal-body">
                        <input type="hidden" id="matkul_id" name="id">
                        <div class="mb-3">
                            <label for="matkul_nama" class="form-label">Nama Mata Kuliah</label>
                            <input type="text" class="form-control" id="matkul_nama" name="matkul" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="matkul_sks" class="form-label">SKS</label>
                            <input type="number" class="form-control" id="matkul_sks" name="sks" min="1" max="6" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================= -->
    <!-- MODAL: JADWAL (dengan dropdown relasi)                        -->
    <!-- ============================================================= -->
    <div class="modal fade" id="jadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleJadwal">Form Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formJadwal" onsubmit="simpanJadwal(event)">
                    <div class="modal-body">
                        <input type="hidden" id="jadwal_id" name="id">
                        <div class="mb-3">
                            <label for="jadwal_matkul" class="form-label">Mata Kuliah</label>
                            <select class="form-select" id="jadwal_matkul" name="id_matkul" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jadwal_dosen" class="form-label">Dosen Pengampu</label>
                            <select class="form-select" id="jadwal_dosen" name="id_dosen" required>
                                <option value="">-- Pilih Dosen --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jadwal_waktu" class="form-label">Waktu</label>
                            <input type="text" class="form-control" id="jadwal_waktu" name="waktu" placeholder="Contoh: Senin, 08:00 - 10:30" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="jadwal_ruang" class="form-label">Ruang</label>
                            <input type="text" class="form-control" id="jadwal_ruang" name="ruang" placeholder="Contoh: Lab Komputer 1" required autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script Integrasi CRUD JS -->
    <script src="script.js"></script>
</body>
</html>

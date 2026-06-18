// =====================================================
// INISIALISASI: muat semua data saat halaman siap
// =====================================================
document.addEventListener('DOMContentLoaded', () => {
    loadMahasiswa();
    loadDosen();
    loadMatkul();
    loadJadwal();
});

// Inisialisasi objek Bootstrap Modal
const modalMhs    = new bootstrap.Modal(document.getElementById('mahasiswaModal'));
const modalDosen  = new bootstrap.Modal(document.getElementById('dosenModal'));
const modalMatkul = new bootstrap.Modal(document.getElementById('matkulModal'));
const modalJadwal = new bootstrap.Modal(document.getElementById('jadwalModal'));

// Helper escape teks agar aman dari XSS saat dirender ke tabel
function esc(text) {
    if (text === null || text === undefined) return '';
    return String(text)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

// =====================================================
// ================= CRUD: MAHASISWA ===================
// =====================================================
function loadMahasiswa() {
    fetch('api.php?action=list_mahasiswa')
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="6" class="text-center text-muted p-4">Belum ada data mahasiswa.</td></tr>`;
            } else {
                data.forEach((mhs, i) => {
                    html += `
                        <tr>
                            <td class="ps-3">${i + 1}</td>
                            <td>${esc(mhs.nim)}</td>
                            <td>${esc(mhs.nama)}</td>
                            <td>${esc(mhs.jurusan)}</td>
                            <td>${esc(mhs.email)}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" onclick="siapkanEditMhs(${mhs.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusMahasiswa(${mhs.id})">Hapus</button>
                            </td>
                        </tr>`;
                });
            }
            document.getElementById('tempat-data-mahasiswa').innerHTML = html;
        })
        .catch(err => console.error("Gagal memuat mahasiswa: ", err));
}

function siapkanTambahMhs() {
    document.getElementById('modalTitleMhs').innerText = 'Tambah Data Mahasiswa';
    document.getElementById('formMahasiswa').reset();
    document.getElementById('mahasiswa_id').value = '';
}

function siapkanEditMhs(id) {
    document.getElementById('modalTitleMhs').innerText = 'Ubah Data Mahasiswa';
    document.getElementById('formMahasiswa').reset();
    fetch(`api.php?action=get_mahasiswa&id=${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('mahasiswa_id').value = data.id;
            document.getElementById('nim').value = data.nim;
            document.getElementById('nama').value = data.nama;
            document.getElementById('jurusan').value = data.jurusan;
            document.getElementById('email').value = data.email;
            modalMhs.show();
        })
        .catch(err => console.error("Gagal mengambil detail mahasiswa: ", err));
}

function simpanMahasiswa(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('formMahasiswa'));
    fetch('api.php?action=save_mahasiswa', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                alert('Data mahasiswa berhasil disimpan!');
                modalMhs.hide();
                loadMahasiswa();
            } else {
                alert('Error: ' + res.message);
            }
        })
        .catch(err => console.error("Gagal menyimpan mahasiswa: ", err));
}

function hapusMahasiswa(id) {
    if (confirm('Yakin ingin menghapus data mahasiswa ini?')) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('api.php?action=delete_mahasiswa', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') { alert('Data berhasil dihapus!'); loadMahasiswa(); }
                else { alert('Error: ' + res.message); }
            })
            .catch(err => console.error("Gagal menghapus mahasiswa: ", err));
    }
}

// =====================================================
// =================== CRUD: DOSEN =====================
// =====================================================
function loadDosen() {
    fetch('api.php?action=list_dosen')
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="4" class="text-center text-muted p-4">Belum ada data dosen.</td></tr>`;
            } else {
                data.forEach((d, i) => {
                    html += `
                        <tr>
                            <td class="ps-3">${i + 1}</td>
                            <td>${esc(d.nama)}</td>
                            <td>${esc(d.alamat)}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" onclick="siapkanEditDosen(${d.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusDosen(${d.id})">Hapus</button>
                            </td>
                        </tr>`;
                });
            }
            document.getElementById('tempat-data-dosen').innerHTML = html;
        })
        .catch(err => console.error("Gagal memuat dosen: ", err));
}

function siapkanTambahDosen() {
    document.getElementById('modalTitleDosen').innerText = 'Tambah Data Dosen';
    document.getElementById('formDosen').reset();
    document.getElementById('dosen_id').value = '';
}

function siapkanEditDosen(id) {
    document.getElementById('modalTitleDosen').innerText = 'Ubah Data Dosen';
    document.getElementById('formDosen').reset();
    fetch(`api.php?action=get_dosen&id=${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('dosen_id').value = data.id;
            document.getElementById('dosen_nama').value = data.nama;
            document.getElementById('dosen_alamat').value = data.alamat;
            modalDosen.show();
        })
        .catch(err => console.error("Gagal mengambil detail dosen: ", err));
}

function simpanDosen(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('formDosen'));
    fetch('api.php?action=save_dosen', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                alert('Data dosen berhasil disimpan!');
                modalDosen.hide();
                loadDosen();
            } else {
                alert('Error: ' + res.message);
            }
        })
        .catch(err => console.error("Gagal menyimpan dosen: ", err));
}

function hapusDosen(id) {
    if (confirm('Yakin ingin menghapus data dosen ini? Jadwal terkait juga akan ikut terhapus.')) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('api.php?action=delete_dosen', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') { alert('Data berhasil dihapus!'); loadDosen(); loadJadwal(); }
                else { alert('Error: ' + res.message); }
            })
            .catch(err => console.error("Gagal menghapus dosen: ", err));
    }
}

// =====================================================
// ================ CRUD: MATA KULIAH ==================
// =====================================================
function loadMatkul() {
    fetch('api.php?action=list_matkul')
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="4" class="text-center text-muted p-4">Belum ada data mata kuliah.</td></tr>`;
            } else {
                data.forEach((m, i) => {
                    html += `
                        <tr>
                            <td class="ps-3">${i + 1}</td>
                            <td>${esc(m.matkul)}</td>
                            <td>${esc(m.sks)} SKS</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" onclick="siapkanEditMatkul(${m.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusMatkul(${m.id})">Hapus</button>
                            </td>
                        </tr>`;
                });
            }
            document.getElementById('tempat-data-matkul').innerHTML = html;
        })
        .catch(err => console.error("Gagal memuat matkul: ", err));
}

function siapkanTambahMatkul() {
    document.getElementById('modalTitleMatkul').innerText = 'Tambah Mata Kuliah';
    document.getElementById('formMatkul').reset();
    document.getElementById('matkul_id').value = '';
}

function siapkanEditMatkul(id) {
    document.getElementById('modalTitleMatkul').innerText = 'Ubah Mata Kuliah';
    document.getElementById('formMatkul').reset();
    fetch(`api.php?action=get_matkul&id=${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('matkul_id').value = data.id;
            document.getElementById('matkul_nama').value = data.matkul;
            document.getElementById('matkul_sks').value = data.sks;
            modalMatkul.show();
        })
        .catch(err => console.error("Gagal mengambil detail matkul: ", err));
}

function simpanMatkul(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('formMatkul'));
    fetch('api.php?action=save_matkul', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                alert('Data mata kuliah berhasil disimpan!');
                modalMatkul.hide();
                loadMatkul();
            } else {
                alert('Error: ' + res.message);
            }
        })
        .catch(err => console.error("Gagal menyimpan matkul: ", err));
}

function hapusMatkul(id) {
    if (confirm('Yakin ingin menghapus mata kuliah ini? Jadwal terkait juga akan ikut terhapus.')) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('api.php?action=delete_matkul', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') { alert('Data berhasil dihapus!'); loadMatkul(); loadJadwal(); }
                else { alert('Error: ' + res.message); }
            })
            .catch(err => console.error("Gagal menghapus matkul: ", err));
    }
}

// =====================================================
// =================== CRUD: JADWAL ====================
// =====================================================
function loadJadwal() {
    fetch('api.php?action=list_jadwal')
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="6" class="text-center text-muted p-4">Belum ada data jadwal.</td></tr>`;
            } else {
                data.forEach((j, i) => {
                    html += `
                        <tr>
                            <td class="ps-3">${i + 1}</td>
                            <td>${esc(j.nama_matkul)}</td>
                            <td>${esc(j.nama_dosen)}</td>
                            <td>${esc(j.waktu)}</td>
                            <td>${esc(j.ruang)}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" onclick="siapkanEditJadwal(${j.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusJadwal(${j.id})">Hapus</button>
                            </td>
                        </tr>`;
                });
            }
            document.getElementById('tempat-data-jadwal').innerHTML = html;
        })
        .catch(err => console.error("Gagal memuat jadwal: ", err));
}

// Mengisi <select> dosen & matkul dari database (dipanggil sebelum modal dibuka)
function isiDropdownJadwal(callback) {
    fetch('api.php?action=dropdown_data')
        .then(res => res.json())
        .then(data => {
            const selMatkul = document.getElementById('jadwal_matkul');
            const selDosen  = document.getElementById('jadwal_dosen');

            selMatkul.innerHTML = '<option value="">-- Pilih Mata Kuliah --</option>';
            data.matkul.forEach(m => {
                selMatkul.innerHTML += `<option value="${m.id}">${esc(m.matkul)}</option>`;
            });

            selDosen.innerHTML = '<option value="">-- Pilih Dosen --</option>';
            data.dosen.forEach(d => {
                selDosen.innerHTML += `<option value="${d.id}">${esc(d.nama)}</option>`;
            });

            if (typeof callback === 'function') callback();
        })
        .catch(err => console.error("Gagal memuat dropdown: ", err));
}

function siapkanTambahJadwal() {
    document.getElementById('modalTitleJadwal').innerText = 'Tambah Jadwal';
    document.getElementById('formJadwal').reset();
    document.getElementById('jadwal_id').value = '';
    isiDropdownJadwal();
}

function siapkanEditJadwal(id) {
    document.getElementById('modalTitleJadwal').innerText = 'Ubah Jadwal';
    document.getElementById('formJadwal').reset();
    // Isi dropdown dulu, baru set value setelah opsi tersedia
    isiDropdownJadwal(() => {
        fetch(`api.php?action=get_jadwal&id=${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('jadwal_id').value = data.id;
                document.getElementById('jadwal_matkul').value = data.id_matkul;
                document.getElementById('jadwal_dosen').value = data.id_dosen;
                document.getElementById('jadwal_waktu').value = data.waktu;
                document.getElementById('jadwal_ruang').value = data.ruang;
                modalJadwal.show();
            })
            .catch(err => console.error("Gagal mengambil detail jadwal: ", err));
    });
}

function simpanJadwal(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('formJadwal'));
    fetch('api.php?action=save_jadwal', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                alert('Data jadwal berhasil disimpan!');
                modalJadwal.hide();
                loadJadwal();
            } else {
                alert('Error: ' + res.message);
            }
        })
        .catch(err => console.error("Gagal menyimpan jadwal: ", err));
}

function hapusJadwal(id) {
    if (confirm('Yakin ingin menghapus jadwal ini?')) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('api.php?action=delete_jadwal', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') { alert('Data berhasil dihapus!'); loadJadwal(); }
                else { alert('Error: ' + res.message); }
            })
            .catch(err => console.error("Gagal menghapus jadwal: ", err));
    }
}

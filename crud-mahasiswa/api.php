<?php
session_start();
header('Content-Type: application/json');

// Proteksi API: Jika tidak ada session login, cegah akses
if (!isset($_SESSION['login'])) {
    echo json_encode(['status' => 'error', 'message' => 'Akses ilegal terdeteksi. Silakan login.']);
    exit;
}

include 'koneksi.php';

$action = $_GET['action'] ?? '';

// =====================================================
// ============== ENTITAS: MAHASISWA ===================
// =====================================================
if ($action == 'list_mahasiswa') {
    $query = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id DESC");
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) { $data[] = $row; }
    echo json_encode($data);
    exit;
}

if ($action == 'get_mahasiswa') {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = $id");
    echo json_encode(mysqli_fetch_assoc($query));
    exit;
}

if ($action == 'save_mahasiswa') {
    $id      = $_POST['id'] ?? '';
    $nim     = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($id)) {
        $sql = "INSERT INTO mahasiswa (nim, nama, jurusan, email) VALUES ('$nim', '$nama', '$jurusan', '$email')";
    } else {
        $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', jurusan='$jurusan', email='$email' WHERE id=$id";
    }
    echo json_encode(mysqli_query($conn, $sql)
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

if ($action == 'delete_mahasiswa') {
    $id = intval($_POST['id']);
    echo json_encode(mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id")
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

// =====================================================
// ================= ENTITAS: DOSEN ====================
// =====================================================
if ($action == 'list_dosen') {
    $query = mysqli_query($conn, "SELECT * FROM dosen ORDER BY id DESC");
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) { $data[] = $row; }
    echo json_encode($data);
    exit;
}

if ($action == 'get_dosen') {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM dosen WHERE id = $id");
    echo json_encode(mysqli_fetch_assoc($query));
    exit;
}

if ($action == 'save_dosen') {
    $id     = $_POST['id'] ?? '';
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    if (empty($id)) {
        $sql = "INSERT INTO dosen (nama, alamat) VALUES ('$nama', '$alamat')";
    } else {
        $sql = "UPDATE dosen SET nama='$nama', alamat='$alamat' WHERE id=$id";
    }
    echo json_encode(mysqli_query($conn, $sql)
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

if ($action == 'delete_dosen') {
    $id = intval($_POST['id']);
    echo json_encode(mysqli_query($conn, "DELETE FROM dosen WHERE id = $id")
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

// =====================================================
// =============== ENTITAS: MATA KULIAH ================
// =====================================================
if ($action == 'list_matkul') {
    $query = mysqli_query($conn, "SELECT * FROM matkul ORDER BY id DESC");
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) { $data[] = $row; }
    echo json_encode($data);
    exit;
}

if ($action == 'get_matkul') {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM matkul WHERE id = $id");
    echo json_encode(mysqli_fetch_assoc($query));
    exit;
}

if ($action == 'save_matkul') {
    $id     = $_POST['id'] ?? '';
    $matkul = mysqli_real_escape_string($conn, $_POST['matkul']);
    $sks    = intval($_POST['sks']);

    if (empty($id)) {
        $sql = "INSERT INTO matkul (matkul, sks) VALUES ('$matkul', $sks)";
    } else {
        $sql = "UPDATE matkul SET matkul='$matkul', sks=$sks WHERE id=$id";
    }
    echo json_encode(mysqli_query($conn, $sql)
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

if ($action == 'delete_matkul') {
    $id = intval($_POST['id']);
    echo json_encode(mysqli_query($conn, "DELETE FROM matkul WHERE id = $id")
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

// =====================================================
// ================ ENTITAS: JADWAL ====================
// =====================================================
if ($action == 'list_jadwal') {
    // JOIN untuk menampilkan nama matkul & nama dosen, bukan sekadar id
    $sql = "SELECT jadwal.*, matkul.matkul AS nama_matkul, dosen.nama AS nama_dosen
            FROM jadwal
            JOIN matkul ON jadwal.id_matkul = matkul.id
            JOIN dosen  ON jadwal.id_dosen  = dosen.id
            ORDER BY jadwal.id DESC";
    $query = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) { $data[] = $row; }
    echo json_encode($data);
    exit;
}

if ($action == 'get_jadwal') {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM jadwal WHERE id = $id");
    echo json_encode(mysqli_fetch_assoc($query));
    exit;
}

if ($action == 'save_jadwal') {
    $id        = $_POST['id'] ?? '';
    $id_dosen  = intval($_POST['id_dosen']);
    $id_matkul = intval($_POST['id_matkul']);
    $waktu     = mysqli_real_escape_string($conn, $_POST['waktu']);
    $ruang     = mysqli_real_escape_string($conn, $_POST['ruang']);

    if (empty($id)) {
        $sql = "INSERT INTO jadwal (id_dosen, id_matkul, waktu, ruang)
                VALUES ($id_dosen, $id_matkul, '$waktu', '$ruang')";
    } else {
        $sql = "UPDATE jadwal SET id_dosen=$id_dosen, id_matkul=$id_matkul,
                waktu='$waktu', ruang='$ruang' WHERE id=$id";
    }
    echo json_encode(mysqli_query($conn, $sql)
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

if ($action == 'delete_jadwal') {
    $id = intval($_POST['id']);
    echo json_encode(mysqli_query($conn, "DELETE FROM jadwal WHERE id = $id")
        ? ['status' => 'success']
        : ['status' => 'error', 'message' => mysqli_error($conn)]);
    exit;
}

// =====================================================
// === DROPDOWN HELPER: ambil daftar dosen & matkul ====
// === (untuk mengisi <select> pada form jadwal)     ===
// =====================================================
if ($action == 'dropdown_data') {
    $dosen = [];
    $q1 = mysqli_query($conn, "SELECT id, nama FROM dosen ORDER BY nama ASC");
    while ($row = mysqli_fetch_assoc($q1)) { $dosen[] = $row; }

    $matkul = [];
    $q2 = mysqli_query($conn, "SELECT id, matkul FROM matkul ORDER BY matkul ASC");
    while ($row = mysqli_fetch_assoc($q2)) { $matkul[] = $row; }

    echo json_encode(['dosen' => $dosen, 'matkul' => $matkul]);
    exit;
}

// Jika action tidak dikenali
echo json_encode(['status' => 'error', 'message' => 'Action tidak valid.']);
?>

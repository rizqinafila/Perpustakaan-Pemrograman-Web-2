<?php
$page_title = "Tambah Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Inisialisasi
$errors = [];
$kode_anggota = '';
$nama = '';
$email = '';
$telepon = '';
$alamat = '';
$tanggal_lahir = '';
$jenis_kelamin = '';
$pekerjaan = '';
$foto = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ambil data
    $kode_anggota = sanitize($_POST['kode_anggota']);
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $telepon = sanitize($_POST['telepon']);
    $alamat = sanitize($_POST['alamat']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pekerjaan = sanitize($_POST['pekerjaan']);

    // Validasi
    if (empty($kode_anggota)) $errors[] = "Kode wajib diisi";
    if (empty($nama)) $errors[] = "Nama wajib diisi";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }

    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Telepon harus diawali 08 dan valid";
    }

    // Validasi umur minimal 10 tahun
    $umur = date('Y') - date('Y', strtotime($tanggal_lahir));
    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    // Cek unik
    $stmt = $conn->prepare("SELECT id_anggota FROM anggota WHERE email = ? OR kode_anggota = ?");
    $stmt->bind_param("ss", $email, $kode_anggota);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "Email atau kode sudah digunakan";
    }
    $stmt->close();

    // Upload foto
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $file_name = time() . '_' . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $file_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi file
        if (!in_array($imageFileType, ['jpg','jpeg','png'])) {
            $errors[] = "Format foto harus JPG/PNG";
        }

        if ($_FILES['foto']['size'] > 2000000) {
            $errors[] = "Ukuran foto max 2MB";
        }

        // Upload jika tidak ada error
        if (empty($errors)) {
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
            $foto = $file_name;
        }
    }

    // Insert data
    if (empty($errors)) {
        $tanggal_daftar = date('Y-m-d');
        $status = 'Aktif';

        $stmt = $conn->prepare("INSERT INTO anggota 
        (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssssss",
            $kode_anggota,
            $nama,
            $email,
            $telepon,
            $alamat,
            $tanggal_lahir,
            $jenis_kelamin,
            $pekerjaan,
            $tanggal_daftar,
            $status,
            $foto
        );

        if ($stmt->execute()) {
            header("Location: index.php?success=Data berhasil ditambahkan");
            exit();
        } else {
            $errors[] = "Gagal simpan data";
        }

        $stmt->close();
    }
}
?>

<div class="container">
    <h3>Tambah Anggota</h3>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo $e; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="kode_anggota" placeholder="Kode" class="form-control mb-2" required>
        <input type="text" name="nama" placeholder="Nama" class="form-control mb-2" required>
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
        <input type="text" name="telepon" placeholder="Telepon" class="form-control mb-2" required>
        <textarea name="alamat" placeholder="Alamat" class="form-control mb-2" required></textarea>

        <input type="date" name="tanggal_lahir" class="form-control mb-2" required>

        <select name="jenis_kelamin" class="form-control mb-2" required>
            <option value="">Pilih Gender</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>

        <input type="text" name="pekerjaan" placeholder="Pekerjaan" class="form-control mb-2">

        <input type="file" name="foto" class="form-control mb-3">

        <button class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<?php
closeConnection();
require_once '../../includes/footer.php';
?>
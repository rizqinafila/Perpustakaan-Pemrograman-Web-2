<?php
$page_title = "Edit Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Validasi ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=ID tidak valid");
    exit();
}

$id = (int)$_GET['id'];
$errors = [];

// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?error=Data tidak ditemukan");
    exit();
}

$data = $result->fetch_assoc();
$stmt->close();

// Set ke variabel
$kode_anggota = $data['kode_anggota'];
$nama = $data['nama'];
$email = $data['email'];
$telepon = $data['telepon'];
$alamat = $data['alamat'];
$tanggal_lahir = $data['tanggal_lahir'];
$jenis_kelamin = $data['jenis_kelamin'];
$pekerjaan = $data['pekerjaan'];
$foto_lama = $data['foto'];

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
        $errors[] = "Email tidak valid";
    }

    if (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors[] = "Telepon tidak valid";
    }

    $umur = date('Y') - date('Y', strtotime($tanggal_lahir));
    if ($umur < 10) {
        $errors[] = "Umur minimal 10 tahun";
    }

    // Cek unik (kecuali dirinya sendiri)
    $stmt = $conn->prepare("SELECT id_anggota FROM anggota WHERE (email = ? OR kode_anggota = ?) AND id_anggota != ?");
    $stmt->bind_param("ssi", $email, $kode_anggota, $id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "Email atau kode sudah dipakai";
    }
    $stmt->close();

    // Upload foto baru (optional)
    $foto = $foto_lama;

    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $file_name = time() . '_' . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $file_name;

        $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg','jpeg','png'])) {
            $errors[] = "Format foto harus JPG/PNG";
        }

        if ($_FILES['foto']['size'] > 2000000) {
            $errors[] = "Max 2MB";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {

                // Hapus foto lama
                if (!empty($foto_lama) && file_exists("uploads/" . $foto_lama)) {
                    unlink("uploads/" . $foto_lama);
                }

                $foto = $file_name;
            }
        }
    }

    // Update DB
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE anggota SET 
            kode_anggota=?, nama=?, email=?, telepon=?, alamat=?, 
            tanggal_lahir=?, jenis_kelamin=?, pekerjaan=?, foto=? 
            WHERE id_anggota=?");

        $stmt->bind_param("sssssssssi",
            $kode_anggota,
            $nama,
            $email,
            $telepon,
            $alamat,
            $tanggal_lahir,
            $jenis_kelamin,
            $pekerjaan,
            $foto,
            $id
        );

        if ($stmt->execute()) {
            header("Location: index.php?success=Data berhasil diupdate");
            exit();
        } else {
            $errors[] = "Gagal update data";
        }

        $stmt->close();
    }
}
?>

<div class="container">
    <h3>Edit Anggota</h3>

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

        <input type="text" name="kode_anggota" value="<?php echo $kode_anggota; ?>" class="form-control mb-2" required>
        <input type="text" name="nama" value="<?php echo $nama; ?>" class="form-control mb-2" required>
        <input type="email" name="email" value="<?php echo $email; ?>" class="form-control mb-2" required>
        <input type="text" name="telepon" value="<?php echo $telepon; ?>" class="form-control mb-2" required>
        <textarea name="alamat" class="form-control mb-2"><?php echo $alamat; ?></textarea>

        <input type="date" name="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>" class="form-control mb-2">

        <select name="jenis_kelamin" class="form-control mb-2">
            <option value="Laki-laki" <?php if ($jenis_kelamin=='Laki-laki') echo 'selected'; ?>>Laki-laki</option>
            <option value="Perempuan" <?php if ($jenis_kelamin=='Perempuan') echo 'selected'; ?>>Perempuan</option>
        </select>

        <input type="text" name="pekerjaan" value="<?php echo $pekerjaan; ?>" class="form-control mb-2">

        <!-- Foto lama -->
        <?php if (!empty($foto_lama)): ?>
            <p>Foto saat ini:</p>
            <img src="uploads/<?php echo $foto_lama; ?>" width="100"><br><br>
        <?php endif; ?>

        <input type="file" name="foto" class="form-control mb-3">

        <button class="btn btn-warning">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<?php
closeConnection();
require_once '../../includes/footer.php';
?>
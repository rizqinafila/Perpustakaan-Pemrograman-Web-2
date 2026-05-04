<?php
require_once '../../config/database.php';

// Validasi ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=ID anggota tidak valid");
    exit();
}

$id_anggota = (int)$_GET['id'];

// Ambil data anggota (untuk nama & foto)
$stmt = $conn->prepare("SELECT nama, foto FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    closeConnection();
    header("Location: index.php?error=Data anggota tidak ditemukan");
    exit();
}

$data = $result->fetch_assoc();
$nama = $data['nama'];
$foto = $data['foto'];

$stmt->close();

// Hapus foto jika ada
if (!empty($foto) && file_exists("uploads/" . $foto)) {
    unlink("uploads/" . $foto);
}

// Hapus data dari database
$stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        closeConnection();
        header("Location: index.php?success=" . urlencode("Data '$nama' berhasil dihapus"));
        exit();
    } else {
        header("Location: index.php?error=Gagal menghapus data");
    }
} else {
    header("Location: index.php?error=" . urlencode("Error: " . $stmt->error));
}

$stmt->close();
closeConnection();
?>
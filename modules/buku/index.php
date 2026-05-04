<?php
$page_title = "Data Buku";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Query + Search
if (!empty($search)) {
    $query = "SELECT * FROM buku 
              WHERE judul LIKE ? OR pengarang LIKE ? OR kategori LIKE ?
              ORDER BY created_at DESC 
              LIMIT ? OFFSET ?";
    
    $search_param = "%$search%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Count total hasil search
    $count_query = "SELECT COUNT(*) as total FROM buku 
                    WHERE judul LIKE ? OR pengarang LIKE ? OR kategori LIKE ?";
    $stmt_count = $conn->prepare($count_query);
    $stmt_count->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt_count->execute();
    $total_rows = $stmt_count->get_result()->fetch_assoc()['total'];

} else {
    $query = "SELECT * FROM buku ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Count total semua data
    $total_rows = $conn->query("SELECT COUNT(*) as total FROM buku")->fetch_assoc()['total'];
}

// Hitung total halaman
$total_pages = ceil($total_rows / $limit);
?>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="bi bi-book"></i> Data Buku Perpustakaan</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Buku Baru
            </a>
        </div>
    </div>

    <!-- ALERT -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- SEARCH -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        value="<?php echo htmlspecialchars($search); ?>"
                        placeholder="Cari judul, pengarang, kategori...">

                    <button class="btn btn-primary" type="submit">Cari</button>

                    <?php if (!empty($search)): ?>
                        <a href="index.php" class="btn btn-secondary">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                Daftar Buku
                <?php if (!empty($search)): ?>
                    <small>(Hasil: "<?php echo htmlspecialchars($search); ?>")</small>
                <?php endif; ?>
            </h5>
        </div>

        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = $offset + 1;
                            while ($row = $result->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><code><?php echo htmlspecialchars($row['kode_buku']); ?></code></td>
                                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                <td><?php echo htmlspecialchars($row['pengarang']); ?></td>
                                <td><?php echo htmlspecialchars($row['penerbit']); ?></td>
                                <td><?php echo $row['tahun_terbit']; ?></td>
                                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td><?php echo $row['stok']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id=<?php echo $row['id_buku']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin hapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <?php if ($total_pages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">

                        <!-- Previous -->
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link"
                               href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                                Previous
                            </a>
                        </li>

                        <!-- Numbers -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link"
                               href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <!-- Next -->
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link"
                               href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">
                                Next
                            </a>
                        </li>

                    </ul>
                </nav>
                <?php endif; ?>

                <div class="mt-2">
                    Total: <?php echo $total_rows; ?> data | Halaman: <?php echo $page; ?> / <?php echo $total_pages; ?>
                </div>

            <?php else: ?>
                <div class="alert alert-warning">
                    Tidak ada data ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
if (isset($stmt)) $stmt->close();
if (isset($stmt_count)) $stmt_count->close();
closeConnection();
require_once '../../includes/footer.php';
?>
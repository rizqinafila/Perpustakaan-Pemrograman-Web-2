<?php
$page_title = "Data Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Query
if (!empty($search)) {
    $query = "SELECT * FROM anggota 
              WHERE nama LIKE ? OR email LIKE ? OR telepon LIKE ?
              ORDER BY created_at DESC 
              LIMIT ? OFFSET ?";
    
    $search_param = "%$search%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Count total
    $count_query = "SELECT COUNT(*) as total FROM anggota 
                    WHERE nama LIKE ? OR email LIKE ? OR telepon LIKE ?";
    $stmt_count = $conn->prepare($count_query);
    $stmt_count->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt_count->execute();
    $total_rows = $stmt_count->get_result()->fetch_assoc()['total'];

} else {
    $query = "SELECT * FROM anggota ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_rows = $conn->query("SELECT COUNT(*) as total FROM anggota")->fetch_assoc()['total'];
}

$total_pages = ceil($total_rows / $limit);
?>

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between mb-3">
        <h2>Data Anggota</h2>
        <a href="create.php" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    <!-- SEARCH -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control"
                   value="<?php echo htmlspecialchars($search); ?>"
                   placeholder="Cari nama, email, telepon...">
            <button class="btn btn-primary">Cari</button>

            <?php if (!empty($search)): ?>
                <a href="index.php" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">

            <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>JK</th>
                            <th>Status</th>
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

                        <!-- FOTO -->
                        <td>
                            <?php if (!empty($row['foto'])): ?>
                                <img src="uploads/<?php echo $row['foto']; ?>" 
                                     width="50" height="50" 
                                     style="object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>

                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['telepon']); ?></td>

                        <!-- JENIS KELAMIN -->
                        <td>
                            <?php if ($row['jenis_kelamin'] == 'Laki-laki'): ?>
                                <span class="badge bg-primary">L</span>
                            <?php else: ?>
                                <span class="badge bg-danger">P</span>
                            <?php endif; ?>
                        </td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($row['status'] == 'Aktif'): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>

                        <!-- AKSI -->
                        <td>
                            <a href="edit.php?id=<?php echo $row['id_anggota']; ?>" 
                               class="btn btn-sm btn-warning">Edit</a>

                            <a href="delete.php?id=<?php echo $row['id_anggota']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin hapus data ini?')">
                               Hapus
                            </a>
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

                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>">Prev</a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                    </li>

                </ul>
            </nav>
            <?php endif; ?>

            <div class="mt-2">
                Total: <?php echo $total_rows; ?> data
            </div>

            <?php else: ?>
                <div class="alert alert-warning">Data tidak ditemukan</div>
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
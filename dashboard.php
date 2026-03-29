<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?php 
    // ========== DATA PERPUSTAKAAN ==========
    $namaPerpus = "Perpustakaan Digital Universitas ABC";
    $alamat = "Jl. Pendidikan No. 123, Jakarta";
    $telepon = "(021) 1234-5678";
    $email = "info@perpusdigunabc.ac.id";

    // ========== STATISTIK BUKU ==========
    $totalBuku = 1500;
    $bukuDipinjam = 234;
    $bukuTersedia = $totalBuku - $bukuDipinjam;
    $presentaseDipinjam = ($bukuDipinjam / $totalBuku) * 100;
    $presentaseTersedia = ($bukuTersedia / $totalBuku) * 100;

    // ========== STATISTIK ANGGOTA ==========
    $totalAnggota = 450;
    $anggotaAktiv = 378;
    $anggotaNonAktiv = $totalAnggota - $anggotaAktiv;

    // ========== TRANSAKSI HARI INI ==========
    $transaksi_hariIni = 15;
    $peminjam = 9;
    $pengembalian = 6;

    // ========== BUKU TERPOPULER ==========
    $buku1 = "Pemrograman Web PHP";
    $buku2 = "Database MySQL";
    $buku3 = "Laravel Framework";

    $pinjam1 = 45;
    $pinjam2 = 38;
    $pinjam3 = 32;

    // ========== INFORMASI WAKTU ==========
    $hariIni = date('i, d, F Y');
    $jamSekarang = date('H:i:s');

    //Tentukan salam berdasarkan waktu
    if ($jam >= 5 && $jam < 12){
        $salam = "Selamat Pagi";
        $iconWaktu = "bi-sunrise";
    } elseif ($jam >= 12 && $jam < 15) {
        $salam = "Selamat Siang";
        $iconWaktu = "bi-sun";
    } elseif ($jam >= 15 && $jam < 18){
        $salam = "Selamat Sore";
        $iconWaktu = "bi-could-sun";
    } else {
        $salam = "Selamat Malam";
        $iconWaktu = "bi-moon-strars";
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-book"></i> <?php echo $namaPerpus; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-house"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-book"> Buku</i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-people"> Anggota</i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-arrow-left-right"> Transaksi</i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="<?php echo $iconWaktu; ?>"></i> <?php echo $salam; ?>, Admin</h2>
                <p class="text-muted">
                    <i class="bi bi-calendar"></i> <?php echo $hariIni; ?> |
                    <i class="bi bi-clock"></i> <?php echo $jamSekarang; ?>
                </p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Buku
                </button>
                <button class="btn btn-succes">
                    <i class="bi bi-arrow-left-right"></i> Transaksi Baru
                </button>
            </div>
        </div>

        <!-- Cards Statistik -->
        <div class="row mb-4">
            <!-- Total Buku -->
            <div class="col-md-3 mb-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Buku</h6>
                                <h2 class="mb-0"><?php echo number_format($totalBuku); ?></h2>
                            </div>
                            <div class="text-primary" style="font-size: 48px;">
                                <i class="bi bi-book"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary text-white">
                        <small><i class="bi bi-info-circle"></i> Koleksi perpustakaan</small>
                    </div>
                </div>
            </div>

            <!-- Buku Dipinjam -->
            <div class="col-md-3 mb-3">
                <div class="card border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Dipinjam</h6>
                                <h2 class="mb-0"><?php echo number_format($bukuDipinjam); ?></h2>
                                <small class="text-warning">
                                    <?php echo number_format($presentaseDipinjam, 1); ?>%
                                </small>
                            </div>
                            <div class="text-warning" style="font-size: 48px;">
                                <i class="bi bi-arrow-left"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-warning text-dark">
                        <small><i class="bi bi-info-circle"></i> Sedang dipinjam</small>
                    </div>
                </div>
            </div>

            <!-- Buku Tersedia -->
            <div class="col-md-3 mb-3">
                <div class="card-border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-">Tersedia</h6>
                                <h2 class="mb-0"><?php echo number_format($bukuTersedia); ?></h2>
                                <small class="text-succes">
                                    <?php echo number_format($presentaseTersedia, 1); ?>%
                                </small>
                            </div>
                            <div class="text-success" style="font-size: 48px;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-success text-white">
                        <small><i class="bi bi-info-circle"></i>Siap dipinjam</small>
                    </div>
                </div>
            </div>

            <!-- Total Anggota -->
            <div class="col-md-3 mb-3">
                <div class="card border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Anggota</h6>
                                <h2 class="mb-0"><?php echo number_format($totalAnggota); ?></h2>
                                <small class="text-info">
                                    <?php echo number_format($anggotaAktiv); ?> aktif
                                </small>
                            </div>
                            <div class="text-info" style="font-size: 48px;">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-info text-white">
                        <small><i class="bi bi-info-circle"></i> Member terdaftar</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Transaksi Hari Ini -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history"></i> Transaksi Hari Ini
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0"><?php echo $transaksi_hariIni; ?></h3>
                            <span class="badge bg-primary">Tansaksi</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="bi bi-arrow-left text-danger"></i>Peminjam</span>
                            <strong><?php echo $peminjam; ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="bi bi-arrow-right text-success">Pengembalian</i></span>
                            <strong><?php echo $pengembalian; ?></strong>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Buku Terpopuler -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-succes text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-star"></i> Buku Terpopuler
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-conter mb-2">
                            <div>
                                <span class="badge bg-warning text-dark me-2">1</span>
                                <span><?php echo $buku1; ?></span>
                            </div>
                            <span class="badge bg-succes"><?php echo $pinjam1 ?>x</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-secondary me-2">2</span>
                                <span><?php echo $buku2; ?></span>
                            </div>
                            <span class="badge bg-success"><?php $pinjam2 ?>x</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-secondary me-2">3</span>
                                <span><?php echo $buku3; ?></span>
                            </div>
                            <span class="badge bg-succes"><?php echo $pinjam3 ?>x</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Perpustakaan -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle"></i> Informasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <i class="bi bi-geo-alt text-danger"></i>
                            <strong>Alamat:</strong><br />
                            <small><?php echo $alamat; ?></small>
                        </p>
                        <hr>
                        <p class="mb-2">
                            <i class="bi bi-telephon text-succes"></i>
                            <strong>Telepon:</strong><br />
                            <small><?php echo $telepon; ?></small>
                        </p>
                        <hr>
                        <p class="mb-0">
                            <i class="bi bi-envelope text-primary"></i>
                            <strong>Email:</strong><br />
                            <small><?php echo $email; ?></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar Ketersediaan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-bar-chart"></i> Status Ketersediaan Buku
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6>Buku Tersedia</h6>
                                <div class="progress" style="height: 30px;">
                                    <div class="progres-bar bg-success" role="progressbar"
                                    style="width: <?php echo $presentaseTersedia; ?>;"
                                    aria-valuenow="<?php echo $presentaseTersedia; ?>"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <?php echo number_format($presentaseTersedia, 1); ?>%
                                    (<?php echo $bukuTersedia; ?> buku)
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6>Buku Dipinjam</h6>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: <?php echo $presentaseDipinjam; ?>%;"
                                    aria-valuenow="<?php echo $presentaseDipinjam; ?>"
                                    aria-valuemin="0" aria-valuemax="100">
                                        <?php echo number_format($presentaseDipinjam, 1); ?>%
                                        (<?php echo $bukuDipinjam; ?> buku)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan -->
                        <div class="alert alert-info mt-3">
                            <h6><i class="bi bi-info-circle"></i> Ringkasan:</h6>
                            <ul class="mb-0">
                                <li>Total koleksi buku perpustakaan: <strong><?php echo number_format($totalBuku); ?></strong> buku</li>
                                <li>Saat ini tersedia untuk dipinjam: <strong><?php echo number_format($bukuTersedia); ?></strong> buku</li>
                                <li>Sedang dipinjam oleh anggota: <strong><?php echo number_format($bukuDipinjam); ?></strong> buku</li>
                                <li>Tingkat peminatan: <strong><?php echo number_format($presentaseDipinjam, 1); ?>%</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">
            &copy; <?php echo date('Y'); ?> <?php echo $namaPerpus; ?>. all rights reserved. <br />
            <small>Powered by PHP <?php echo phpversion(); ?></small>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
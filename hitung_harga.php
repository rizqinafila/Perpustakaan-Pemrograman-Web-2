<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Harga - Perpustakaan</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Harga Buku</h1>

        <?php 
        // Data Buku
        $judul_buku = "Mastering Laravel Framwork";
        $harga_satuan = 95000;
        $jumlah_beli = 5;

        //Perhitungan
        $subtotal = $harga_satuan * $jumlah_beli;

        //Diskon Berdasarkan jumlah
        if($jumlah_beli >= 3){
            $presentaseDiskon = 10; //10%
        } else {
            $presentaseDiskon = 0;
        }

        $diskon = $subtotal * ($presentaseDiskon / 100);
        $total_setelah_diskon = $subtotal - $diskon;

        //PPN 11%
        $ppn = $total_setelah_diskon * 0.11;

        // Total akhir
        $totalAkhir = $total_setelah_diskon + $ppn;
        ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Detail Pembelian</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="250">Judul Buku</th>
                                <td>: <?php echo $judul_buku ?></td>
                            </tr>
                            <tr>
                                <th>Harga Satuan</th>
                                <td>: Rp <?php echo number_format($harga_satuan, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Beli</th>
                                <td>: <?php echo $jumlah_beli; ?>buku</td>
                            </tr>
                            <tr class="table-secondary">
                                <th>Subtotal</th>
                                <td>: Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                            <tr class="text-succes">
                                <th>Diskon (<?php echo $presentaseDiskon; ?>%)</th>
                                <td>: - Rp <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                            </tr>
                            <tr class="table-secondary">
                                <th>Total setelah diskon</th>
                                <td>: Rp <?php echo number_format($total_setelah_diskon, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>PPN 11%</th>
                                <td>: + Rp <?php echo number_format($ppn, 0, ',', '.'); ?></td>
                            </tr>
                            <tr class="table-primary fw-bold">
                                <th>TOTAL AKHIR</th>
                                <td>: Rp <?php echo number_format($totalAkhir, 0, ',', '.'); ?></td>
                            </tr>
                        </table>

                        <?php if ($presentaseDiskon > 0): ?>
                        <div class="alert alert-succes">
                            <strong>Selamat!</strong> Anda mendapatkan diskon <?php echo $presentaseDiskon; ?>% karena membeli <?php echo$jumlah_beli; ?> buku atau lebih.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Informasi Diskon</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-succes"></i>
                                Beli 3+ buku: Diskon 10%
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-succes"></i>
                                beli 5+ buku: Diskon 15%
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-info-circle text-info"></i>
                                Semua harga sudah termasuk PPN
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card border-warning mt-3">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0">Hemat Anda</h6>
                    </div>
                    <div class="card-body">
                        <h4 class="text-succes">
                            Rp <?php echo number_format($diskon, 0, ',', '.'); ?>
                        </h4>
                        <small class="text-muted">
                            dari harga normal Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- contoh perhitungan lain -->
         <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Contoh perhitungan lainnya</h5>
            </div>
            <div class="card-body">
                <?php 
                // contoh menghitung total stok
                $stokGudangA = 45;
                $stokGudangB = 32;
                $stokGudangC = 18;
                $totalStok = $stokGudangA + $stokGudangB + $stokGudangC;
                ?>
                <h6>1. Total Stok dari 3 gudang:</h6>
                <p>
                    Gudang A: <?php $stokGudangA; ?> +
                    Gudang B: <?php $stokGudangB; ?> +
                    Gudang C: <?php $stokGudangC; ?> =
                    <strong><?php echo $totalStok; ?></strong>
                </p>

                <?php 
                //Contoh 2: Menghitung rata-rata harga
                $harga1 = 50000;
                $harga2 = 75000;
                $harga3 = 95000;
                $rata_rata = ($harga1 + $harga2 + $harga3) / 3;
                ?>
                <h6>2. Rata-rata harga buku:</h6>
                <p>
                    (Rp <?php echo number_format($harga1, 0, ',', '.'); ?> +
                    Rp <?php echo number_format($harga2, 0, ',', '.'); ?> +
                    Rp <?php echo number_format($harga3, 0, ',', '.') ?>) / 3 =
                    <strong>Rp <?php echo number_format($rata_rata, 0, ',', '.'); ?>/strong>
                </p>

                <?php 
                // Contoh 3: Menghitung presentase
                $buku_dipinjam = 78;
                $totalBuku = 500;
                $presentase = ($buku_dipinjam / $totalBuku) * 100;
                ?>
                <h6>3. Presentase buku dipinjam:</h6>
                <p>
                    (<?php echo $buku_dipinjam; ?> / <?php echo $totalBuku; ?>) * 100 =
                    <strong><?php echo number_format($presentase, 2); ?>%</strong>
                </p>

                <?php 
                // Contoh 4: Pembulatan
                $harga_diskon = 87543.75;
                 ?>
                <h6>4. Pembulatan Harga:</h6>
                <p>
                    Harga asli: Rp <?php echo number_format($harga_diskon, 2, ',', '.'); ?><br />
                    Pembulatan ke atas: Rp <?php echo number_format(ceil($harga_diskon), 0, ',', '.'); ?><br />
                    Pembulatan ke bawah: Rp <?php echo number_format(floor($harga_diskon), 0, ',', '.'); ?><br />
                    Pembulatan normal: Rp <?php echo number_format(round($harga_diskon), 0, ',', '.'); ?>
                </p>
            </div>
         </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
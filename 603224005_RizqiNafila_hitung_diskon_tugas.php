<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Diskon - Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>

        <?php 
        // Isi data Pembeli dan buku
        $namaPembeli = "Rizqi Nafila";
        $judulBuku = "Laravel Advanced";
        $hargaSatuan = 150000;
        $jumlahBeli = 4;
        $isMember = true;

        // Hitung Subtotal
        $subtotal = $hargaSatuan * $jumlahBeli;

        // Tentukan persentase diskon berdasarkan jumlah
        if ($jumlahBeli >= 1 && $jumlahBeli <= 2) {
            $persentaseDiskon = 0;
        } elseif ($jumlahBeli >= 3 && $jumlahBeli <= 5) {
            $persentaseDiskon = 0.10;
        } elseif ($jumlahBeli >= 6 && $jumlahBeli <= 10) {
            $persentaseDiskon = 0.15;
        } else {
            $persentaseDiskon = 0.20;
        }

        // Hitung diskon
        $diskon = $subtotal * $persentaseDiskon;
        
        // Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;
        
        // Hitung diskon member jika member
        $diskonMember = 0;
        if ($isMember) {
            $diskonMember = $total_setelah_diskon1 * 0.05;
        }
        
        // Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskonMember; 
        
        // Hitung PPN
        $ppn = $total_setelah_diskon * 0.11;
        
        // Total akhir
        $total_akhir = $total_setelah_diskon + $ppn;
        
        // Total penghematan
        $total_hemat = $diskon + $diskonMember; // Lengkapi
        ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Struk Pembelian</h5>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Nama Pembeli</td>
                            <td>: <?php echo $namaPembeli; ?></td>
                        </tr>
                        <tr>
                            <td>Judul Buku</td>
                            <td>: <?php echo $judulBuku; ?></td>
                        </tr>
                        <tr>
                            <td>Harga Satuan</td>
                            <td>: Rp <?php echo number_format($hargaSatuan, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Beli</td>
                            <td>: <?php echo $jumlahBeli; ?> buku</td>
                        </tr>
                        <tr>
                            <td>Status Member</td>
                            <td>: <?php echo $isMember ? 'Member' : 'Non-Member'; ?></td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td>: Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>Diskon (<?php echo $persentaseDiskon * 100; ?>%)</td>
                            <td>: Rp <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                        </tr>
                        <?php if ($isMember): ?>
                        <tr>
                            <td>Diskon Member (5%)</td>
                            <td>: Rp <?php echo number_format($diskonMember, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Total Setelah Diskon</td>
                            <td>: Rp <?php echo number_format($total_setelah_diskon, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>PPN</td>
                            <td>: Rp <?php echo number_format($ppn, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="mt-3">Total Akhir: <span class="badge bg-secondary">Rp <?php echo number_format($total_akhir,0,',','.'); ?></span></h5>
                <p>Total Hemat: <span class="badge bg-primary">Rp <?php echo number_format($total_hemat,0,',','.'); ?></span></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
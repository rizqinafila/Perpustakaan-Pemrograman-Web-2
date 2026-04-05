<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php 
        // Data Anggota
        $namaAnggota = "Budi Santoso";
        $totalPinjam = 2;
        $bukuTerlambat = 1;
        $hariKeterlambatan = 5;

        //denda
        $dendaPerHari = 1000;
        $maxDenda = 50000;
        $totalDenda = 0;

        if($bukuTerlambat > 0){
            $totalDenda = $bukuTerlambat * $hariKeterlambatan * $dendaPerHari;

            if ($totalDenda > $maxDenda){
                $totalDenda = $maxDenda;
            }
        }

         //status pinjam
        if ($bukuTerlambat > 0){
            $status = "TIdak bisa meminjam (ada keterlambatan)";
            $badge = "danger";
        } elseif ($totalPinjam >= 3){
            $status = "Tidak bisa meminjam (maksimal tercapai)";
        }else {
            $status = "Bisa meminjam buku";
            $badge = "success";
        }

        // Level Member
        switch (true){
            case ($totalPinjam <= 5);
                $level = "Broze";
                break;
            case ($totalPinjam <= 15);
                $level = "Silver";
                break;
            default:
                $level = "Gold";
        }
        ?>

        <h2>Status Peminjaman Anggota</h2>
        <div class="card mt-3">
            <div class="card-body">
                <p><strong>Nama:</strong> <?php echo $namaAnggota; ?></p>
                <p><strong>Total Pinjaman:</strong> <?php echo $totalPinjam; ?></p>
                <p><strong>Buku Terlambat:</strong> <?php echo $bukuTerlambat; ?></p>
                <p><strong>Hari Keterlambatan:</strong> <?php echo $hariKeterlambatan; ?></p>
                <p><strong>Level Member:</strong> <?php echo $level; ?></p>
            </div>
        </div>

        <div class="mt-3">
            <span class="badge bg-<?php echo $badge; ?>">
                <?php $status; ?>
            </span>
        </div>

        <?php if ($bukuTerlambat > 0): ?>
            <div class="alert alert-danger mt-3">
                <strong>Peringatan!</strong> Anda memiliki keterlambatan. <br>
                Total denda: Rp <?php echo number_format($totalDenda,0,',','.'); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
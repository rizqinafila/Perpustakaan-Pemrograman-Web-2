<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'functions_anggota.php';

    // data
    $anggota_list = [
        ["id"=>"AGT-001","nama"=>"Lilbah","email"=>"lilbah@email.com","status"=>"Aktif","tanggal_daftar"=>"2024-01-10","total_pinjaman"=>5],
        ["id"=>"AGT-002","nama"=>"Sahroni","email"=>"sahroni@email.com","status"=>"Aktif","tanggal_daftar"=>"2024-02-01","total_pinjaman"=>8],
        ["id"=>"AGT-003","nama"=>"Prabroro","email"=>"pororo@email.com","status"=>"Non-Aktif","tanggal_daftar"=>"2023-12-20","total_pinjaman"=>2],
        ["id"=>"AGT-004","nama"=>"Dodo","email"=>"dodo@email.com","status"=>"Aktif","tanggal_daftar"=>"2024-03-05","total_pinjaman"=>10],
        ["id"=>"AGT-005","nama"=>"Dedi","email"=>"dedi@email.com","status"=>"Non-Aktif","tanggal_daftar"=>"2024-01-25","total_pinjaman"=>1]
    ];

    // Statistik
    $total = hitung_total_anggota($anggota_list);
    $aktif = hitung_anggota_aktif($anggota_list);
    $rata = hitung_rata_rata_pinjaman($anggota_list);
    $teraktif = cari_anggota_teraktif($anggota_list);

    $anggota_aktif = filter_by_status($anggota_list, "Aktif");
    $anggota_nonaktif = filter_by_status($anggota_list, "Non-Aktif");

    $sorted = sort_by_nama($anggota_list);
    $search = search_by_nama($anggota_list, "i");
    ?>

    <div class="container mt-5">
        <h2 class="mb-4">Sistem Anggota</h2>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <h5>Total</h5>
                    <h2><?php echo $total; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <h5>Aktif</h5>
                    <h2><?php echo $aktif; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <h5>Rata Pinjaman</h5>
                    <h2><?php echo number_format($rata,1); ?></h2>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Daftar Anggota</div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th><th>Nama</th><th>Status</th><th>Tanggal</th><th>Pinjaman</th>
                    </tr>
                    <?php foreach ($sorted as $a): ?>
                    <tr>
                        <td><?php echo $a["id"]; ?></td>
                        <td><?php echo $a["nama"]; ?></td>
                        <td><?php echo $a["status"]; ?></td>
                        <td><?php echo format_tanggal_indo($a["tanggal_daftar"]); ?></td>
                        <td><?php echo $a["total_pinjaman"]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Anggota Teraktif</div>
            <div class="card-body">
                <strong><?php echo $teraktif["nama"]; ?></strong><br>
                Total Pinjaman: <?php echo $teraktif["total_pinjaman"]; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h5>Aktif</h5>
                <ul>
                    <?php foreach ($anggota_aktif as $a): ?>
                        <li><?php echo $a["nama"]; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-6">
                <h5>Non-Aktif</h5>
                <ul>
                    <?php foreach ($anggota_nonaktif as $a): ?>
                        <li><?php echo $a["nama"]; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="mt-4">
            <h5>Hasil Search (keyword: "i")</h5>
            <ul>
                <?php foreach ($search as $a): ?>
                    <li><?php echo $a["nama"]; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <h2 class="mb-4">Data Anggota Perpustakaan</h2>

        <?php
        // data anggota
        $anggota_list = [
            [
                "id" => "AGT-001",
                "nama" => "Lilbah Lahadalia",
                "email" => "lilbah@gmail.com",
                "telepon" => "081234567890",
                "alamat" => "Maluku",
                "tanggal_daftar" => "2024-01-15",
                "status" => "Aktif",
                "total_pinjaman" => 5
            ],
            [
                "id" => "AGT-002",
                "nama" => "Ahmad Sahroni",
                "email" => "sahroni@gmail.com",
                "telepon" => "082345678901",
                "alamat" => "Bandung",
                "tanggal_daftar" => "2024-02-10",
                "status" => "Aktif",
                "total_pinjaman" => 8
            ],
            [
                "id" => "AGT-003",
                "nama" => "Subianto Prabroro",
                "email" => "pororo@gmail.com",
                "telepon" => "083456789012",
                "alamat" => "Jakarta",
                "tanggal_daftar" => "2023-12-05",
                "status" => "Non-Aktif",
                "total_pinjaman" => 2
            ],
            [
                "id" => "AGT-004",
                "nama" => "Widodo Joko",
                "email" => "dodo@gmail.com",
                "telepon" => "084567890123",
                "alamat" => "Surakarta",
                "tanggal_daftar" => "2024-03-01",
                "status" => "Aktif",
                "total_pinjaman" => 10
            ],
            [
                "id" => "AGT-005",
                "nama" => "Dedi Mulyadi",
                "email" => "dedi@gmail.com",
                "telepon" => "085678901234",
                "alamat" => "Bandung",
                "tanggal_daftar" => "2024-01-25",
                "status" => "Non-Aktif",
                "total_pinjaman" => 1
            ]
        ];

        // statistik
        $total_anggota = count($anggota_list);
        $aktif = 0;
        $nonaktif = 0;
        $total_pinjaman = 0;

        $teraktif = $anggota_list[0];

        foreach ($anggota_list as $anggota) {
            // hitung status
            if ($anggota["status"] == "Aktif") {
                $aktif++;
            } else {
                $nonaktif++;
            }

            // total pinjaman
            $total_pinjaman += $anggota["total_pinjaman"];

            // cari paling aktif
            if ($anggota["total_pinjaman"] > $teraktif["total_pinjaman"]) {
                $teraktif = $anggota;
            }
        }

        $persen_aktif = ($aktif / $total_anggota) * 100;
        $persen_nonaktif = ($nonaktif / $total_anggota) * 100;
        $rata_pinjaman = $total_pinjaman / $total_anggota;

        // filter aktif
        $anggota_aktif = [];
        foreach ($anggota_list as $anggota) {
            if ($anggota["status"] == "Aktif") {
                $anggota_aktif[] = $anggota;
            }
        }
        ?>

        <!-- cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-primary text-center">
                    <div class="card-body">
                        <h5>Total Anggota</h5>
                        <h2 class="text-primary"><?php echo $total_anggota; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-success text-center">
                    <div class="card-body">
                        <h5>Aktif</h5>
                        <h2 class="text-success"><?php echo number_format($persen_aktif,1); ?>%</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-danger text-center">
                    <div class="card-body">
                        <h5>Non-Aktif</h5>
                        <h2 class="text-danger"><?php echo number_format($persen_nonaktif,1); ?>%</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-warning text-center">
                    <div class="card-body">
                        <h5>Rata Pinjaman</h5>
                        <h2 class="text-warning"><?php echo number_format($rata_pinjaman,1); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- teraktif -->
        <div class="alert alert-info">
            <strong>Anggota Teraktif:</strong> 
            <?php echo $teraktif["nama"]; ?> 
            (<?php echo $teraktif["total_pinjaman"]; ?> pinjaman)
        </div>

        <!-- tabel -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Semua Anggota
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Total Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($anggota_list as $anggota): ?>
                        <tr>
                            <td><?php echo $anggota["id"]; ?></td>
                            <td><?php echo $anggota["nama"]; ?></td>
                            <td><?php echo $anggota["email"]; ?></td>
                            <td>
                                <?php if ($anggota["status"] == "Aktif"): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $anggota["total_pinjaman"]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- filter aktif -->
        <div class="card">
            <div class="card-header bg-success text-white">
                Anggota Aktif
            </div>
            <div class="card-body">
                <ul>
                    <?php foreach ($anggota_aktif as $a): ?>
                        <li><?php echo $a["nama"]; ?> (<?php echo $a["total_pinjaman"]; ?> pinjaman)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><i class="bi bi-bookmark"></i> Kategori Buku Perpustakaan</h1>

        <div class="row">
            <?php 
            $buku_list = [
                ["judul" => "PHP Programming", "kategori" => "Programming"],
                ["judul" => "MySQL Database", "kategori" => "Database"],
                ["judul" => "Web Design Principles", "kategori" => "Web Design"],
                ["judul" => "Network Security", "kategori" => "Networking"],
                ["judul" => "Digital Marketing", "kategori" => "Marketing"],
                ["judul" => "Data Science with Python", "kategori" => "Programming"]
            ];

            foreach ($buku_list as $buku):
                switch ($buku["kategori"]) {
                    case "Programming":
                        $warna = "primary";
                        $icon = "code-slash";
                        $deskripsi = "Buku tentang bahasa pemrograman dan software";
                        break;
                    case "Database":
                        $warna = "success";
                        $icon = "database";
                        $deskripsi = "Buku tentang database";
                        break;
                    case "Web Design":
                        $warna = "info";
                        $icon = "palette";
                        $deskripsi = "Buku desain UI/UX";
                        break;
                    case "Networking":
                        $warna = "warning";
                        $icon = "wifi";
                        $deskripsi = "Buku jaringan komputer";
                        break;
                    case "Marketing":
                        $warna = "danger";
                        $icon = "megaphone";
                        $deskripsi = "Buku pemasaran digital";
                        break;
                    default:
                        $warna = "secondary";
                        $icon = "book";
                        $deskripsi = "Kategori umum";
                }
            ?>
            <div class="col-md-6 mb-3">
                <div class="card border-<?php echo $warna; ?>">
                    <div class="card-header bg-<?php echo $warna; ?> text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-<?php echo $icon; ?>"></i>
                            <?php echo $buku["judul"]; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-<?php echo $warna; ?>">
                            <?php echo $buku["kategori"]; ?>
                        </span>
                        <p class="text-muted mt-2"><small><?php echo $deskripsi; ?></small></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Statistik -->
        <?php
        $total = [
            "Programming" => 0,
            "Database" => 0,
            "Web Design" => 0,
            "Networking" => 0,
            "Marketing" => 0,
            "Lainnya" => 0
        ];

        foreach ($buku_list as $buku) {
            if (isset($total[$buku["kategori"]])) {
                $total[$buku["kategori"]]++;
            } else {
                $total["Lainnya"]++;
            }
        }
        ?>

        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                Statistik Kategori
            </div>
            <div class="card-body">
                <?php foreach ($total as $kategori => $jumlah): ?>
                    <p><?php echo $kategori; ?>: <?php echo $jumlah; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>